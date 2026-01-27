"use client";

import React, { useState } from "react";
import { useSession } from "next-auth/react";

interface AlumniCardProps {
    alumnus: any;
    onAction: () => void;
}

const AlumniCard = ({ alumnus, onAction }: AlumniCardProps) => {
    const { data: session } = useSession();
    const [loading, setLoading] = useState(false);
    const [showModal, setShowModal] = useState(false);

    const handleAction = async (action: string) => {
        setLoading(true);
        try {
            const res = await fetch("/api/alumni/connection", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action,
                    targetId: alumnus.id,
                    requestId: alumnus.requestId,
                }),
            });
            if (res.ok) {
                onAction();
            }
        } catch (error) {
            console.error("Connection action failed:", error);
        } finally {
            setLoading(false);
        }
    };

    const getImagePath = () => {
        if (alumnus.profile_image) return `/assets/uploads/alumni/${alumnus.profile_image}`;
        return `/assets/images/person-${alumnus.gender?.toLowerCase() === "female" ? "female" : "male"}.png`;
    };

    return (
        <>
            <div className="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden hover:-translate-y-1.5 hover:shadow-lg hover:border-[#D4A574] transition-all flex flex-col group">
                <div className="h-20 bg-gradient-to-br from-[#8B1538] to-[#6B0F2A]"></div>
                <div className="w-[90px] h-[90px] -mt-[45px] mx-auto rounded-full border-[5px] border-white overflow-hidden bg-white shadow-lg">
                    <img
                        src={getImagePath()}
                        alt={alumnus.first_name}
                        className="w-full h-full object-cover"
                        onError={(e) => {
                            (e.target as HTMLImageElement).src = `https://ui-avatars.com/api/?name=${alumnus.first_name}+${alumnus.last_name}&background=8B1538&color=fff`;
                        }}
                    />
                </div>

                <div className="px-5 pb-5 pt-3 text-center flex-grow">
                    <div className="text-[0.85rem] text-[#8B1538] font-bold uppercase tracking-wider mb-2">
                        {alumnus.degree || "SDCA Alumni"}
                    </div>
                    <h5 className="text-lg font-bold text-slate-900 mb-3 capitalize">
                        {alumnus.first_name} {alumnus.last_name}
                    </h5>
                    <span className="text-[0.8rem] text-slate-500 bg-slate-100 px-3 py-1 rounded-md font-medium">
                        Class of {alumnus.graduation_year}
                    </span>
                </div>

                <div className="p-5 border-t border-slate-100 flex gap-2.5">
                    <button
                        onClick={() => setShowModal(true)}
                        className="flex-1 border-2 border-[#8B1538] text-[#8B1538] px-3 py-2.5 rounded-lg text-sm font-bold hover:bg-[#8B1538] hover:text-white transition-all flex items-center justify-center gap-2"
                    >
                        <i className="fas fa-eye"></i> View
                    </button>

                    {alumnus.connectionStatus === "accepted" ? (
                        <button
                            disabled={loading}
                            onClick={() => handleAction("remove_connection")}
                            className="flex-1 bg-[#D4A574] text-[#8B1538] px-3 py-2.5 rounded-lg text-sm font-bold hover:bg-red-50 hover:text-red-800 transition-all flex items-center justify-center gap-2 relative overflow-hidden group/btn"
                        >
                            <i className="fas fa-check group-hover/btn:hidden"></i>
                            <span className="group-hover/btn:hidden">Linked</span>
                            <i className="fas fa-times hidden group-hover/btn:block"></i>
                            <span className="hidden group-hover/btn:block">Unlink</span>
                        </button>
                    ) : alumnus.connectionStatus === "pending" ? (
                        alumnus.senderId === parseInt((session as any)?.user?.id || "0") ? (
                            <button
                                disabled={loading}
                                onClick={() => handleAction("cancel_request")}
                                className="flex-1 bg-[#D4A574] text-[#8B1538] px-3 py-2.5 rounded-lg text-sm font-bold flex items-center justify-center gap-2"
                                title="Click to cancel"
                            >
                                <i className="fas fa-clock"></i> Pending
                            </button>
                        ) : (
                            <div className="flex-1 flex gap-2">
                                <button
                                    disabled={loading}
                                    onClick={() => handleAction("accept_request")}
                                    className="flex-1 bg-[#10B981] text-white p-2 rounded-lg hover:brightness-110 transition-all"
                                >
                                    <i className="fas fa-check"></i>
                                </button>
                                <button
                                    disabled={loading}
                                    onClick={() => handleAction("decline_request")}
                                    className="flex-1 bg-[#EF4444] text-white p-2 rounded-lg hover:brightness-110 transition-all"
                                >
                                    <i className="fas fa-times"></i>
                                </button>
                            </div>
                        )
                    ) : (
                        <button
                            disabled={loading}
                            onClick={() => handleAction("send_request")}
                            className="flex-1 bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-3 py-2.5 rounded-lg text-sm font-bold hover:shadow-lg transition-all flex items-center justify-center gap-2"
                        >
                            <i className="fas fa-user-plus"></i> Connect
                        </button>
                    )}
                </div>
            </div>

            {/* Profile Modal */}
            {showModal && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                    <div className="bg-white rounded-[24px] w-full max-w-md overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
                        <div className="h-20 bg-[#8B1538] relative">
                            <button
                                onClick={() => setShowModal(false)}
                                className="absolute right-4 top-4 text-white text-2xl hover:scale-110 transition-transform"
                            >
                                &times;
                            </button>
                        </div>
                        <div className="px-6 pb-8 text-center">
                            <img
                                src={getImagePath()}
                                className="w-[130px] h-[130px] rounded-full border-[6px] border-white -mt-[65px] mx-auto shadow-xl object-cover bg-white"
                                alt=""
                            />
                            <h4 className="mt-4 text-xl font-extrabold text-slate-900 capitalize">
                                {alumnus.first_name} {alumnus.last_name}
                            </h4>
                            <p className="text-[#8B1538] font-bold text-sm mb-6">{alumnus.degree}</p>

                            <div className="bg-[#F8FAFC] border border-slate-200 rounded-xl p-5 text-left space-y-4">
                                <div>
                                    <span className="text-[0.7rem] uppercase text-slate-500 font-extrabold tracking-wider block mb-1">
                                        Current Occupation
                                    </span>
                                    <span className="text-sm font-semibold text-slate-900">
                                        {alumnus.current_job || "No record provided"}
                                    </span>
                                </div>
                                <div>
                                    <span className="text-[0.7rem] uppercase text-slate-500 font-extrabold tracking-wider block mb-1">
                                        Contact Detail
                                    </span>
                                    <span className="text-sm font-semibold text-slate-900">
                                        {alumnus.email || "Information Restricted"}
                                    </span>
                                </div>
                                <div>
                                    <span className="text-[0.7rem] uppercase text-slate-500 font-extrabold tracking-wider block mb-1">
                                        Professional Expertise
                                    </span>
                                    <div className="flex flex-wrap gap-2 mt-2">
                                        {alumnus.technical_skills ? (
                                            alumnus.technical_skills.split(",").map((skill: string) => (
                                                <span
                                                    key={skill}
                                                    className="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-lg text-[10px] font-bold border border-amber-200"
                                                >
                                                    {skill.trim()}
                                                </span>
                                            ))
                                        ) : (
                                            <p className="text-slate-400 text-[11px] italic">No skills listed yet</p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            <button
                                onClick={() => setShowModal(false)}
                                className="w-full mt-6 bg-[#8B1538] text-white rounded-xl font-bold py-3.5 text-sm hover:brightness-110 shadow-lg transition-all"
                            >
                                Close Profile
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default AlumniCard;
