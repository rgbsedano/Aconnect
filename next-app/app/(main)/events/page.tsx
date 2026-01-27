"use client";

import React, { useState, useEffect } from "react";
import EventCard from "@/components/EventCard";

export default function EventsPage() {
    const [events, setEvents] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState("");
    const [filter, setFilter] = useState("all");
    const [sort, setSort] = useState("closest");

    useEffect(() => {
        fetchEvents();
    }, []);

    const fetchEvents = async () => {
        setLoading(true);
        try {
            const res = await fetch("/api/events");
            const data = await res.json();
            if (!data.error) {
                setEvents(data);
            }
        } catch (error) {
            console.error("Failed to fetch events:", error);
        } finally {
            setLoading(false);
        }
    };

    const filteredEvents = events
        .filter((e) => {
            const matchesSearch =
                e.event_name.toLowerCase().includes(search.toLowerCase()) ||
                (e.description && e.description.toLowerCase().includes(search.toLowerCase()));
            const matchesFilter = filter === "all" || e.event_type?.toLowerCase() === filter;
            return matchesSearch && matchesFilter;
        })
        .sort((a, b) => {
            const dateA = new Date(a.event_date).getTime();
            const dateB = new Date(b.event_date).getTime();
            return sort === "closest" ? dateA - dateB : dateB - dateA;
        });

    return (
        <div className="bg-[#F8FAFC] min-h-screen antialiased font-jakarta pb-20">
            <nav className="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
                <div className="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-rose-700 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">
                            <svg className="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 2a2 2 0 00-2 2v1h10V4a2 2 0 00-2-2H7zM5 7a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <h1 className="text-xl font-bold tracking-tight text-slate-900">
                                Upcoming <span className="text-rose-700">Events</span>
                            </h1>
                            <p className="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">
                                Opportunities Portal 2026
                            </p>
                        </div>
                    </div>
                    <div className="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
                        {filteredEvents.length} Events
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
                            placeholder="Search events, workshops, or topics..."
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="w-full py-3 bg-transparent outline-none text-sm font-medium"
                        />
                    </div>
                    <div className="flex gap-2 p-1">
                        <select
                            value={filter}
                            onChange={(e) => setFilter(e.target.value)}
                            className="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer"
                        >
                            <option value="all">All Categories</option>
                            <option value="workshop">Workshop</option>
                            <option value="networking">Networking</option>
                            <option value="hackathon">Hackathon</option>
                            <option value="conference">Conference</option>
                        </select>
                        <select
                            value={sort}
                            onChange={(e) => setSort(e.target.value)}
                            className="bg-slate-50 border-none text-slate-600 text-xs font-bold py-2 px-4 rounded-xl outline-none focus:ring-2 focus:ring-rose-700/20 cursor-pointer"
                        >
                            <option value="closest">Soonest First</option>
                            <option value="farthest">Latest First</option>
                        </select>
                        <button
                            onClick={() => {
                                setSearch("");
                                setFilter("all");
                                setSort("closest");
                            }}
                            className="bg-rose-700 text-white text-xs font-bold px-6 py-2 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100"
                        >
                            Reset
                        </button>
                    </div>
                </div>

                {loading ? (
                    <div className="flex justify-center py-20">
                        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-rose-700"></div>
                    </div>
                ) : (
                    <div className="space-y-4">
                        {filteredEvents.length > 0 ? (
                            filteredEvents.map((event) => (
                                <EventCard key={event.id} event={event} onAction={fetchEvents} />
                            ))
                        ) : (
                            <div className="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                                <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg className="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 className="text-lg font-bold text-slate-900">No upcoming events found</h3>
                                <p className="text-slate-500 text-sm mt-1">Try adjusting your filters or check back later.</p>
                            </div>
                        )}
                    </div>
                )}
            </main>
        </div>
    );
}
