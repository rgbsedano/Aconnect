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
    const data = await req.json();

    try {
        const { type, ...payload } = data;

        if (type === "basic") {
            await prisma.alumni.update({
                where: { id: currentAlumniId },
                data: {
                    first_name: payload.first_name,
                    last_name: payload.last_name,
                    degree: payload.degree,
                    graduation_year: parseInt(payload.graduation_year),
                    phone: payload.phone,
                    alternative_phone: payload.alternative_phone,
                    email: payload.email,
                    alternative_email: payload.alternative_email,
                },
            });
        } else if (type === "employment") {
            // Find existing employment or create new
            const existing = await prisma.employment.findFirst({
                where: { alumni_id: currentAlumniId },
            });

            if (existing) {
                await prisma.employment.update({
                    where: { id: existing.id },
                    data: {
                        employment_status: payload.employment_status,
                        job_title: payload.job_title,
                        company_name: payload.company_name,
                        job_description: payload.job_description,
                        year_of_service: parseInt(payload.year_of_service),
                        promotion_count: parseInt(payload.promotion_count),
                    },
                });
            } else {
                await prisma.employment.create({
                    data: {
                        alumni_id: currentAlumniId,
                        employment_status: payload.employment_status,
                        job_title: payload.job_title,
                        company_name: payload.company_name,
                        job_description: payload.job_description,
                        year_of_service: parseInt(payload.year_of_service),
                        promotion_count: parseInt(payload.promotion_count),
                    },
                });
            }
        } else if (type === "skills") {
            await prisma.alumni.update({
                where: { id: currentAlumniId },
                data: {
                    soft_skills: Array.isArray(payload.soft_skills) ? payload.soft_skills.join(",") : payload.soft_skills,
                    technical_skills: Array.isArray(payload.technical_skills) ? payload.technical_skills.join(",") : payload.technical_skills,
                },
            });
        }

        return NextResponse.json({ status: "success" });
    } catch (error) {
        console.error("Profile update error:", error);
        return NextResponse.json({ error: "Update failed" }, { status: 500 });
    }
}
