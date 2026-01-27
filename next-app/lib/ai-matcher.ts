export function computeAiMatch(alumni: any, job: any) {
    if (!alumni) return 0;

    const wTech = 30;
    const wSoft = 10;
    const wKey = 5;
    const wTitle = 55;

    let score = 0;
    let titleMatch = 0;

    const jobTitle = (job.job_title || "").toLowerCase();
    const deg = (alumni.degree || "").toLowerCase();

    // Basic title matching logic from original PHP
    if (jobTitle.includes("it") && deg.includes("information technology")) titleMatch = 1;
    if (jobTitle.includes("developer") && deg.includes("information technology")) titleMatch = 1;
    if (jobTitle.includes("programmer") && deg.includes("information technology")) titleMatch = 1;
    if (jobTitle.includes("software") && deg.includes("information technology")) titleMatch = 1;
    if (jobTitle.includes("technical") && deg.includes("information technology")) titleMatch = 1;
    if (jobTitle.includes("nurse") && deg.includes("nursing")) titleMatch = 1;
    if (jobTitle.includes("staff nurse") && deg.includes("nursing")) titleMatch = 1;
    if (jobTitle.includes("radtech") && deg.includes("radiologic")) titleMatch = 1;
    if (jobTitle.includes("radiologic") && deg.includes("radiologic")) titleMatch = 1;
    if (jobTitle.includes("marketing") && deg.includes("business")) titleMatch = 1;
    if (jobTitle.includes("hr") && deg.includes("business")) titleMatch = 1;
    if (jobTitle.includes("finance") && deg.includes("accountancy")) titleMatch = 1;
    if (jobTitle.includes("graphic") && deg.includes("multimedia")) titleMatch = 1;
    if (jobTitle.includes("designer") && deg.includes("multimedia")) titleMatch = 1;
    if (jobTitle.includes("editor") && deg.includes("communication")) titleMatch = 1;
    if (jobTitle.includes("writer") && deg.includes("communication")) titleMatch = 1;

    // Technical Skills Match
    const alTech = (alumni.technical_skills || "")
        .split(",")
        .map((s: string) => s.trim().toLowerCase())
        .filter(Boolean);
    const jobTech = (job.qualifications || "")
        .split(",")
        .map((s: string) => s.trim().toLowerCase())
        .filter(Boolean);

    let techMatch = 0;
    if (jobTech.length > 0) {
        const matches = alTech.filter((skill: string) => jobTech.includes(skill));
        techMatch = matches.length / jobTech.length;
    }

    // Soft Skills Match
    const alSoft = (alumni.soft_skills || "")
        .split(",")
        .map((s: string) => s.trim().toLowerCase())
        .filter(Boolean);
    const desc = (job.description || "").toLowerCase();
    let softCount = 0;
    alSoft.forEach((soft: string) => {
        if (desc.includes(soft)) softCount++;
    });
    const softMatch = alSoft.length > 0 ? softCount / alSoft.length : 0;

    // Keyword Match
    const searchSpace = `${job.company} ${job.job_title} ${job.description}`.toLowerCase();
    let keyMatch = 0;
    if (alTech.some((skill: string) => searchSpace.includes(skill))) {
        keyMatch = 1;
    }

    score = techMatch * wTech + softMatch * wSoft + keyMatch * wKey + titleMatch * wTitle;
    return Math.round(score);
}
