import { NextResponse } from "next/server";
import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import prisma from "@/lib/prisma";
import { computeAiMatch } from "@/lib/ai-matcher";

export async function GET(req: Request) {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
    }

    const { searchParams } = new URL(req.url);
    const search = searchParams.get("search") || "";
    const location = searchParams.get("location") || "";

    const user = session.user as any;
    const currentAlumniId = parseInt(user.id);

    try {
        const [alumni, jobsList] = await Promise.all([
            prisma.alumni.findUnique({
                where: { id: currentAlumniId },
            }),
            prisma.jobs.findMany({
                where: {
                    AND: [
                        {
                            OR: [
                                { job_title: { contains: search } },
                                { company: { contains: search } },
                            ],
                        },
                        { location: { contains: location } },
                    ],
                },
                orderBy: { created_at: "desc" },
            }),
        ]);

        const jobsWithMatch = jobsList.map((job) => ({
            ...job,
            matchScore: computeAiMatch(alumni, job),
        }));

        return NextResponse.json(jobsWithMatch);
    } catch (error) {
        console.error("Error fetching jobs:", error);
        return NextResponse.json({ error: "Internal Server Error" }, { status: 500 });
    }
}
