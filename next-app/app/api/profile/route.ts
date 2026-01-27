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
        const alumni = await prisma.alumni.findUnique({
            where: { id: currentAlumniId },
            include: {
                employment: true,
            },
        });

        if (!alumni) {
            return NextResponse.json({ error: "Alumni not found" }, { status: 404 });
        }

        return NextResponse.json(alumni);
    } catch (error) {
        console.error("Error fetching profile:", error);
        return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
    }
}
