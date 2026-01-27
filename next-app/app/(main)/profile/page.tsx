"use client";

import React, { useState, useEffect } from "react";
import { useSession } from "next-auth/react";

export default function ProfilePage() {
    const { data: session } = useSession();
    const [alumni, setAlumni] = useState<any>(null);
    const [loading, setLoading] = useState(true);
    const [activeModal, setActiveModal] = useState<string | null>(null);
    const [formData, setFormData] = useState<any>({});
    const [showSuccessNotification, setShowSuccessNotification] = useState(false);

    useEffect(() => {
        fetchProfile();
    }, []);

    const fetchProfile = async () => {
        setLoading(true);
        try {
            const res = await fetch("/api/profile");
            const data = await res.json();
            if (!data.error) {
                setAlumni(data);
                // Set formData with default values to prevent undefined errors
                setFormData({
                    ...data,
                    alternative_phone: data.alternative_phone || "",
                    alternative_email: data.alternative_email || "",
                    phone: data.phone || "",
                    email: data.email || "",
                    degree: data.degree || "",
                    graduation_year: data.graduation_year || "",
                    first_name: data.first_name || "",
                    last_name: data.last_name || "",
                });
            }
        } catch (error) {
            console.error("Failed to fetch profile:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleUpdate = async (type: string, payload: any) => {
        try {
            const res = await fetch("/api/profile/update", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ type, ...payload }),
            });
            if (res.ok) {
                fetchProfile();
                setActiveModal(null);
                setShowSuccessNotification(true);
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    setShowSuccessNotification(false);
                }, 3000);
            }
        } catch (error) {
            console.error("Update failed:", error);
        }
    };

    const getImagePath = () => {
        if (alumni?.profile_image) return `/assets/uploads/alumni/${alumni.profile_image}`;
        return `/assets/images/person-${alumni?.gender?.toLowerCase() === "female" ? "female" : "male"}.png`;
    };

    if (loading || !alumni) {
        return (
            <div className="flex justify-center items-center min-h-[400px]">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-[#8B1538]"></div>
            </div>
        );
    }

    const employment = alumni.employment?.[0] || {};

    return (
        <div className="bg-[#FAFAF8] min-h-screen font-sans pb-20 pt-10 px-4">
            <div className="max-w-[900px] mx-auto">
                {/* Profile Header */}
                <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] h-[180px] rounded-t-2xl relative shadow-md overflow-hidden">
                    <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] bg-[size:20px_20px]"></div>
                </div>

                {/* Profile Info Card */}
                <div className="bg-white p-6 md:p-10 rounded-b-2xl shadow-md relative mb-6">
                    <div className="absolute -top-[70px] left-6 md:left-10 w-[140px] h-[140px] rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-white">
                        <img
                            src={getImagePath()}
                            className="w-full h-full object-cover"
                            alt="Profile"
                            onError={(e) => {
                                (e.target as HTMLImageElement).src = `https://ui-avatars.com/api/?name=${alumni.first_name}+${alumni.last_name}&background=8B1538&color=fff`;
                            }}
                        />
                    </div>

                    <div className="flex flex-col md:flex-row justify-between items-start pt-16 md:pt-0 md:pl-[160px] gap-6">
                        <div className="flex-grow">
                            <h1 className="text-3xl font-bold text-[#1F2937] mb-1 capitalize">
                                {alumni.first_name} {alumni.last_name}
                            </h1>
                            <p className="text-lg text-[#6B7280] font-medium mb-3">{alumni.degree || "Degree Not Set"}</p>
                            <div className="flex flex-wrap gap-5 text-sm text-[#6B7280]">
                                <span className="flex items-center gap-2">
                                    <i className="fas fa-graduation-cap text-[#D4A574]"></i> Graduated {alumni.graduation_year || "N/A"}
                                </span>
                                <span className="flex items-center gap-2">
                                    <i className="fas fa-id-badge text-[#D4A574]"></i> ID: {alumni.student_number || "N/A"}
                                </span>
                            </div>
                        </div>
                        <button
                            onClick={() => {
                                setFormData(alumni);
                                setActiveModal("basic");
                            }}
                            className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-sm hover:-translate-y-0.5 hover:shadow-lg transition-all flex items-center gap-2"
                        >
                            <i className="fas fa-edit"></i> Edit Profile
                        </button>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10 pt-10 border-t border-[#E5E7EB]">
                        <div>
                            <p className="text-[10px] font-black text-[#6B7280] uppercase tracking-widest mb-2">Email</p>
                            <p className="font-bold text-[#1F2937] break-all">{alumni.email || "Not Set"}</p>
                        </div>
                        <div>
                            <p className="text-[10px] font-black text-[#6B7280] uppercase tracking-widest mb-2">Alternate Email</p>
                            <p className="font-bold text-[#1F2937] break-all">{alumni.alternative_email || "Not Set"}</p>
                        </div>
                        <div>
                            <p className="text-[10px] font-black text-[#6B7280] uppercase tracking-widest mb-2">Phone</p>
                            <p className="font-bold text-[#1F2937]">{alumni.phone || "Not Set"}</p>
                        </div>
                    </div>
                </div>

                {/* Sections */}
                <div className="grid grid-cols-1 gap-6">
                    {/* Employment */}
                    <section className="bg-white p-8 rounded-2xl shadow-sm border border-[#E5E7EB] hover:shadow-md transition-all group">
                        <div className="flex justify-between items-center mb-6 pb-4 border-b-2 border-[#D4A574]">
                            <h3 className="text-xl font-bold text-[#1F2937] flex items-center gap-3">
                                <i className="fas fa-briefcase text-[#8B1538]"></i> Employment & Career
                            </h3>
                            <button
                                onClick={() => {
                                    setFormData(employment);
                                    setActiveModal("employment");
                                }}
                                className="text-[#8B1538] border-2 border-[#8B1538] px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-[#8B1538] hover:text-white transition-all"
                            >
                                <i className="fas fa-edit mr-2"></i> Edit
                            </button>
                        </div>

                        {employment.job_title ? (
                            <div className="flex gap-6 items-start">
                                <div className="w-14 h-14 bg-[#8B1538]/10 text-[#8B1538] rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                                    <i className="fas fa-briefcase"></i>
                                </div>
                                <div className="flex-grow">
                                    <h4 className="text-lg font-bold text-[#1F2937] mb-1">{employment.job_title}</h4>
                                    <p className="text-[#6B7280] mb-3">{employment.company_name}</p>
                                    <div className="flex gap-6 text-xs text-[#6B7280] mb-4">
                                        <span className="flex items-center gap-1.5">
                                            <i className="fas fa-clock text-[#D4A574]"></i> {employment.year_of_service} year(s)
                                        </span>
                                        <span className="flex items-center gap-1.5">
                                            <i className="fas fa-arrow-up text-[#D4A574]"></i> {employment.promotion_count} promotion(s)
                                        </span>
                                    </div>
                                    <span
                                        className={`inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest ${employment.employment_status === "Employed"
                                            ? "bg-emerald-100 text-emerald-800"
                                            : employment.employment_status === "Self-employed"
                                                ? "bg-blue-100 text-blue-800"
                                                : "bg-red-100 text-red-800"
                                            }`}
                                    >
                                        <i className="fas fa-circle text-[6px]"></i> {employment.employment_status}
                                    </span>
                                </div>
                            </div>
                        ) : (
                            <div className="text-center py-10 text-[#6B7280]">
                                <i className="fas fa-briefcase text-4xl mb-4 opacity-10"></i>
                                <p className="font-bold text-[#1F2937]">No Employment Info Yet</p>
                                <p className="text-sm mt-1">Add your current job and career information</p>
                            </div>
                        )}
                    </section>

                    {/* Skills */}
                    <section className="bg-white p-8 rounded-2xl shadow-sm border border-[#E5E7EB] hover:shadow-md transition-all">
                        <div className="flex justify-between items-center mb-6 pb-4 border-b-2 border-[#D4A574]">
                            <h3 className="text-xl font-bold text-[#1F2937] flex items-center gap-3">
                                <i className="fas fa-star text-[#8B1538]"></i> Skills
                            </h3>
                            <button
                                onClick={() => {
                                    setFormData({
                                        soft_skills: alumni.soft_skills?.split(",") || [],
                                        technical_skills: alumni.technical_skills?.split(",") || [],
                                    });
                                    setActiveModal("skills");
                                }}
                                className="text-[#8B1538] border-2 border-[#8B1538] px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-[#8B1538] hover:text-white transition-all"
                            >
                                <i className="fas fa-edit mr-2"></i> Edit
                            </button>
                        </div>

                        <div className="space-y-8">
                            <div>
                                <h6 className="text-xs font-black text-[#1F2937] uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <i className="fas fa-heart text-[#8B1538]"></i> Soft Skills
                                </h6>
                                <div className="flex flex-wrap gap-2">
                                    {alumni.soft_skills ? (
                                        alumni.soft_skills.split(",").map((s: string) => (
                                            <span
                                                key={s}
                                                className="bg-gradient-to-br from-[#8B1538]/5 to-[#D4A574]/5 border border-[#E5E7EB] text-[#1F2937] px-4 py-2 rounded-full text-xs font-bold hover:border-[#8B1538] transition-all"
                                            >
                                                <i className="fas fa-check-circle text-[#8B1538] mr-2"></i> {s.trim()}
                                            </span>
                                        ))
                                    ) : (
                                        <p className="text-xs text-[#6B7280] italic">No soft skills added yet</p>
                                    )}
                                </div>
                            </div>

                            <div>
                                <h6 className="text-xs font-black text-[#1F2937] uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <i className="fas fa-gear text-[#8B1538]"></i> Technical Skills
                                </h6>
                                <div className="flex flex-wrap gap-2">
                                    {alumni.technical_skills ? (
                                        alumni.technical_skills.split(",").map((s: string) => (
                                            <span
                                                key={s}
                                                className="bg-gradient-to-br from-[#8B1538]/5 to-[#D4A574]/5 border border-[#E5E7EB] text-[#1F2937] px-4 py-2 rounded-full text-xs font-bold hover:border-[#8B1538] transition-all"
                                            >
                                                <i className="fas fa-code text-[#8B1538] mr-2"></i> {s.trim()}
                                            </span>
                                        ))
                                    ) : (
                                        <p className="text-xs text-[#6B7280] italic">No technical skills added yet</p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            {/* Modals */}
            {activeModal === "basic" && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                    <div className="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl">
                        <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-6 flex justify-between items-center">
                            <h5 className="font-bold flex items-center gap-3">
                                <i className="fas fa-user-circle"></i> Edit Profile Information
                            </h5>
                            <button onClick={() => setActiveModal(null)} className="text-2xl">
                                &times;
                            </button>
                        </div>
                        <div className="p-8 space-y-6">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">First Name</label>
                                    <input
                                        type="text"
                                        value={formData.first_name}
                                        onChange={(e) => setFormData({ ...formData, first_name: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Last Name</label>
                                    <input
                                        type="text"
                                        value={formData.last_name}
                                        onChange={(e) => setFormData({ ...formData, last_name: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Degree</label>
                                    <input
                                        type="text"
                                        value={formData.degree}
                                        onChange={(e) => setFormData({ ...formData, degree: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Graduation Year</label>
                                    <input
                                        type="number"
                                        value={formData.graduation_year}
                                        onChange={(e) => setFormData({ ...formData, graduation_year: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Email</label>
                                    <input
                                        type="email"
                                        value={formData.email}
                                        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Alt Email</label>
                                    <input
                                        type="email"
                                        value={formData.alternative_email}
                                        onChange={(e) => setFormData({ ...formData, alternative_email: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Phone</label>
                                    <input
                                        type="text"
                                        value={formData.phone}
                                        onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Alt Phone</label>
                                    <input
                                        type="text"
                                        value={formData.alternative_phone}
                                        onChange={(e) => setFormData({ ...formData, alternative_phone: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div className="flex justify-end gap-3 pt-6 border-t border-[#E5E7EB]">
                                <button
                                    onClick={() => setActiveModal(null)}
                                    className="px-6 py-2.5 text-sm font-bold text-[#6B7280] hover:bg-slate-50 rounded-xl"
                                >
                                    Cancel
                                </button>
                                <button
                                    onClick={() => handleUpdate("basic", formData)}
                                    className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-8 py-2.5 rounded-xl font-bold text-sm"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {activeModal === "employment" && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                    <div className="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl">
                        <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-6 flex justify-between items-center">
                            <h5 className="font-bold flex items-center gap-3">
                                <i className="fas fa-briefcase"></i> Edit Employment Information
                            </h5>
                            <button onClick={() => setActiveModal(null)} className="text-2xl">
                                &times;
                            </button>
                        </div>
                        <div className="p-8 space-y-6">
                            <div>
                                <label className="block text-xs font-bold text-[#1F2937] mb-2">Employment Status</label>
                                <select
                                    value={formData.employment_status || ""}
                                    onChange={(e) => setFormData({ ...formData, employment_status: e.target.value })}
                                    className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                >
                                    <option value="">-- Select Status --</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Self-employed">Self-employed</option>
                                </select>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Job Title</label>
                                    <input
                                        type="text"
                                        value={formData.job_title || ""}
                                        onChange={(e) => setFormData({ ...formData, job_title: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Company Name</label>
                                    <input
                                        type="text"
                                        value={formData.company_name || ""}
                                        onChange={(e) => setFormData({ ...formData, company_name: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div>
                                <label className="block text-xs font-bold text-[#1F2937] mb-2">Job Description</label>
                                <textarea
                                    value={formData.job_description || ""}
                                    onChange={(e) => setFormData({ ...formData, job_description: e.target.value })}
                                    className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm min-h-[100px]"
                                />
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Years of Service</label>
                                    <input
                                        type="number"
                                        value={formData.year_of_service || 0}
                                        onChange={(e) => setFormData({ ...formData, year_of_service: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                                <div>
                                    <label className="block text-xs font-bold text-[#1F2937] mb-2">Promotion Count</label>
                                    <input
                                        type="number"
                                        value={formData.promotion_count || 0}
                                        onChange={(e) => setFormData({ ...formData, promotion_count: e.target.value })}
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                    />
                                </div>
                            </div>
                            <div className="flex justify-end gap-3 pt-6 border-t border-[#E5E7EB]">
                                <button
                                    onClick={() => setActiveModal(null)}
                                    className="px-6 py-2.5 text-sm font-bold text-[#6B7280] hover:bg-slate-50 rounded-xl"
                                >
                                    Cancel
                                </button>
                                <button
                                    onClick={() => handleUpdate("employment", formData)}
                                    className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-8 py-2.5 rounded-xl font-bold text-sm"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {activeModal === "skills" && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                    <div className="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
                        <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-6 flex justify-between items-center flex-shrink-0">
                            <h5 className="font-bold flex items-center gap-3">
                                <i className="fas fa-star"></i> Edit Skills
                            </h5>
                            <button onClick={() => setActiveModal(null)} className="text-2xl">
                                &times;
                            </button>
                        </div>
                        <div className="p-8 space-y-6 overflow-y-auto flex-grow">
                            {/* Soft Skills Section */}
                            <div>
                                <label className="block text-xs font-bold text-[#1F2937] mb-3">Soft Skills</label>

                                {/* Selected Skills Display */}
                                <div className="flex flex-wrap gap-2 mb-4 min-h-[40px] p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    {(Array.isArray(formData.soft_skills) ? formData.soft_skills : formData.soft_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || []).map((skill: string, idx: number) => (
                                        <span
                                            key={idx}
                                            className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-2"
                                        >
                                            {skill}
                                            <button
                                                onClick={() => {
                                                    const skills = Array.isArray(formData.soft_skills)
                                                        ? formData.soft_skills
                                                        : formData.soft_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                                    setFormData({
                                                        ...formData,
                                                        soft_skills: skills.filter((_: any, i: number) => i !== idx)
                                                    });
                                                }}
                                                className="hover:bg-white/20 rounded-full w-4 h-4 flex items-center justify-center"
                                            >
                                                <i className="fas fa-times text-[10px]"></i>
                                            </button>
                                        </span>
                                    ))}
                                    {(Array.isArray(formData.soft_skills) ? formData.soft_skills.length === 0 : !formData.soft_skills) && (
                                        <span className="text-slate-400 text-sm italic">No soft skills added yet</span>
                                    )}
                                </div>

                                {/* Suggested Soft Skills */}
                                <div className="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-3">
                                    <p className="text-xs font-bold text-amber-900 mb-3 flex items-center gap-2">
                                        <i className="fas fa-lightbulb"></i> Suggested based on your profile
                                    </p>
                                    <div className="flex flex-wrap gap-2">
                                        {["Communication", "Leadership", "Teamwork", "Problem Solving", "Time Management", "Critical Thinking", "Adaptability", "Creativity"].map((skill) => {
                                            const currentSkills = Array.isArray(formData.soft_skills)
                                                ? formData.soft_skills
                                                : formData.soft_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                            const isAdded = currentSkills.includes(skill);
                                            return (
                                                <button
                                                    key={skill}
                                                    onClick={() => {
                                                        if (!isAdded) {
                                                            setFormData({
                                                                ...formData,
                                                                soft_skills: [...currentSkills, skill]
                                                            });
                                                        }
                                                    }}
                                                    disabled={isAdded}
                                                    className={`px-3 py-1.5 rounded-lg text-xs font-bold border-2 transition-all ${isAdded
                                                        ? "bg-slate-200 text-slate-400 border-slate-300 cursor-not-allowed"
                                                        : "bg-white text-slate-700 border-slate-300 hover:border-[#8B1538] hover:text-[#8B1538]"
                                                        }`}
                                                >
                                                    {isAdded && <i className="fas fa-check mr-1"></i>}
                                                    {skill}
                                                </button>
                                            );
                                        })}
                                    </div>
                                </div>

                                {/* Custom Input */}
                                <div className="relative">
                                    <input
                                        type="text"
                                        placeholder="Type to add custom soft skill..."
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                        onKeyDown={(e) => {
                                            if (e.key === "Enter" && e.currentTarget.value.trim()) {
                                                e.preventDefault();
                                                const newSkill = e.currentTarget.value.trim();
                                                const currentSkills = Array.isArray(formData.soft_skills)
                                                    ? formData.soft_skills
                                                    : formData.soft_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                                if (!currentSkills.includes(newSkill)) {
                                                    setFormData({
                                                        ...formData,
                                                        soft_skills: [...currentSkills, newSkill]
                                                    });
                                                    e.currentTarget.value = "";
                                                }
                                            }
                                        }}
                                    />
                                    <p className="text-[10px] text-slate-500 mt-1 ml-1">Press Enter to add</p>
                                </div>
                            </div>

                            {/* Technical Skills Section */}
                            <div>
                                <label className="block text-xs font-bold text-[#1F2937] mb-3">Technical Skills</label>

                                {/* Selected Skills Display */}
                                <div className="flex flex-wrap gap-2 mb-4 min-h-[40px] p-3 bg-slate-50 rounded-xl border border-slate-200">
                                    {(Array.isArray(formData.technical_skills) ? formData.technical_skills : formData.technical_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || []).map((skill: string, idx: number) => (
                                        <span
                                            key={idx}
                                            className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-2"
                                        >
                                            {skill}
                                            <button
                                                onClick={() => {
                                                    const skills = Array.isArray(formData.technical_skills)
                                                        ? formData.technical_skills
                                                        : formData.technical_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                                    setFormData({
                                                        ...formData,
                                                        technical_skills: skills.filter((_: any, i: number) => i !== idx)
                                                    });
                                                }}
                                                className="hover:bg-white/20 rounded-full w-4 h-4 flex items-center justify-center"
                                            >
                                                <i className="fas fa-times text-[10px]"></i>
                                            </button>
                                        </span>
                                    ))}
                                    {(Array.isArray(formData.technical_skills) ? formData.technical_skills.length === 0 : !formData.technical_skills) && (
                                        <span className="text-slate-400 text-sm italic">No technical skills added yet</span>
                                    )}
                                </div>

                                {/* Suggested Technical Skills */}
                                <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-3">
                                    <p className="text-xs font-bold text-blue-900 mb-3 flex items-center gap-2">
                                        <i className="fas fa-code"></i> Suggested based on your profile
                                    </p>
                                    <div className="flex flex-wrap gap-2">
                                        {["JavaScript", "Python", "Java", "React", "Node.js", "SQL", "HTML/CSS", "Git", "TypeScript", "PHP", "C#", "AWS", "Docker", "MongoDB"].map((skill) => {
                                            const currentSkills = Array.isArray(formData.technical_skills)
                                                ? formData.technical_skills
                                                : formData.technical_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                            const isAdded = currentSkills.includes(skill);
                                            return (
                                                <button
                                                    key={skill}
                                                    onClick={() => {
                                                        if (!isAdded) {
                                                            setFormData({
                                                                ...formData,
                                                                technical_skills: [...currentSkills, skill]
                                                            });
                                                        }
                                                    }}
                                                    disabled={isAdded}
                                                    className={`px-3 py-1.5 rounded-lg text-xs font-bold border-2 transition-all ${isAdded
                                                        ? "bg-slate-200 text-slate-400 border-slate-300 cursor-not-allowed"
                                                        : "bg-white text-slate-700 border-slate-300 hover:border-[#8B1538] hover:text-[#8B1538]"
                                                        }`}
                                                >
                                                    {isAdded && <i className="fas fa-check mr-1"></i>}
                                                    {skill}
                                                </button>
                                            );
                                        })}
                                    </div>
                                </div>

                                {/* Custom Input */}
                                <div className="relative">
                                    <input
                                        type="text"
                                        placeholder="Type to add custom technical skill..."
                                        className="w-full border border-[#E5E7EB] rounded-xl px-4 py-2.5 text-sm"
                                        onKeyDown={(e) => {
                                            if (e.key === "Enter" && e.currentTarget.value.trim()) {
                                                e.preventDefault();
                                                const newSkill = e.currentTarget.value.trim();
                                                const currentSkills = Array.isArray(formData.technical_skills)
                                                    ? formData.technical_skills
                                                    : formData.technical_skills?.split(",").map((s: string) => s.trim()).filter(Boolean) || [];
                                                if (!currentSkills.includes(newSkill)) {
                                                    setFormData({
                                                        ...formData,
                                                        technical_skills: [...currentSkills, newSkill]
                                                    });
                                                    e.currentTarget.value = "";
                                                }
                                            }
                                        }}
                                    />
                                    <p className="text-[10px] text-slate-500 mt-1 ml-1">Press Enter to add</p>
                                </div>
                            </div>
                        </div>
                        <div className="flex justify-end gap-3 p-6 border-t border-[#E5E7EB] flex-shrink-0 bg-white">
                            <button
                                onClick={() => setActiveModal(null)}
                                className="px-6 py-2.5 text-sm font-bold text-[#6B7280] hover:bg-slate-50 rounded-xl"
                            >
                                Cancel
                            </button>
                            <button
                                onClick={() => handleUpdate("skills", formData)}
                                className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-8 py-2.5 rounded-xl font-bold text-sm"
                            >
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Success Notification Modal */}
            {showSuccessNotification && (
                <div className="fixed inset-0 z-[200] flex items-center justify-center p-4 pointer-events-none">
                    <div className="bg-white rounded-2xl shadow-2xl border-2 border-emerald-500 overflow-hidden animate-in zoom-in-95 duration-300 pointer-events-auto max-w-md w-full">
                        <div className="bg-gradient-to-r from-emerald-500 to-emerald-600 p-4">
                            <div className="flex items-center gap-3 text-white">
                                <div className="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i className="fas fa-check text-2xl"></i>
                                </div>
                                <div className="flex-grow">
                                    <h3 className="font-bold text-lg">Success!</h3>
                                    <p className="text-sm text-emerald-50">Profile updated successfully</p>
                                </div>
                                <button
                                    onClick={() => setShowSuccessNotification(false)}
                                    className="text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition-colors"
                                >
                                    <i className="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div className="p-4 bg-emerald-50">
                            <p className="text-sm text-emerald-800 flex items-center gap-2">
                                <i className="fas fa-info-circle"></i>
                                Your changes have been saved and are now visible on your profile.
                            </p>
                        </div>
                        {/* Auto-dismiss progress bar */}
                        <div className="h-1 bg-emerald-100">
                            <div className="h-full bg-emerald-500 animate-[shrink_3s_linear]" style={{ width: '100%' }}></div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
