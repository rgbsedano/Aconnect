"use client";

import React, { useState } from "react";

interface EventCardProps {
    event: any;
    onAction: () => void;
}

const EventCard = ({ event, onAction }: EventCardProps) => {
    const [showModal, setShowModal] = useState(false);
    const [loading, setLoading] = useState(false);

    const handleRegister = async (e: React.FormEvent) => {
        e.stopPropagation();
        setLoading(true);
        try {
            const res = await fetch("/api/events/register", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ eventId: event.id }),
            });
            if (res.ok) {
                onAction();
            }
        } catch (error) {
            console.error("Registration failed:", error);
        } finally {
            setLoading(false);
        }
    };

    const timeUntil = (dateString: string) => {
        const now = new Date();
        const future = new Date(dateString);
        const diff = future.getTime() - now.getTime();
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        if (days === 0) return "Starting Today";
        if (days === 1) return "Starts Tomorrow";
        return `In ${days} days`;
    };

    const date = new Date(event.event_date);
    const dateStr = date.toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" });
    const fullDateStr = date.toLocaleString("en-US", { dateStyle: "full", timeStyle: "short" });

    return (
        <>
            <div
                onClick={() => setShowModal(true)}
                className="bg-white p-5 rounded-2xl flex flex-col md:flex-row items-start md:items-center gap-6 cursor-pointer border border-slate-200 hover:-translate-y-1 hover:border-amber-600 hover:shadow-lg transition-all animate-in fade-in slide-in-from-bottom-4 duration-300"
            >
                <div className="w-16 h-16 rounded-2xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                    {event.image ? (
                        <img src={`/assets/uploads/events/${event.image}`} className="w-full h-full object-cover" />
                    ) : (
                        <div className="w-full h-full flex items-center justify-center text-rose-700 font-bold text-xl uppercase">
                            {event.event_name.charAt(0)}
                        </div>
                    )}
                </div>

                <div className="flex-grow">
                    <div className="flex items-center gap-2 mb-1">
                        <span className="text-[10px] font-extrabold uppercase tracking-widest text-amber-600">
                            {event.event_type || "General"}
                        </span>
                        <span className="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span className="text-xs font-bold text-rose-700">{timeUntil(event.event_date)}</span>
                    </div>
                    <h3 className="text-lg font-bold text-slate-900 group-hover:text-rose-700">{event.event_name}</h3>
                    <div className="flex items-center gap-4 mt-2">
                        <div className="flex items-center gap-1 text-slate-500 text-xs">
                            <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {dateStr}
                        </div>
                        <div className="flex items-center gap-1 text-slate-500 text-xs">
                            <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17.657 16.727L12 21l-5.657-4.273A8 8 0 1117.657 16.727z" />
                            </svg>
                            {event.location || "Remote"}
                        </div>
                    </div>
                </div>

                <div className="flex items-center gap-3 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-slate-50">
                    {event.isRegistered ? (
                        <button
                            disabled
                            className="w-full bg-emerald-600 text-white text-xs font-bold px-6 py-2.5 rounded-xl flex items-center justify-center gap-2 cursor-default"
                        >
                            <svg className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg>
                            Registered
                        </button>
                    ) : (
                        <button
                            onClick={handleRegister}
                            disabled={loading}
                            className="w-full bg-rose-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100"
                        >
                            {loading ? "Processing..." : "Register Now"}
                        </button>
                    )}
                </div>
            </div>

            {showModal && (
                <div
                    className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                    onClick={() => setShowModal(false)}
                >
                    <div
                        className="bg-white w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200"
                        onClick={(e) => e.stopPropagation()}
                    >
                        {event.image ? (
                            <div className="w-full h-56 overflow-hidden">
                                <img src={`/assets/uploads/events/${event.image}`} className="w-full h-full object-cover" />
                            </div>
                        ) : (
                            <div className="h-32 bg-rose-700 relative">
                                <div className="absolute -bottom-8 left-8 w-20 h-20 rounded-2xl bg-white p-1 shadow-xl">
                                    <div className="w-full h-full rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-rose-700 text-2xl uppercase">
                                        {event.event_name.charAt(0)}
                                    </div>
                                </div>
                            </div>
                        )}
                        <div className="p-8 pt-6">
                            <div className="flex justify-between items-start">
                                <div>
                                    <h2 className="text-2xl font-extrabold text-slate-900 leading-tight">{event.event_name}</h2>
                                    <p className="text-amber-600 font-bold text-sm uppercase tracking-wider mt-1">
                                        {event.event_type}
                                    </p>
                                </div>
                                <button
                                    onClick={() => setShowModal(false)}
                                    className="text-slate-400 hover:text-slate-600 bg-slate-50 p-2 rounded-full"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div className="grid grid-cols-2 gap-4 mt-8">
                                <div className="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">When</p>
                                    <p className="text-sm font-bold text-slate-700 mt-1">{fullDateStr}</p>
                                </div>
                                <div className="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Where</p>
                                    <p className="text-sm font-bold text-slate-700 mt-1">{event.location || "TBA"}</p>
                                </div>
                            </div>

                            <div className="mt-8">
                                <h4 className="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Description</h4>
                                <div className="text-slate-600 text-sm leading-relaxed max-h-40 overflow-y-auto custom-scrollbar">
                                    {event.description ||
                                        "Join us for this upcoming session. Detailed agenda will be shared shortly."}
                                </div>
                            </div>

                            <div className="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200 uppercase">
                                        {(event.contact_person || "O").charAt(0)}
                                    </div>
                                    <div>
                                        <p className="text-xs font-bold text-slate-700">{event.contact_person || "Organizer"}</p>
                                        <p className="text-[10px] text-slate-500 font-medium">Event Host</p>
                                    </div>
                                </div>
                                <div className="flex gap-3">
                                    <button
                                        onClick={() => setShowModal(false)}
                                        className="px-6 py-3 text-xs font-bold text-slate-600 bg-slate-50 rounded-xl hover:bg-slate-100 transition"
                                    >
                                        Close
                                    </button>
                                    {event.isRegistered ? (
                                        <button
                                            disabled
                                            className="bg-emerald-600 text-white text-xs font-bold px-8 py-3 rounded-xl flex items-center gap-2 cursor-default"
                                        >
                                            <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                            </svg>
                                            Registered
                                        </button>
                                    ) : (
                                        <button
                                            onClick={handleRegister}
                                            disabled={loading}
                                            className="bg-rose-700 text-white text-xs font-bold px-8 py-3 rounded-xl hover:bg-rose-800 transition shadow-lg shadow-rose-100"
                                        >
                                            {loading ? "Registering..." : "Confirm Registration"}
                                        </button>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default EventCard;
