"use client";

import React, { useState, useEffect } from "react";
import { useSession } from "next-auth/react";
import AlumniCard from "@/components/AlumniCard";

export default function NetworkPage() {
    const { data: session } = useSession();
    const [alumni, setAlumni] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState("");
    const [filter, setFilter] = useState("all");

    useEffect(() => {
        fetchAlumni();
    }, []);

    const fetchAlumni = async () => {
        setLoading(true);
        try {
            const res = await fetch("/api/alumni");
            const data = await res.json();
            if (!data.error) {
                setAlumni(data);
            }
        } catch (error) {
            console.error("Failed to fetch alumni:", error);
        } finally {
            setLoading(false);
        }
    };

    const filteredAlumni = alumni.filter((a) => {
        const matchesSearch =
            a.first_name.toLowerCase().includes(search.toLowerCase()) ||
            a.last_name.toLowerCase().includes(search.toLowerCase()) ||
            a.degree.toLowerCase().includes(search.toLowerCase());

        if (filter === "all") return matchesSearch;
        return matchesSearch && a.connectionStatus === filter;
    });

    if (loading) {
        return (
            <div className="flex justify-center items-center min-h-[400px]">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#BE123C]"></div>
            </div>
        );
    }

    return (
        <div className="bg-[#F8FAFC] min-h-screen antialiased font-jakarta pb-20">
            <nav className="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
                <div className="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-[#8B1538] rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">
                            <svg className="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 className="text-xl font-bold tracking-tight text-slate-900">
                                Alumni <span className="text-[#8B1538]">Network</span>
                            </h1>
                            <p className="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">AConnect Community Hub</p>
                        </div>
                    </div>
                    <div className="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
                        {filteredAlumni.length} Alumni
                    </div>
                </div>
            </nav>

            <main className="max-w-6xl mx-auto px-6 py-12">
                <div className="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 mb-12 flex flex-col md:flex-row gap-2">
                    <div className="flex-grow flex items-center px-4 gap-3 border-r border-slate-100">
                        <svg className="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            placeholder="Search by name, degree, or skills..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="w-full py-3 bg-transparent outline-none text-sm font-medium"
                        />
                    </div>
                    <div className="flex gap-2 p-1">
                        {[
                            { id: "all", label: "All" },
                            { id: "connectable", label: "Discover" },
                            { id: "pending", label: "Pending" },
                            { id: "accepted", label: "Linked" },
                        ].map((f) => (
                            <button
                                key={f.id}
                                onClick={() => setFilter(f.id)}
                                className={`text-xs font-bold px-4 py-2 rounded-xl transition ${filter === f.id
                                        ? "bg-[#8B1538] text-white shadow-md shadow-rose-100"
                                        : "bg-slate-50 text-slate-600 hover:bg-slate-100"
                                    }`}
                            >
                                {f.label}
                            </button>
                        ))}
                    </div>
                </div>

                {filteredAlumni.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {filteredAlumni.map((alumnus) => (
                            <AlumniCard key={alumnus.id} alumnus={alumnus} onAction={fetchAlumni} />
                        ))}
                    </div>
                ) : (
                    <div className="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                        <h3 className="text-lg font-bold text-slate-900">No matching alumni found</h3>
                        <p className="text-slate-500 text-sm mt-1">Try adjusting your filters or search terms.</p>
                    </div>
                )}
            </main>
        </div>
    );
}
