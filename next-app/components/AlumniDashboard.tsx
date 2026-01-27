"use client";

import React from "react";
import Link from "next/link";

const AlumniDashboard = () => {
    return (
        <div className="bg-[#FAFAF8] min-h-screen font-inter pb-10">
            <div className="max-w-[1400px] mx-auto pt-10 px-5">
                <div className="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">
                    {/* Main Content */}
                    <main className="bg-white rounded-xl border border-[#E5E7EB] shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div className="relative w-full bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] overflow-hidden">
                            <img
                                src="/assets/images/andaman-family.png"
                                alt="The Andaman Family"
                                className="w-full h-[300px] md:h-[500px] lg:h-[600px] object-cover hover:scale-[1.02] transition-transform duration-500"
                                onError={(e) => {
                                    (e.target as HTMLImageElement).src = "https://placehold.co/1200x500/8B1538/FFFFFF?text=SDCA+Heritage";
                                }}
                            />
                            <div className="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/90 via-black/40 to-transparent text-white">
                                <h1 className="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight">
                                    Our Heritage & Mission
                                </h1>
                            </div>
                        </div>

                        <div className="p-8 md:p-12 space-y-6">
                            <p className="text-[1.02rem] leading-relaxed text-[#1F2937]">
                                <span className="float-left text-5xl md:text-6xl font-black leading-[0.8] pr-4 mt-1 text-[#8B1538]">
                                    S
                                </span>
                                <strong className="text-[#8B1538]">St. Dominic College of Asia (SDCA)</strong> traces its roots to the establishment of St. Dominic Medical Center in 1991 by founders Don Gregorio and Doña Dominga Andaman. In 2003, what began as a healthcare vision evolved into a comprehensive educational institution that has been transforming lives for over two decades in Bacoor, Cavite.
                            </p>

                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 py-8">
                                {[
                                    { label: "Years of Excellence", value: "30+" },
                                    { label: "Specialized Schools", value: "5" },
                                    { label: "Academic Programs", value: "50+" },
                                    { label: "Commitment to Quality", value: "100%" },
                                ].map((stat) => (
                                    <div key={stat.label} className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-6 rounded-xl text-center hover:-translate-y-1 transition-transform">
                                        <div className="text-3xl font-black mb-2">{stat.value}</div>
                                        <div className="text-[0.7rem] md:text-[0.8rem] opacity-90 uppercase tracking-widest font-medium">
                                            {stat.label}
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <p className="text-[1.02rem] leading-relaxed text-[#1F2937]">
                                Under the visionary leadership of <strong>Dr. Gregorio A. Andaman, Jr.</strong>, SDCA has embraced the battlecry "
                                <span className="text-[#8B1538] font-bold">Revolutionizing Education</span>" since 2011. This philosophy drives our innovative approach to learner-centered education, cutting-edge research, and meaningful community engagement.
                            </p>

                            <div className="bg-[#FAFAF8] p-8 rounded-xl space-y-6">
                                <h3 className="text-[#8B1538] text-2xl font-bold">Our Academic Excellence</h3>
                                <p className="text-[#6B7280]">Five specialized schools offering comprehensive programs from basic education to graduate studies:</p>

                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    {[
                                        {
                                            icon: "fas fa-heartbeat",
                                            title: "School of Nursing & Allied Health Studies",
                                            items: ["BS Nursing", "BS Radiologic Technology", "BS Physical Therapy"],
                                        },
                                        {
                                            icon: "fas fa-flask",
                                            title: "School of Medical Laboratory Science",
                                            items: ["BS Biology", "BS Pharmacy", "BS Medical Laboratory Science"],
                                        },
                                        {
                                            icon: "fas fa-calculator",
                                            title: "School of Accountancy, Sciences & Education",
                                            items: ["BS Accountancy", "BS Psychology", "BS Education"],
                                        },
                                        {
                                            icon: "fas fa-utensils",
                                            title: "School of International Hospitality & Tourism",
                                            items: ["BS Tourism Management", "BS Hospitality Management", "Culinary Arts"],
                                        },
                                        {
                                            icon: "fas fa-laptop",
                                            title: "School of Business & Computer Studies",
                                            items: ["BS Business Administration", "BS Information Technology", "BA Communication"],
                                        },
                                        {
                                            icon: "fas fa-graduation-cap",
                                            title: "Graduate Studies & Medicine",
                                            items: ["MBA", "MA in Psychology", "Doctor of Medicine"],
                                        },
                                    ].map((school) => (
                                        <div key={school.title} className="bg-white p-5 rounded-lg border-l-4 border-[#8B1538] hover:shadow-md hover:translate-x-1 transition-all">
                                            <div className="text-[#8B1538] text-xl mb-3">
                                                <i className={school.icon}></i>
                                            </div>
                                            <h4 className="font-bold text-[#1F2937] text-sm mb-2">{school.title}</h4>
                                            <div className="text-[0.8rem] text-[#6B7280] space-y-1">
                                                {school.items.map((item) => (
                                                    <div key={item}>• {item}</div>
                                                ))}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <p className="text-[1.02rem] leading-relaxed text-[#1F2937]">
                                Our commitment to excellence is reflected in our <strong>PACUCOA accreditation</strong> for multiple programs and our consistent achievement of high passing rates in licensure examinations. From our <strong>Basic Education Unit</strong> (Preschool to Senior High School) to our <strong>Graduate Studies</strong>, we prepare students not just for careers, but for meaningful contributions to society through holistic development and community service.
                            </p>

                            <p className="text-[1.02rem] leading-relaxed text-[#1F2937]">
                                Located in the heart of <strong>Bacoor, Cavite</strong>, SDCA continues to revolutionize education by linking training and research with community service, pursuing the holistic development of individuals through innovative programs that meet global standards while serving local needs.
                            </p>
                        </div>
                    </main>

                    {/* Sidebar */}
                    <aside className="space-y-5">
                        <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-8 rounded-xl shadow-md text-center">
                            <blockquote className="text-xl font-bold italic leading-relaxed">
                                "Your Vision of the future, is our Mission today."
                            </blockquote>
                        </div>

                        <div className="bg-white rounded-xl border border-[#E5E7EB] p-7 shadow-md hover:shadow-lg hover:border-[#D4A574] transition-all group">
                            <h3 className="text-[#8B1538] font-bold text-xs uppercase tracking-widest flex items-center gap-2 mb-3">
                                <i className="fas fa-bullseye text-sm text-[#D4A574]"></i> Our Mission
                            </h3>
                            <p className="text-sm text-[#6B7280] leading-relaxed">
                                To revolutionize education by linking training and research with community service, pursuing the holistic development of individuals through innovative programs.
                            </p>

                            <div className="h-[1px] bg-[#E5E7EB] my-5"></div>

                            <h3 className="text-[#8B1538] font-bold text-xs uppercase tracking-widest flex items-center gap-2 mb-3">
                                <i className="fas fa-eye text-sm text-[#D4A574]"></i> Our Vision
                            </h3>
                            <p className="text-sm text-[#6B7280] leading-relaxed">
                                A dynamic and proactive university in Asia dedicated to excellence in providing learner-centered education and sustainable community service.
                            </p>
                        </div>

                        <div className="bg-white rounded-xl border border-[#E5E7EB] p-7 shadow-md">
                            <h4 className="font-bold text-[#1F2937] mb-3">Connect With Us</h4>
                            <p className="text-sm text-[#6B7280] leading-relaxed mb-4">
                                Join our community and stay informed about campus achievements and opportunities.
                            </p>
                            <a
                                href="https://www.facebook.com/stdominiccollege"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="flex items-center justify-center gap-3 bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white py-3 rounded-lg font-semibold hover:-translate-y-[2px] hover:shadow-lg transition-all"
                            >
                                <i className="fab fa-facebook-f"></i> Follow SDCA
                            </a>
                        </div>

                        <div className="text-center p-4 text-xs text-[#6B7280] space-y-1">
                            <strong className="text-[#1F2937]">Est. 2003</strong> • Bacoor, Cavite<br />
                            © 2026 St. Dominic College of Asia
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    );
};

export default AlumniDashboard;
