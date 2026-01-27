import { NextResponse } from "next/server";
import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/prisma";

export async function POST(req: Request) {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    const user = session.user as any;
    const currentAlumniId = parseInt(user.id);
    const { action, targetId, requestId } = await req.json();

    try {
        switch (action) {
            case "send_request":
                await prisma.connection_requests.create({
                    data: {
                        sender_id: currentAlumniId,
                        receiver_id: targetId,
                        status: "pending",
                    },
                });
                return NextResponse.json({ message: "Request sent" });

            case "cancel_request":
                await prisma.connection_requests.deleteMany({
                    where: {
                        sender_id: currentAlumniId,
                        receiver_id: targetId,
                        status: "pending",
                    },
                });
                return NextResponse.json({ message: "Request canceled" });

            case "accept_request":
                // Create actual connection
                await prisma.connections.create({
                    data: {
                        sender_id: targetId, // Original sender
                        receiver_id: currentAlumniId, // Me
                        status: "accepted",
                    },
                });
                // Delete request
                await prisma.connection_requests.delete({
                    where: { id: requestId },
                });
                return NextResponse.json({ message: "Request accepted" });

            case "decline_request":
                await prisma.connection_requests.delete({
                    where: { id: requestId },
                });
                return NextResponse.json({ message: "Request declined" });

            case "remove_connection":
                await prisma.connections.deleteMany({
                    where: {
                        OR: [
                            { sender_id: currentAlumniId, receiver_id: targetId },
                            { sender_id: targetId, receiver_id: currentAlumniId },
                        ],
                    },
                });
                return NextResponse.json({ message: "Connection removed" });

            default:
                return NextResponse.json({ error: "Invalid action" }, { status: 400 });
        }
    } catch (error) {
        console.error("Connection action error:", error);
        return NextResponse.json({ error: "Action failed" }, { status: 500 });
    }
}
