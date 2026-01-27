"use client";

import React, { useState, useEffect, useRef } from "react";
import { useSession } from "next-auth/react";

interface ChatModalProps {
    friend: any;
    onClose: () => void;
}

const ChatModal = ({ friend, onClose }: ChatModalProps) => {
    const { data: session } = useSession();
    const [messages, setMessages] = useState<any[]>([]);
    const [newMessage, setNewMessage] = useState("");
    const [loading, setLoading] = useState(true);
    const scrollRef = useRef<HTMLDivElement>(null);

    const currentUserId = parseInt((session as any)?.user?.id || "0");

    useEffect(() => {
        fetchMessages();
        const interval = setInterval(fetchMessages, 3000); // Poll every 3s
        return () => clearInterval(interval);
    }, [friend.id]);

    useEffect(() => {
        if (scrollRef.current) {
            scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
        }
    }, [messages]);

    const fetchMessages = async () => {
        try {
            const res = await fetch(`/api/messages?friendId=${friend.id}`);
            const data = await res.json();
            if (!data.error) {
                setMessages(data);
                setLoading(false);
            }
        } catch (error) {
            console.error("Failed to fetch messages:", error);
        }
    };

    const handleSend = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!newMessage.trim()) return;

        const msg = newMessage;
        setNewMessage("");

        try {
            const res = await fetch("/api/messages/send", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    receiverId: friend.id,
                    message: msg,
                }),
            });
            if (res.ok) {
                fetchMessages();
            }
        } catch (error) {
            console.error("Failed to send message:", error);
        }
    };

    const getImagePath = (f: any) => {
        if (f.profile_image) return `/assets/uploads/alumni/${f.profile_image}`;
        return `/assets/images/person-${f.gender?.toLowerCase() === "female" ? "female" : "male"}.png`;
    };

    return (
        <div className="fixed bottom-5 right-5 w-[400px] h-[550px] bg-white shadow-2xl rounded-2xl flex flex-col overflow-hidden z-[100] border border-[#E5E7EB] animate-in slide-in-from-bottom-5 duration-300">
            <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-4 flex items-center justify-between shadow-md">
                <div className="flex items-center gap-3">
                    <img
                        src={getImagePath(friend)}
                        alt=""
                        className="w-10 h-10 rounded-full border-2 border-white object-cover bg-white"
                        onError={(e) => {
                            (e.target as HTMLImageElement).src = `https://ui-avatars.com/api/?name=${friend.first_name}+${friend.last_name}&background=8B1538&color=fff`;
                        }}
                    />
                    <span className="font-bold text-sm capitalize">
                        {friend.first_name} {friend.last_name}
                    </span>
                </div>
                <button
                    onClick={onClose}
                    className="text-white text-2xl hover:bg-white/20 w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                >
                    &times;
                </button>
            </div>

            <div
                ref={scrollRef}
                className="flex-1 overflow-y-auto p-4 bg-[#f9f9f9] space-y-4 custom-scrollbar"
            >
                {loading ? (
                    <p className="text-center text-[#6B7280] text-xs pt-10">Loading conversation...</p>
                ) : messages.length === 0 ? (
                    <p className="text-center text-[#6B7280] text-xs pt-10">Say hello!</p>
                ) : (
                    messages.map((msg) => (
                        <div
                            key={msg.id}
                            className={`flex ${msg.sender_id === currentUserId ? "justify-end" : "justify-start"}`}
                        >
                            <div
                                className={`max-w-[75%] p-3.5 rounded-2xl text-sm shadow-sm ${msg.sender_id === currentUserId
                                        ? "bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white rounded-tr-none"
                                        : "bg-white text-[#1F2937] border border-[#E5E7EB] rounded-tl-none"
                                    }`}
                            >
                                <p className="leading-relaxed whitespace-pre-wrap">{msg.message}</p>
                                <div
                                    className={`text-[10px] mt-2 opacity-60 text-right ${msg.sender_id === currentUserId ? "text-white" : "text-[#6B7280]"
                                        }`}
                                >
                                    {new Date(msg.sent_at).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}
                                </div>
                            </div>
                        </div>
                    ))
                )}
            </div>

            <div className="p-4 bg-white border-t border-[#E5E7EB]">
                <form onSubmit={handleSend} className="flex gap-2 items-end">
                    <textarea
                        value={newMessage}
                        onChange={(e) => setNewMessage(e.target.value)}
                        onKeyDown={(e) => {
                            if (e.key === "Enter" && !e.shiftKey) {
                                e.preventDefault();
                                handleSend(e);
                            }
                        }}
                        placeholder="Aa"
                        className="flex-grow bg-[#f3f4f6] border border-transparent rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:bg-white focus:border-[#8B1538] focus:ring-4 focus:ring-[#8B1538]/5 transition-all resize-none max-h-32"
                        rows={1}
                    />
                    <button
                        type="submit"
                        disabled={!newMessage.trim()}
                        className="w-10 h-10 bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white rounded-full flex items-center justify-center hover:shadow-lg disabled:opacity-50 transition-all flex-shrink-0"
                    >
                        <i className="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    );
};

export default ChatModal;
