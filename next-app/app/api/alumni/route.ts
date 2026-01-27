import { NextResponse } from "next/server";
import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/prisma";

export async function GET() {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    const user = session.user as any;
    const currentAlumniId = parseInt(user.id);

    try {
        const alumniList = await prisma.alumni.findMany({
            where: {
                id: { not: currentAlumniId }, // Don't show current user
                status: "active",
            },
            select: {
                id: true,
                first_name: true,
                last_name: true,
                degree: true,
                graduation_year: true,
                profile_image: true,
                gender: true,
                current_job: true,
                email: true,
                technical_skills: true,
            },
        });

        // Fetch existing connections and requests for the current user
        const [requests, connections] = await Promise.all([
            prisma.connection_requests.findMany({
                where: {
                    OR: [{ sender_id: currentAlumniId }, { receiver_id: currentAlumniId }],
                },
            }),
            prisma.connections.findMany({
                where: {
                    OR: [{ sender_id: currentAlumniId }, { receiver_id: currentAlumniId }],
                },
            }),
        ]);

        // Map status to each alumni
        const formattedAlumni = alumniList.map((alumnus) => {
            let connectionStatus = "connectable";
            let requestId = null;
            let senderId = null;

            const request = requests.find(
                (r) =>
                    (r.sender_id === currentAlumniId && r.receiver_id === alumnus.id) ||
                    (r.sender_id === alumnus.id && r.receiver_id === currentAlumniId)
            );

            const connection = connections.find(
                (c) =>
                    (c.sender_id === currentAlumniId && c.receiver_id === alumnus.id) ||
                    (c.sender_id === alumnus.id && c.receiver_id === currentAlumniId)
            );

            if (connection && connection.status === "accepted") {
                connectionStatus = "accepted";
            } else if (request && request.status === "pending") {
                connectionStatus = "pending";
                requestId = request.id;
                senderId = request.sender_id;
            }

            return {
                ...alumnus,
                connectionStatus,
                requestId,
                senderId,
            };
        });

        return NextResponse.json(formattedAlumni);
    } catch (error) {
        console.error("Error fetching alumni:", error);
        return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
    }
}
