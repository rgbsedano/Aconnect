const { PrismaClient } = require("./next-app/app/generated/prisma");
const prisma = new PrismaClient();

async function main() {
    try {
        const posts = await prisma.post.findMany();
        console.log("Found posts:", posts.length);
        process.exit(0);
    } catch (e) {
        console.error("Error connecting to DB:", e);
        process.exit(1);
    }
}

main();
