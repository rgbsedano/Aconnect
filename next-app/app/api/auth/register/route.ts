import { NextRequest, NextResponse } from "next/server";
import prisma from "@/lib/prisma";
import bcrypt from "bcryptjs";
import crypto from "crypto";
import { sendVerificationEmail } from "@/lib/email";

export async function POST(req: NextRequest) {
    try {
        const body = await req.json();
        const {
            first_name,
            last_name,
            email,
            password,
            phone,
            telephone,
            alternative_email,
            graduation_year,
            student_number,
            degree,
            gender,
            degree_other,
        } = body;

        // Check if user already exists
        const existingUser = await prisma.alumni.findFirst({
            where: {
                OR: [
                    { email },
                    { student_number }
                ]
            }
        });

        if (existingUser) {
            return NextResponse.json(
                { message: "Email or Student Number already registered" },
                { status: 400 }
            );
        }

        const hashedPassword = await bcrypt.hash(password, 10);
        const token = crypto.randomBytes(32).toString("hex");
        const finalDegree = degree === "Other" ? degree_other : degree;

        const user = await prisma.alumni.create({
            data: {
                first_name,
                last_name,
                email,
                password: hashedPassword,
                phone,
                telephone,
                alternative_email,
                graduation_year: graduation_year ? parseInt(graduation_year) : null,
                student_number,
                degree: finalDegree,
                gender,
                status: "inactive",
                email_verified: false,
                verification_token: token,
                year_admitted: 0, // Fallback for mandatory field from schema
            },
        });

        await sendVerificationEmail(email, token);

        return NextResponse.json(
            { message: "Registration successful! Please verify your email." },
            { status: 201 }
        );
    } catch (error: any) {
        console.error("Registration error:", error);
        return NextResponse.json(
            { message: error.message || "Internal Server Error" },
            { status: 500 }
        );
    }
}
