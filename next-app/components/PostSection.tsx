"use client";

import { useState } from "react";
import Image from "next/image";

interface Post {
    id: number;
    title: string | null;
    content: string | null;
    image: string | null;
    created_at: Date;
}

interface PostSectionProps {
    type: string;
    posts: Post[];
}

const PostSection = ({ type, posts }: PostSectionProps) => {
    const [idx, setIdx] = useState(0);
    const [animating, setAnimating] = useState(false);

    if (posts.length === 0) return null;

    const current = posts[idx];

    const nextPost = () => {
        setAnimating(true);
        setTimeout(() => {
            setIdx((prev) => (prev + 1) % posts.length);
            setAnimating(false);
        }, 300);
    };

    return (
        <section className="flex-1 bg-white rounded-[12px] p-0 flex flex-col justify-between shadow-md border-l-[6px] border-primary overflow-hidden transition-all duration-300 hover:shadow-lg min-h-0">
            <div className="w-full h-[140px] overflow-hidden bg-[#f5f5f5] flex items-center justify-center border-b border-black/10">
                {current.image ? (
                    <img
                        src={`/assets/uploads/post/${current.image}`}
                        alt={current.title || ""}
                        className="w-full h-full object-cover block"
                    />
                ) : (
                    <div className="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#f0f0f0] to-[#e8e8e8] text-[#6B7280]">
                        <i className="fas fa-image text-[32px] text-black/10"></i>
                    </div>
                )}
            </div>

            <div className="p-[15px_20px] flex flex-col justify-between flex-1">
                <div>
                    <div className="flex justify-between items-center">
                        <span className="text-[0.75rem] uppercase tracking-[1.2px] font-extrabold text-white bg-gradient-to-br from-primary to-maroon-dark px-[10px] py-[4px] rounded-[6px]">
                            {type}
                        </span>
                        <span className="text-[#6B7280] text-[10px] font-bold">
                            {new Date(current.created_at).toLocaleDateString("en-US", {
                                month: "short",
                                day: "2-digit",
                                year: "numeric",
                            })}
                        </span>
                    </div>

                    <div className={`transition-opacity duration-300 ${animating ? "opacity-0" : "opacity-100"}`}>
                        <h4 className="text-[1.15rem] font-bold text-[#1F2937] mt-[8px] line-clamp-2 leading-[1.3]">
                            {current.title || "No Recent Updates"}
                        </h4>
                    </div>
                </div>

                <div className="flex justify-between items-center mt-2">
                    <button className="text-[0.8rem] font-bold text-[#6B7280] uppercase tracking-[0.8px] hover:text-primary transition-colors duration-300 flex items-center gap-1">
                        DETAILS <i className="fas fa-external-link-alt text-[0.7rem]"></i>
                    </button>

                    {posts.length > 1 && (
                        <button
                            onClick={nextPost}
                            className="bg-gradient-to-br from-primary to-maroon-dark text-white px-[16px] py-[6px] rounded-[8px] text-[0.8rem] font-bold hover:-translate-y-[1px] hover:shadow-md transition-all duration-300 flex items-center gap-1"
                        >
                            NEXT <i className="fas fa-chevron-right text-[0.7rem]"></i>
                        </button>
                    )}
                </div>
            </div>
        </section>
    );
};

export default PostSection;
