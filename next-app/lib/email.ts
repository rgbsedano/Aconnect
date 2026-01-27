import nodemailer from "nodemailer";

export const transporter = nodemailer.createTransport({
    host: "smtp.gmail.com",
    port: 587,
    secure: false, // true for 465, false for other ports
    auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASS,
    },
});

export const sendVerificationEmail = async (to: string, token: string) => {
    const verifyLink = `${process.env.NEXTAUTH_URL}/api/auth/verify?token=${token}`;

    const mailOptions = {
        from: `"AConnect Verification" <${process.env.EMAIL_USER}>`,
        to,
        subject: "Verify Your AConnect Account",
        html: `
      <h2>Welcome to AConnect!</h2>
      <p>Click the link below to verify your email:</p>
      <a href="${verifyLink}" target="_blank">${verifyLink}</a>
    `,
    };

    return transporter.sendMail(mailOptions);
};
