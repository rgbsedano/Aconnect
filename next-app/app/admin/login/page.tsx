"use client";

import { useState } from "react";
import { signIn } from "next-auth/react";
import { useRouter } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";

const adminLoginSchema = z.object({
    username: z.string().min(1, "Username is required"),
    password: z.string().min(1, "Password is required"),
});

type AdminLoginFormValues = z.infer<typeof adminLoginSchema>;

export default function AdminLoginPage() {
    const router = useRouter();
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm<AdminLoginFormValues>({
        resolver: zodResolver(adminLoginSchema),
    });

    const onSubmit = async (data: AdminLoginFormValues) => {
        setLoading(true);
        setError(null);

        const result = await signIn("admin", {
            username: data.username,
            password: data.password,
            redirect: false,
        });

        if (result?.error) {
            setError(result.error);
            setLoading(false);
        } else {
            router.push("/dashboard");
            router.refresh();
        }
    };

    return (
        <div className="flex min-h-screen bg-[#F8FAFC] font-jakarta antialiased">
            {/* Left Side: Visual & Brand */}
            <div className="hidden lg:flex flex-1 relative bg-[#1F2937] overflow-hidden">
                <div className="absolute inset-0 z-0">
                    <img
                        src="/assets/images/welcome.png"
                        className="w-full h-full object-cover opacity-20 grayscale multiply scale-110"
                        alt="Admin Background"
                    />
                </div>
                <div className="absolute inset-0 bg-gradient-to-br from-[#111827]/95 via-[#1F2937]/90 to-transparent z-10"></div>

                <div className="relative z-20 flex flex-col justify-center px-20 text-white">
                    <div className="w-16 h-16 bg-white/10 backdrop-blur-xl rounded-2xl mb-8 flex items-center justify-center border border-white/20">
                        <i className="fas fa-shield-halved text-[#9CA3AF] text-3xl"></i>
                    </div>
                    <h2 className="text-5xl font-extrabold mb-6 leading-tight tracking-tight">
                        Administrative <br />
                        <span className="text-[#9CA3AF]">Control</span> & <br />
                        Management.
                    </h2>
                    <p className="text-xl text-white/60 max-w-md leading-relaxed">
                        Secure access to the AConnect management suite. Monitor metrics, manage users, and oversee the alumni network infrastructure.
                    </p>

                    <div className="mt-16 grid grid-cols-2 gap-8">
                        <div>
                            <p className="text-3xl font-bold text-white">100%</p>
                            <p className="text-sm text-white/40 font-bold uppercase tracking-wider">Secure Access</p>
                        </div>
                        <div>
                            <p className="text-3xl font-bold text-white">24/7</p>
                            <p className="text-sm text-white/40 font-bold uppercase tracking-wider">System Monitoring</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Right Side: Login Form */}
            <div className="flex flex-1 flex-col items-center justify-center p-8 lg:p-20 bg-white relative">
                <div className="w-full max-w-[400px]">
                    <div className="mb-12">
                        <Link href="/">
                            <img
                                src="/assets/images/logo.png"
                                alt="AConnect Logo"
                                className="h-16 w-auto mb-8 hover:opacity-80 transition-opacity mx-auto lg:mx-0"
                            />
                        </Link>
                        <div className="space-y-2 text-center lg:text-left">
                            <h1 className="text-3xl font-bold text-[#1F2937] tracking-tight">
                                Administrator Portal
                            </h1>
                            <p className="text-[#6B7280] font-medium">
                                authorized personnell session only.
                            </p>
                        </div>
                    </div>

                    {error && (
                        <div className="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3 text-sm animate-in shake duration-300">
                            <i className="fas fa-shield-exclamation text-lg"></i>
                            <p className="font-bold">{error}</p>
                        </div>
                    )}

                    <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
                        <div className="space-y-1.5">
                            <label className="text-xs font-black text-[#6B7280] uppercase tracking-widest pl-1">
                                Username
                            </label>
                            <div className="relative group">
                                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i className="fas fa-user-shield text-[#9CA3AF] group-focus-within:text-[#111827] transition-colors"></i>
                                </div>
                                <input
                                    {...register("username")}
                                    type="text"
                                    placeholder="Enter admin username"
                                    className={`w-full h-14 pl-12 pr-4 bg-[#F9FAFB] border rounded-2xl transition-all outline-none text-[#1F2937] font-medium placeholder:text-[#9CA3AF] focus:bg-white focus:ring-4 focus:ring-black/5 ${errors.username ? "border-rose-500" : "border-[#E5E7EB] focus:border-[#1F2937]"
                                        }`}
                                />
                            </div>
                            {errors.username && (
                                <p className="text-rose-500 text-xs mt-1.5 font-bold pl-1">{errors.username.message}</p>
                            )}
                        </div>

                        <div className="space-y-1.5">
                            <label className="text-xs font-black text-[#6B7280] uppercase tracking-widest pl-1">
                                Password
                            </label>
                            <div className="relative group">
                                <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i className="fas fa-key text-[#9CA3AF] group-focus-within:text-[#111827] transition-colors"></i>
                                </div>
                                <input
                                    {...register("password")}
                                    type="password"
                                    placeholder="••••••••"
                                    className={`w-full h-14 pl-12 pr-4 bg-[#F9FAFB] border rounded-2xl transition-all outline-none text-[#1F2937] font-medium placeholder:text-[#9CA3AF] focus:bg-white focus:ring-4 focus:ring-black/5 ${errors.password ? "border-rose-500" : "border-[#E5E7EB] focus:border-[#1F2937]"
                                        }`}
                                />
                            </div>
                            {errors.password && (
                                <p className="text-rose-500 text-xs mt-1.5 font-bold pl-1">{errors.password.message}</p>
                            )}
                        </div>

                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full h-14 bg-[#1F2937] text-white font-bold rounded-2xl shadow-lg hover:bg-black hover:-translate-y-0.5 active:translate-y-0 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3"
                        >
                            {loading ? (
                                <>
                                    <i className="fas fa-circle-notch fa-spin"></i>
                                    Authenticating...
                                </>
                            ) : (
                                <>
                                    <span>Access Dashboard</span>
                                    <i className="fas fa-arrow-right"></i>
                                </>
                            )}
                        </button>
                    </form>

                    <div className="mt-12 pt-8 border-t border-[#F3F4F6] text-center">
                        <Link href="/login" className="text-sm font-bold text-[#6B7280] hover:text-[#1F2937] flex items-center justify-center gap-2 group">
                            <i className="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                            <span>Return to Alumni Portal</span>
                        </Link>
                    </div>
                </div>

                <div className="absolute bottom-8 text-[10px] text-[#9CA3AF] uppercase tracking-[2px] font-bold text-center">
                    Systems Managed by AConnect IT Infrastructure
                </div>
            </div>
        </div>
    );
}
