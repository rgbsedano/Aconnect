"use client";

import { useState } from "react";
import { signIn } from "next-auth/react";
import { useRouter, useSearchParams } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";

const loginSchema = z.object({
    student_number: z.string().min(1, "Student number is required"),
    password: z.string().min(1, "Password is required"),
});

type LoginFormValues = z.infer<typeof loginSchema>;

export default function LoginPage() {
    const router = useRouter();
    const searchParams = useSearchParams();
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const verified = searchParams.get("verified");

    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm<LoginFormValues>({
        resolver: zodResolver(loginSchema),
    });

    const onSubmit = async (data: LoginFormValues) => {
        setLoading(true);
        setError(null);

        const result = await signIn("alumni", {
            student_number: data.student_number,
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
        <div className="flex min-h-screen bg-[#f7f7f7]">
            <div className="hidden md:flex flex-1 items-center justify-center overflow-hidden bg-[#920E0E]">
                <img
                    src="/assets/images/welcome.png"
                    className="w-full h-full object-cover"
                    alt="AConnect Platform Visual"
                />
            </div>

            <div className="flex flex-1 flex-col items-center justify-center p-8 bg-white">
                <div className="w-full max-w-[350px]">
                    <div className="text-center mb-2">
                        <img
                            src="/assets/images/logo.png"
                            alt="AConnect Logo"
                            className="mx-auto max-w-[200px] h-auto"
                        />
                    </div>

                    <div className="text-center mb-8">
                        <h1 className="text-[1.8rem] font-bold text-[#333] mb-2 leading-tight">
                            AConnect: Alumni & Career Platform
                        </h1>
                        <p className="text-[0.95rem] text-[#6c757d]">
                            Connect with your fellow alumni and unlock exclusive career opportunities. Sign in to continue your journey.
                        </p>
                    </div>

                    {verified && (
                        <div className="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded text-center text-sm">
                            Your email is now verified! You may now log in.
                        </div>
                    )}

                    {error && (
                        <div className="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded text-center text-sm">
                            {error}
                        </div>
                    )}

                    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
                        <div>
                            <input
                                {...register("student_number")}
                                type="text"
                                placeholder="Student Number"
                                className={`w-full h-[48px] px-[15px] border rounded transition-all focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 outline-none ${errors.student_number ? "border-red-500" : "border-[#ddd]"
                                    }`}
                            />
                            {errors.student_number && (
                                <p className="text-red-500 text-xs mt-1">{errors.student_number.message}</p>
                            )}
                        </div>

                        <div>
                            <input
                                {...register("password")}
                                type="password"
                                placeholder="Password"
                                className={`w-full h-[48px] px-[15px] border rounded transition-all focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 outline-none ${errors.password ? "border-red-500" : "border-[#ddd]"
                                    }`}
                            />
                            {errors.password && (
                                <p className="text-red-500 text-xs mt-1">{errors.password.message}</p>
                            )}
                        </div>

                        <div className="flex items-center text-[0.9rem]">
                            <input
                                type="checkbox"
                                id="remember"
                                className="mr-2 w-4 h-4 cursor-pointer"
                            />
                            <label htmlFor="remember" className="cursor-pointer text-[#333]">Keep me signed in</label>
                        </div>

                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full h-[48px] bg-[#700A0A] text-white font-semibold rounded hover:bg-[#550808] transition-colors disabled:opacity-50"
                        >
                            {loading ? "Logging in..." : "Log in to AConnect"}
                        </button>
                    </form>

                    <div className="mt-8 pt-4 border-t border-[#eee] text-center">
                        <p className="text-[0.9rem] text-[#6c757d]">
                            New to AConnect?{" "}
                            <Link href="/register" className="text-[#700A0A] font-semibold hover:underline">
                                Create an Account
                            </Link>
                        </p>
                    </div>

                    <div className="mt-4 text-center">
                        <Link
                            href="/admin/login"
                            className="text-[0.9rem] text-black border border-[#ccc] px-[15px] py-2 rounded hover:bg-[#f0f0f0] transition-colors inline-block"
                        >
                            Admin Portal
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    );
}
