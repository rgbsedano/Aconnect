import type { Metadata } from "next";
import { Nunito } from "next/font/google";
import "./globals.css";
import { Providers } from "@/components/Providers";

const nunito = Nunito({
  subsets: ["latin"],
  variable: "--font-nunito",
  weight: ["200", "400", "600", "700", "800"],
});

export const metadata: Metadata = {
  title: "AConnect | Alumni & Career Platform",
  description: "Connect with your fellow alumni and unlock exclusive career opportunities.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <head>
        <link
          href="/assets/fontawesome-free/css/all.min.css"
          rel="stylesheet"
          type="text/css"
        />
      </head>
      <body className={`${nunito.variable} font-sans antialiased text-[#333]`}>
        <Providers>{children}</Providers>
      </body>
    </html>
  );
}
