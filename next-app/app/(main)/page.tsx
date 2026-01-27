import prisma from "@/lib/prisma";
import Carousel from "@/components/Carousel";
import PostSection from "@/components/PostSection";
import { post } from "@prisma/client";

export const dynamic = "force-dynamic";

export default async function Home() {
    let photos: any[] = [];
    let allPosts: post[] = [];

    try {
        photos = await prisma.carousel_photos.findMany({
            orderBy: { uploaded_at: "desc" },
        });

        allPosts = await prisma.post.findMany({
            orderBy: { created_at: "desc" },
        });
    } catch (error) {
        console.error("Database fetch error:", error);
    }

    const groupedPosts: Record<string, post[]> = {
        announcements: allPosts.filter((p) => p.post_type === "announcements"),
        news: allPosts.filter((p) => p.post_type === "news"),
        stories: allPosts.filter((p) => p.post_type === "stories"),
    };

    return (
        <div className="flex-1 flex flex-col items-center justify-center p-[30px] min-h-[calc(100vh-55px)] bg-[#f3f2ef]">
            <div className="w-full max-w-[1300px] h-[85vh] grid grid-cols-1 md:grid-cols-[1.3fr_1fr] gap-[32px]">

                <div className="h-full min-h-0 hidden md:block">
                    {photos.length > 0 ? (
                        <Carousel photos={photos} />
                    ) : (
                        <div className="h-full w-full rounded-[16px] bg-white border border-black/10 flex items-center justify-center">
                            <p className="text-[#666]">No carousel photos found.</p>
                        </div>
                    )}
                </div>

                <div className="flex flex-col gap-[18px] h-full min-h-0">
                    {allPosts.length > 0 ? (
                        Object.entries(groupedPosts).map(([type, posts]) => (
                            posts.length > 0 && <PostSection key={type} type={type} posts={posts} />
                        ))
                    ) : (
                        <div className="flex-1 bg-white rounded-[12px] p-8 flex items-center justify-center shadow-md">
                            <p className="text-[#666]">No posts found in the database.</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
