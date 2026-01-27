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
    const { eventId } = await req.json();

    try {
        // Check if already registered
        const existing = await prisma.event_registrations.findFirst({
            where: {
                event_id: eventId,
                alumni_id: currentAlumniId,
            },
        });

        if (existing) {
            return NextResponse.json({ error: "Already registered" }, { status: 400 });
        }

        await prisma.event_registrations.create({
            data: {
                event_id: eventId,
                alumni_id: currentAlumniId,
            },
        });

        return NextResponse.json({ message: "Registered successfully" });
    } catch (error) {
        console.error("Event registration error:", error);
        return NextResponse.json({ error: "Registration failed" }, { status: 500 });
    }
}
