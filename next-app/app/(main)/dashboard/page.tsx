import { getServerSession } from "next-auth/next";
import { authOptions } from "@/lib/auth";
import { redirect } from "next/navigation";
import prisma from "@/lib/prisma";
import AlumniDashboard from "@/components/AlumniDashboard";
import AdminDashboard from "@/components/AdminDashboard";

export default async function DashboardPage() {
    const session = await getServerSession(authOptions);

    if (!session || !session.user) {
        redirect("/login");
    }

    const user = session.user as any;

    if (user.role === "administrator") {
        const [totalEvents, totalPosts, totalJobs, totalAlumni, totalAccounts, activeUsers, inactiveUsers] = await Promise.all([
            prisma.events.count(),
            prisma.post.count(),
            prisma.jobs.count(),
            prisma.alumni.count(),
            prisma.admin_users.count(),
            prisma.alumni.count({ where: { status: "active" } }),
            prisma.alumni.count({ where: { status: "inactive" } }),
        ]);

        return (
            <AdminDashboard
                stats={{
                    totalEvents,
                    totalPosts,
                    totalJobs,
                    totalAlumni,
                    totalAccounts,
                    activeUsers,
                    inactiveUsers,
                }}
            />
        );
    }

    return <AlumniDashboard />;
}
