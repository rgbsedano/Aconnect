"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import Image from "next/image";
import { useState } from "react";

import { useSession, signOut } from "next-auth/react";

const Navbar = () => {
    const pathname = usePathname();
    const { data: session } = useSession();
    const [eventsDropdownOpen, setEventsDropdownOpen] = useState(false);

    const navItems = [
        { label: "Dashboard", href: "/dashboard", icon: "fa-chart-line" },
        { label: "Home", href: "/", icon: "fa-house-user" },
        { label: "Network", href: "/alumni", icon: "fa-user-friends" },
        { label: "Jobs", href: "/jobs", icon: "fa-briefcase" },
        { label: "Messaging", href: "/chat", icon: "fa-comment-dots" },
    ];

    return (
        <header className="sticky top-0 w-full z-[2000] bg-white border-b border-black/10 h-[55px]">
            <div className="max-w-[1185px] mx-auto w-full flex items-center px-[25px] h-full">
                <div className="logo-area">
                    <Link href="/">
                        <Image
                            src="/assets/images/small_logo.png"
                            alt="Logo"
                            width={52}
                            height={52}
                            className="h-[52px] w-auto"
                        />
                    </Link>
                </div>

                <nav className="ml-auto h-full">
                    <ul className="flex h-full m-0 p-0 list-none">
                        {navItems.map((item) => {
                            const isActive = pathname === item.href;
                            return (
                                <li key={item.href} className="flex h-full items-center">
                                    <Link
                                        href={item.href}
                                        className={`flex flex-col items-center justify-center min-w-[84px] h-full text-[13px] transition-all duration-200 border-b-2 pt-[4px] ${isActive
                                            ? "text-black border-black"
                                            : "text-[#666] border-transparent hover:text-black"
                                            }`}
                                    >
                                        <i className={`fas ${item.icon} text-[20px] mb-[4px]`}></i>
                                        <span className="font-medium tracking-[0.3px] flex items-center gap-[4px]">
                                            {item.label}
                                        </span>
                                    </Link>
                                </li>
                            );
                        })}

                        {/* Events Dropdown */}
                        <li
                            className="flex h-full items-center relative"
                            onMouseEnter={() => setEventsDropdownOpen(true)}
                            onMouseLeave={() => setEventsDropdownOpen(false)}
                        >
                            <div
                                className={`flex flex-col items-center justify-center min-w-[84px] h-full text-[13px] transition-all duration-200 border-b-2 pt-[4px] cursor-pointer ${pathname.startsWith("/events")
                                    ? "text-black border-black"
                                    : "text-[#666] border-transparent hover:text-black"
                                    }`}
                            >
                                <i className="fas fa-calendar-alt text-[20px] mb-[4px]"></i>
                                <span className="font-medium tracking-[0.3px] flex items-center gap-[4px]">
                                    Events
                                    <i className="fas fa-caret-down text-[10px]"></i>
                                </span>
                            </div>

                            {/* Dropdown Menu */}
                            {eventsDropdownOpen && (
                                <div className="absolute top-full left-0 mt-0 bg-white border border-black/10 rounded-b-lg shadow-lg min-w-[180px] py-2">
                                    <Link
                                        href="/events"
                                        className="block px-4 py-2.5 text-[13px] text-[#333] hover:bg-[#f3f2ef] transition-colors"
                                    >
                                        <i className="fas fa-calendar-check mr-2 text-[#700A0A]"></i>
                                        Upcoming Events
                                    </Link>
                                    <Link
                                        href="/events/previous"
                                        className="block px-4 py-2.5 text-[13px] text-[#333] hover:bg-[#f3f2ef] transition-colors"
                                    >
                                        <i className="fas fa-history mr-2 text-[#666]"></i>
                                        Previous Events
                                    </Link>
                                </div>
                            )}
                        </li>

                        <div className="flex items-center border-l border-black/10 ml-[13px] pl-[13px] h-full">
                            {session?.user ? (
                                <>
                                    <li className="flex h-full items-center">
                                        <Link
                                            href="/profile"
                                            className="flex flex-col items-start justify-center px-[11px] h-full text-[#666] hover:text-primary transition-all duration-200"
                                        >
                                            <span className="text-[11px] font-bold text-primary leading-none mb-[3px] uppercase tracking-[0.5px]">
                                                {(session.user as any).student_number || "ADMIN"}
                                            </span>
                                            <span className="text-[15px] font-semibold text-[#333] leading-none flex items-center gap-[6px]">
                                                {session.user.name} <i className="fas fa-caret-down text-[11px]"></i>
                                            </span>
                                        </Link>
                                    </li>
                                    <button
                                        onClick={() => signOut({ callbackUrl: "/login" })}
                                        className="pl-[11px] text-[#666] text-[19px] flex items-center hover:text-secondary transition-all duration-200 group"
                                    >
                                        <i className="fas fa-sign-out-alt group-hover:scale-110"></i>
                                    </button>
                                </>
                            ) : (
                                <Link
                                    href="/login"
                                    className="ml-4 px-4 py-2 bg-[#700A0A] text-white rounded text-sm hover:bg-[#550808] transition-colors"
                                >
                                    Log In
                                </Link>
                            )}
                        </div>
                    </ul>
                </nav>
            </div>
        </header>
    );
};

export default Navbar;
