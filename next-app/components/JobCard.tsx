"use client";

import React, { useState } from "react";

interface JobCardProps {
    job: any;
}

const JobCard = ({ job }: JobCardProps) => {
    const [showModal, setShowModal] = useState(false);
    const [uploading, setUploading] = useState(false);
    const [file, setFile] = useState<File | null>(null);

    const handleApply = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!file) return;

        setUploading(true);
        // Simulation for now, as file upload requires more backend setup
        setTimeout(() => {
            alert("Application submitted successfully! (Demo Mode)");
            setUploading(false);
            setShowModal(false);
        }, 1500);
    };

    return (
        <>
            <div
                onClick={() => setShowModal(true)}
                className="bg-white border border-[#E5E7EB] rounded-2xl p-6 flex flex-col md:flex-row items-center gap-6 cursor-pointer hover:border-[#D4A574] hover:shadow-md hover:-translate-y-0.5 transition-all shadow-sm"
            >
                <div className="w-16 h-16 bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-[#D4A574] rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                    <i className="fas fa-briefcase"></i>
                </div>

                <div className="flex-grow text-center md:text-left">
                    <h3 className="text-lg font-bold text-[#1F2937] mb-1">{job.job_title}</h3>
                    <p className="text-sm text-[#6B7280] flex items-center justify-center md:justify-start gap-2 mb-1">
                        <i className="fas fa-building"></i> {job.company}
                    </p>
                    <p className="text-sm text-[#6B7280] flex items-center justify-center md:justify-start gap-2">
                        <i className="fas fa-map-marker-alt"></i> {job.location}
                        <span className="text-[#8B1538] font-bold">•</span>
                        <i className="fas fa-coins"></i> {job.salary_range}
                    </p>
                </div>

                <div className="flex-shrink-0">
                    <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-4 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2">
                        <i className="fas fa-robot"></i> {job.matchScore || 0}% Match
                    </div>
                </div>
            </div>

            {showModal && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">
                    <div className="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
                        <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white p-8 flex justify-between items-start">
                            <div>
                                <h2 className="text-2xl font-bold mb-1">{job.job_title}</h2>
                                <p className="text-[#D4A574] font-semibold">{job.company}</p>
                            </div>
                            <button
                                onClick={() => setShowModal(false)}
                                className="text-white text-3xl hover:scale-110 transition-transform"
                            >
                                &times;
                            </button>
                        </div>

                        <div className="p-8">
                            <div className="flex gap-6 mb-6">
                                <div className="flex-grow space-y-3">
                                    <p className="text-sm text-[#1F2937] flex items-center gap-2">
                                        <strong className="text-[#8B1538]">
                                            <i className="fas fa-map-marker-alt mr-2"></i>Location:
                                        </strong>{" "}
                                        {job.location}
                                    </p>
                                    <p className="text-sm text-[#1F2937] flex items-center gap-2">
                                        <strong className="text-[#D4A574]">
                                            <i className="fas fa-coins mr-2"></i>Salary:
                                        </strong>{" "}
                                        {job.salary_range}
                                    </p>
                                </div>
                                <div className="bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white px-5 py-3 rounded-xl font-bold text-sm h-fit self-center flex items-center gap-2">
                                    <i className="fas fa-robot"></i> {job.matchScore || 0}% AI Match
                                </div>
                            </div>

                            <hr className="border-[#E5E7EB] mb-6" />

                            <div className="max-h-60 overflow-y-auto pr-4 space-y-4 mb-8 custom-scrollbar">
                                <div>
                                    <p className="text-sm font-bold text-[#8B1538] mb-2 flex items-center gap-2">
                                        <i className="fas fa-list-check"></i> Requirements:
                                    </p>
                                    <p className="text-sm text-[#6B7280] leading-relaxed">{job.qualifications}</p>
                                </div>
                                <div>
                                    <p className="text-sm font-bold text-[#D4A574] mb-2 flex items-center gap-2">
                                        <i className="fas fa-briefcase"></i> About the Role:
                                    </p>
                                    <p className="text-sm text-[#6B7280] leading-relaxed whitespace-pre-wrap">
                                        {job.description}
                                    </p>
                                </div>
                            </div>

                            <div className="bg-[#f9f9f9] p-6 rounded-2xl border border-[#E5E7EB]">
                                <form onSubmit={handleApply}>
                                    <p className="text-sm font-bold text-[#1F2937] mb-4 flex items-center gap-2">
                                        <i className="fas fa-file-upload text-[#8B1538]"></i> Upload Your Resume
                                    </p>
                                    <label className="block border-2 border-dashed border-[#E5E7EB] rounded-2xl p-8 text-center cursor-pointer hover:border-[#8B1538] hover:bg-[#8B1538]/5 transition-all mb-6 group">
                                        <input
                                            type="file"
                                            accept=".pdf"
                                            className="hidden"
                                            onChange={(e) => setFile(e.target.files?.[0] || null)}
                                        />
                                        <i className="fas fa-cloud-arrow-up text-4xl text-[#D4A574] group-hover:scale-110 transition-transform mb-3 block"></i>
                                        <p className="text-sm font-bold text-[#1F2937]">
                                            {file ? file.name : "Click to upload or drag & drop"}
                                        </p>
                                        <p className="text-xs text-[#6B7280] mt-1">PDF ONLY</p>
                                    </label>

                                    <button
                                        disabled={!file || uploading}
                                        className="w-full bg-gradient-to-br from-[#8B1538] to-[#6B0F2A] text-white py-4 rounded-xl font-bold text-sm shadow-sm hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center justify-center gap-3"
                                    >
                                        {uploading ? (
                                            <>
                                                <i className="fas fa-spinner fa-spin"></i> Submitting...
                                            </>
                                        ) : (
                                            <>
                                                <i className="fas fa-paper-plane"></i> Submit Application
                                            </>
                                        )}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default JobCard;
