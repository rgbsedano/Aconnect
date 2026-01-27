"use client";

import React from "react";
import Link from "next/link";
import { Doughnut } from "react-chartjs-2";
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
} from "chart.js";

ChartJS.register(ArcElement, Tooltip, Legend);

interface AdminDashboardProps {
    stats: {
        totalEvents: number;
        totalPosts: number;
        totalJobs: number;
        totalAlumni: number;
        totalAccounts: number;
        activeUsers: number;
        inactiveUsers: number;
    };
}

const AdminDashboard = ({ stats }: AdminDashboardProps) => {
    const chartData = {
        labels: ["Active Members", "Inactive Members"],
        datasets: [
            {
                data: [stats.activeUsers, stats.inactiveUsers],
                backgroundColor: ["#057642", "#d11124"],
                hoverOffset: 4,
                borderWidth: 0,
            },
        ],
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        cutout: "70%",
        plugins: {
            legend: {
                position: "bottom" as const,
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 13 },
                },
            },
        },
    };

    const widgets = [
        { label: "Total Events", value: stats.totalEvents, icon: "/assets/icons/events.png", href: "/admin/events" },
        { label: "Feed Posts", value: stats.totalPosts, icon: "/assets/icons/post.png", href: "/admin/posts" },
        { label: "Active Jobs", value: stats.totalJobs, icon: "/assets/icons/job.png", href: "/admin/jobs" },
        { label: "Alumni Directory", value: stats.totalAlumni, icon: "/assets/icons/user.svg", href: "/admin/alumni" },
        { label: "System Accounts", value: stats.totalAccounts, icon: "/assets/icons/user.svg", href: "/admin/accounts" },
    ];

    return (
        <div className="max-w-[1128px] mx-auto px-4 py-8 font-sans">
            <section className="bg-white border border-[#e0e0e0] rounded-lg p-6 mb-6 shadow-sm">
                <div className="flex justify-between items-center mb-5 pb-3 border-b border-[#f0f0f0]">
                    <h2 className="text-xl font-semibold text-black/90 flex items-center gap-2">
                        <i className="fas fa-chart-pie text-[#700A0A]"></i> Alumni Analytics
                    </h2>
                    <span className="text-gray-500 text-xs">Real-time status</span>
                </div>

                <div className="flex justify-center py-5">
                    <div className="w-full max-w-[350px]">
                        <Doughnut data={chartData} options={chartOptions} />
                    </div>
                </div>
            </section>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                {widgets.map((widget) => (
                    <div key={widget.label} className="bg-white border border-[#e0e0e0] rounded-lg p-4 flex flex-col justify-between hover:shadow-lg transition-shadow">
                        <div className="flex items-center mb-3">
                            <div className="w-12 h-12 bg-[#f3f2ef] rounded flex items-center justify-center mr-3">
                                <img
                                    src={widget.icon}
                                    alt={widget.label}
                                    className="w-6 h-6 object-contain"
                                    onError={(e) => {
                                        (e.target as HTMLImageElement).src = "https://placehold.co/24x24?text=" + widget.label[0];
                                    }}
                                />
                            </div>
                            <div className="flex-grow">
                                <span className="block text-sm font-semibold text-black/60">{widget.label}</span>
                                <span className="block text-2xl font-bold text-black/90">{widget.value}</span>
                            </div>
                        </div>
                        <Link
                            href={widget.href}
                            className="mt-4 px-4 py-1.5 border border-[#700A0A] text-[#700A0A] rounded-full text-sm font-semibold text-center hover:bg-[#700A0A]/5 hover:border-2 hover:px-[15px] hover:py-1 transition-all"
                        >
                            Manage
                        </Link>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default AdminDashboard;
