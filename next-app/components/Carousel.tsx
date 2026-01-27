"use client";

import { useState, useEffect } from "react";
import Image from "next/image";

interface CarouselProps {
    photos: { id: number; file_name: string }[];
}

const Carousel = ({ photos }: CarouselProps) => {
    const [current, setCurrent] = useState(0);

    useEffect(() => {
        if (photos.length === 0) return;
        const interval = setInterval(() => {
            setCurrent((prev) => (prev + 1) % photos.length);
        }, 5000);
        return () => clearInterval(interval);
    }, [photos]);

    if (photos.length === 0) return null;

    return (
        <div className="relative h-full w-full rounded-[16px] overflow-hidden shadow-lg bg-white border border-black/10">
            {photos.map((photo, index) => (
                <div
                    key={photo.id}
                    className={`absolute inset-0 transition-opacity duration-1000 ${index === current ? "opacity-100" : "opacity-0"
                        }`}
                >
                    <img
                        src={`/assets/uploads/carousel/${photo.file_name}`}
                        alt="Carousel Image"
                        className="w-full h-full object-cover"
                    />
                </div>
            ))}

            <button
                onClick={() => setCurrent((prev) => (prev - 1 + photos.length) % photos.length)}
                className="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-2xl"
            >
                <i className="fas fa-chevron-left"></i>
            </button>
            <button
                onClick={() => setCurrent((prev) => (prev + 1) % photos.length)}
                className="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-2xl"
            >
                <i className="fas fa-chevron-right"></i>
            </button>
        </div>
    );
};

export default Carousel;
