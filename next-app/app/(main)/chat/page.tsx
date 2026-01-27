"use client";

import React, { useState, useEffect } from "react";
import ChatModal from "@/components/ChatModal";

export default function MessagesPage() {
    const [friends, setFriends] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [selectedFriend, setSelectedFriend] = useState<any>(null);

    useEffect(() => {
        fetchFriends();
    }, []);

    const fetchFriends = async () => {
        setLoading(true);
        try {
            const res = await fetch("/api/messages");
            const data = await res.json();
            if (!data.error) {
                setFriends(data);
            }
        } catch (error) {
            console.error("Failed to fetch friends:", error);
        } finally {
            setLoading(false);
        }
    };

    const getImagePath = (friend: any) => {
        if (friend.profile_image) return `/assets/uploads/alumni/${friend.profile_image}`;
        return `/assets/images/person-${friend.gender?.toLowerCase() === "female" ? "female" : "male"}.png`;
    };

    return (
        <div className="bg-[#FAFAF8] min-h-screen font-sans py-20 px-4">
            <div className="max-w-xl mx-auto bg-white rounded-2xl shadow-md p-8 border border-[#E5E7EB]">
                <h2 className="text-2xl font-bold text-[#1F2937] mb-6 flex items-center gap-3 border-b-2 border-[#D4A574] pb-5">
                    <i className="fas fa-comments text-[#8B1538]"></i> Messages
                </h2>

                {loading ? (
                    <div className="flex justify-center py-10">
                        <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-[#8B1538]"></div>
                    </div>
                ) : friends.length === 0 ? (
                    <div className="text-center py-12 px-6 border-2 border-dashed border-[#E5E7EB] rounded-xl text-[#6B7280]">
                        <i className="fas fa-inbox text-5xl mb-4 opacity-20"></i>
                        <p className="font-bold text-[#1F2937]">No Conversations Yet</p>
                        <p className="mt-1">Find alumni and start chatting to build your network</p>
                    </div>
                ) : (
                    <ul className="space-y-3">
                        {friends.map((friend) => (
                            <li
                                key={friend.id}
                                onClick={() => setSelectedFriend(friend)}
                                className="group p-4 border border-[#E5E7EB] rounded-2xl flex items-center justify-between cursor-pointer hover:bg-[#f9f9f9] hover:border-[#8B1538] hover:shadow-md hover:translate-x-1 transition-all"
                            >
                                <div className="flex items-center gap-4 min-w-0">
                                    <img
                                        src={getImagePath(friend)}
                                        alt=""
                                        className="w-14 h-14 rounded-full border-2 border-[#8B1538] object-cover flex-shrink-0 bg-[#f9f9f9]"
                                        onError={(e) => {
                                            (e.target as HTMLImageElement).src = `https://ui-avatars.com/api/?name=${friend.first_name}+${friend.last_name}&background=8B1538&color=fff`;
                                        }}
                                    />
                                    <div className="min-w-0">
                                        <p className="font-bold text-[#1F2937] truncate capitalize">
                                            {friend.first_name} {friend.last_name}
                                        </p>
                                        <p className="text-xs text-[#6B7280] mt-1 flex items-center gap-2">
                                            <i className="fas fa-circle text-[6px] text-[#10B981]"></i> Active
                                        </p>
                                    </div>
                                </div>
                                <button className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-5 py-2.5 rounded-full text-xs font-bold shadow-sm group-hover:shadow-md group-hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                    <i className="fas fa-paper-plane"></i> Message
                                </button>
                            </li>
                        ))}
                    </ul>
                )}
            </div>

            {selectedFriend && (
                <ChatModal
                    friend={selectedFriend}
                    onClose={() => setSelectedFriend(null)}
                />
            )}
        </div>
    );
}
