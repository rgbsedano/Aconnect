"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";

const registerSchema = z.object({
    student_number: z.string().min(1, "Student number is required"),
    password: z.string().min(6, "Password must be at least 6 characters"),
    first_name: z.string().min(1, "First name is required"),
    last_name: z.string().min(1, "Last name is required"),
    email: z.string().email("Invalid email address"),
    alternative_email: z.string().email("Invalid alternate email address"),
    phone: z.string().min(1, "Phone number is required"),
    telephone: z.string().optional(),
    graduation_year: z.string().min(1, "Graduation year is required"),
    degree: z.string().min(1, "Degree is required"),
    degree_other: z.string().optional(),
    gender: z.string().min(1, "Gender is required"),
});

type RegisterFormValues = z.infer<typeof registerSchema>;

export default function RegisterPage() {
    const router = useRouter();
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const {
        register,
        handleSubmit,
        watch,
        formState: { errors },
    } = useForm<RegisterFormValues>({
        resolver: zodResolver(registerSchema),
    });

    const selectedDegree = watch("degree");

    const onSubmit = async (data: RegisterFormValues) => {
        setLoading(true);
        setError(null);
        setSuccess(null);

        try {
            const response = await fetch("/api/auth/register", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || "Registration failed");
            }

            setSuccess(result.message);
            // Wait a bit then redirect
            setTimeout(() => router.push("/login"), 3000);
        } catch (err: any) {
            setError(err.message);
            setLoading(false);
        }
    };

    const currentYear = new Date().getFullYear();
    const years = Array.from({ length: 16 }, (_, i) => (currentYear + 5 - i).toString());

    return (
        <div className="flex min-h-screen bg-[#f7f7f7]">
            <div className="hidden md:flex flex-[0_0_50%] items-center justify-center overflow-hidden bg-[#920E0E]">
                <img
                    src="/assets/images/circles.png"
                    className="w-full h-full object-cover"
                    alt="AConnect Platform Visual"
                />
            </div>

            <div className="flex flex-[0_0_50%] flex-col items-center justify-start p-8 bg-white overflow-y-auto max-h-screen">
                <div className="w-full max-w-[450px]">
                    <div className="text-center mb-2">
                        <img
                            src="/assets/images/logo.png"
                            alt="AConnect Logo"
                            className="mx-auto max-w-[150px] h-auto"
                        />
                    </div>

                    <h1 className="text-[1.6rem] font-bold text-[#333] text-center mb-6">
                        Create Your AConnect Profile
                    </h1>

                    {success && (
                        <div className="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded text-sm">
                            {success}
                        </div>
                    )}

                    {error && (
                        <div className="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded text-sm">
                            {error}
                        </div>
                    )}

                    <form onSubmit={handleSubmit(onSubmit)} className="space-y-3 pb-8">
                        <div className="grid grid-cols-1 gap-3">
                            <div>
                                <input
                                    {...register("student_number")}
                                    type="text"
                                    placeholder="Student Number (e.g., 2017-00001)"
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                />
                                {errors.student_number && <p className="text-red-500 text-xs mt-1">{errors.student_number.message}</p>}
                            </div>

                            <div>
                                <input
                                    {...register("password")}
                                    type="password"
                                    placeholder="Password"
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                />
                                {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password.message}</p>}
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <input
                                        {...register("first_name")}
                                        type="text"
                                        placeholder="First Name"
                                        className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                    />
                                    {errors.first_name && <p className="text-red-500 text-xs mt-1">{errors.first_name.message}</p>}
                                </div>
                                <div>
                                    <input
                                        {...register("last_name")}
                                        type="text"
                                        placeholder="Last Name"
                                        className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                    />
                                    {errors.last_name && <p className="text-red-500 text-xs mt-1">{errors.last_name.message}</p>}
                                </div>
                            </div>

                            <div>
                                <input
                                    {...register("email")}
                                    type="email"
                                    placeholder="Email - (Do not use the SDCA Email)"
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                />
                                {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email.message}</p>}
                            </div>

                            <div>
                                <input
                                    {...register("alternative_email")}
                                    type="email"
                                    placeholder="Alternate Email"
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                />
                                {errors.alternative_email && <p className="text-red-500 text-xs mt-1">{errors.alternative_email.message}</p>}
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <input
                                        {...register("phone")}
                                        type="tel"
                                        placeholder="Phone (09xxxxxxxxx)"
                                        className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                    />
                                    {errors.phone && <p className="text-red-500 text-xs mt-1">{errors.phone.message}</p>}
                                </div>
                                <div>
                                    <input
                                        {...register("telephone")}
                                        type="text"
                                        placeholder="Telephone"
                                        className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                    />
                                </div>
                            </div>

                            <div>
                                <select
                                    {...register("graduation_year")}
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 bg-white"
                                >
                                    <option value="">Graduation Year</option>
                                    {years.map((year) => (
                                        <option key={year} value={year}>{year}</option>
                                    ))}
                                </select>
                                {errors.graduation_year && <p className="text-red-500 text-xs mt-1">{errors.graduation_year.message}</p>}
                            </div>

                            <div>
                                <label className="text-sm font-semibold mb-1 block">Degree</label>
                                <select
                                    {...register("degree")}
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 bg-white"
                                >
                                    <option value="">-- Select Degree --</option>
                                    <optgroup label="School of Nursing and Allied Health Studies">
                                        <option>BS in Nursing</option>
                                        <option>BS in Radiologic Technology</option>
                                        <option>BS in Physical Therapy</option>
                                    </optgroup>
                                    <optgroup label="School of Medical Laboratory Science">
                                        <option>BS in Medical Laboratory Science</option>
                                        <option>BS in Pharmacy</option>
                                        <option>BS in Biology</option>
                                    </optgroup>
                                    <optgroup label="School of Accountancy, Science, and Education">
                                        <option>BS in Accountancy</option>
                                        <option>BS in Accounting Technology / AIS</option>
                                        <option>BS in Psychology</option>
                                        <option>BS in Elementary Education</option>
                                        <option>BS in Secondary Education</option>
                                    </optgroup>
                                    <optgroup label="School of International, Hospitality, Tourism & Management">
                                        <option>BS in Business Administration - Financial Management</option>
                                        <option>BS in Business Administration - Marketing Management</option>
                                        <option>BS in Business Administration - HR Development</option>
                                        <option>BS in Business Administration - Operations Management</option>
                                        <option>BS in Tourism Management</option>
                                        <option>BS in Hospitality Management</option>
                                        <option>BS in Hospitality Management - Culinary Arts</option>
                                        <option>BS in Hospitality Management - Cruiseline Operations</option>
                                    </optgroup>
                                    <optgroup label="School of Communication, Multimedia, and Computer Studies">
                                        <option>BA in Communication</option>
                                        <option>Bachelor of Multimedia Arts</option>
                                        <option>BS in Information Technology</option>
                                    </optgroup>
                                    <option value="Other">Other (Not Listed)</option>
                                </select>
                                {errors.degree && <p className="text-red-500 text-xs mt-1">{errors.degree.message}</p>}
                            </div>

                            {selectedDegree === "Other" && (
                                <div>
                                    <label className="text-sm font-semibold mb-1 block">Please specify your degree</label>
                                    <input
                                        {...register("degree_other")}
                                        type="text"
                                        placeholder="Enter your degree"
                                        className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20"
                                    />
                                </div>
                            )}

                            <div>
                                <select
                                    {...register("gender")}
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 bg-white"
                                >
                                    <option value="">Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                {errors.gender && <p className="text-red-500 text-xs mt-1">{errors.gender.message}</p>}
                            </div>

                            <div>
                                <label className="text-sm font-semibold mb-1 block">Profile Picture (Optional)</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    className="w-full h-[40px] px-[15px] border border-[#ddd] rounded outline-none focus:border-[#700A0A] focus:ring-1 focus:ring-[#700A0A]/20 py-1"
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            disabled={loading}
                            className="w-full h-[48px] bg-[#700A0A] text-white font-bold uppercase rounded hover:bg-[#550808] transition-colors mt-4 disabled:opacity-50"
                        >
                            {loading ? "Registering..." : "Register Account"}
                        </button>
                    </form>

                    <div className="mt-4 pt-4 border-t border-[#eee] text-center">
                        <p className="text-[0.85rem] text-[#6c757d]">
                            Already have an account?{" "}
                            <Link href="/login" className="text-[#700A0A] font-semibold hover:underline">
                                Log in here
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}
