import { NextResponse } from "next/server";
import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/prisma";

export async function GET(request: Request) {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    const user = session.user as any;
    const currentAlumniId = parseInt(user.id);

    // Get query parameter to determine if we want past or upcoming events
    const { searchParams } = new URL(request.url);
    const showPast = searchParams.get("past") === "true";

    try {
        const [eventsList, registrations] = await Promise.all([
            prisma.events.findMany({
                where: showPast
                    ? { event_date: { lt: new Date() } }  // Past events
                    : { event_date: { gte: new Date() } }, // Upcoming events (including today)
                orderBy: { event_date: showPast ? "desc" : "asc" },
            }),
            prisma.event_registrations.findMany({
                where: { alumni_id: currentAlumniId },
            }),
        ]);

        const registeredEventIds = new Set(registrations.map((r) => r.event_id));

        const eventsWithStatus = eventsList.map((event) => ({
            ...event,
            isRegistered: registeredEventIds.has(event.id),
        }));

        return NextResponse.json(eventsWithStatus);
    } catch (error) {
        console.error("Error fetching events:", error);
        return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
    }
}
