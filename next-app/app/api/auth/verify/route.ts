import { NextRequest, NextResponse } from "next/server";
import prisma from "@/lib/prisma";

export async function GET(req: NextRequest) {
    const { searchParams } = new URL(req.url);
    const token = searchParams.get("token");

    if (!token) {
        return NextResponse.json({ message: "Missing token" }, { status: 400 });
    }

    try {
        const user = await prisma.alumni.findFirst({
            where: { verification_token: token },
        });

        if (!user) {
            return new NextResponse("Invalid or expired token.", { status: 400 });
        }

        await prisma.alumni.update({
            where: { id: user.id },
            data: {
                email_verified: true,
                status: "active",
                verification_token: null,
            },
        });

        // Redirect to login with success message
        return NextResponse.redirect(
            new URL("/login?verified=true", req.url)
        );
    } catch (error) {
        console.error("Verification error:", error);
        return new NextResponse("Internal Server Error", { status: 500 });
    }
}
