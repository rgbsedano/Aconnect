import { NextResponse } from "next/server";
import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/prisma";

export async function GET(req: Request) {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    const user = session.user as any;
    const currentAlumniId = parseInt(user.id);

    const { searchParams } = new URL(req.url);
    const friendId = searchParams.get("friendId");

    try {
        if (friendId) {
            // Fetch messages between current user and friend
            const messages = await prisma.messages.findMany({
                where: {
                    OR: [
                        { sender_id: currentAlumniId, receiver_id: parseInt(friendId) },
                        { sender_id: parseInt(friendId), receiver_id: currentAlumniId },
                    ],
                },
                orderBy: { sent_at: "asc" },
            });
            return NextResponse.json(messages);
        } else {
            // Fetch connections (friends)
            const connections = await prisma.connections.findMany({
                where: {
                    OR: [{ sender_id: currentAlumniId }, { receiver_id: currentAlumniId }],
                    status: "accepted",
                },
                include: {
                    alumni_connections_sender_idToalumni: true,
                    alumni_connections_receiver_idToalumni: true,
                },
            });

            const friends = connections.map((c) => {
                const isSender = c.sender_id === currentAlumniId;
                const friend = isSender ? c.alumni_connections_receiver_idToalumni : c.alumni_connections_sender_idToalumni;
                return {
                    id: friend.id,
                    first_name: friend.first_name,
                    last_name: friend.last_name,
                    profile_image: friend.profile_image,
                    gender: friend.gender,
                };
            });

            return NextResponse.json(friends);
        }
    } catch (error) {
        console.error("Error fetching messages/friends:", error);
        return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
    }
}
