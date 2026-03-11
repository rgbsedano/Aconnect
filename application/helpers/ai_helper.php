<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Load HuggingFace Token from .env safely
 */
function load_hf_token()
{
    $envPath = FCPATH . '.env';

    if (!file_exists($envPath)) {
        log_message('error', '.env file missing!');
        return null;
    }

    $env = parse_ini_file($envPath);

    return isset($env['HF_TOKEN']) ? trim($env['HF_TOKEN']) : null;
}

/**
 * Compute AI Sentence Similarity Score
 */
function ai_similarity_score($source, $target)
{
    $token = load_hf_token();
    if (!$token) {
        return 0; // No token → always fail-safe return zero
    }

    $modelUrl = "https://api-inference.huggingface.co/models/sentence-transformers/all-MiniLM-L6-v2";

    $payload = [
        "inputs" => [
            "source_sentence" => $source,
            "sentences" => [$target]
        ]
    ];

    $ch = curl_init($modelUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return 0;
    }

    curl_close($ch);
    $result = json_decode($response, true);

    if (!isset($result[0])) {
        return 0;
    }

    // Convert similarity (0–1) to 0–100%
    return round($result[0] * 100);
}

/**
 * Normalize skill names to standard format
 */
function normalize_skill($skill) {
    $skill = strtolower(trim($skill));
    $map = [
        'js' => 'javascript',
        'nodejs' => 'node.js',
        'node js' => 'node.js',
        'mysql' => 'sql',
        'postgresql' => 'sql',
        'html5' => 'html',
        'css3' => 'css',
    ];
    return $map[$skill] ?? $skill;
}

/**
 * Compute AI match score between alumni and job
 */
function compute_ai_match($alumni, $job) {
    if (!$alumni) return 0;
    $wTitle = 25;   // reduced
    $wTech  = 45;   // MOST IMPORTANT
    $wSoft  = 15;
    $wKey   = 15;
    $score = 0; 
    $titleMatch = 0;

    $titleGroups = [
        'information technology' => ['it','developer','programmer','software','technical','web'],
        'nursing' => ['nurse','staff nurse','clinical nurse'],
        'radiologic' => ['radtech','radiologic','xray'],
        'business' => ['marketing','hr','human resource','business'],
        'accountancy' => ['finance','accounting','bookkeeper'],
        'multimedia' => ['graphic','designer','multimedia','ui','ux'],
        'communication' => ['editor','writer','content']
    ];

    $deg = strtolower($alumni->degree);
    $jobTitle = strtolower($job->job_title);

    foreach ($titleGroups as $degreeKey => $keywords) {
        if (strpos($deg, $degreeKey) !== false) {
            foreach ($keywords as $kw) {
                if (strpos($jobTitle, $kw) !== false) {
                    $titleMatch = 1;
                    break 2;
                }
            }
        }
    }

    $alTech = array_map('normalize_skill',
    array_filter(array_map('trim', explode(',', strtolower($alumni->technical_skills ?? ""))))
    );

    $jobTech = array_map('normalize_skill',
        array_filter(array_map('trim', explode(',', strtolower($job->qualifications ?? ""))))
    );

    $techMatch = 0;
    if (count($jobTech) > 0) {
        $match = array_intersect($alTech, $jobTech);
        $techMatch = count($match) / count($jobTech);
    }
    $alSoft = array_filter(array_map('trim', explode(',', strtolower($alumni->soft_skills ?? ""))));
    $desc = strtolower($job->description ?? "");
    $softCount = 0;
    foreach ($alSoft as $soft) { if (strpos($desc, $soft) !== false) $softCount++; }
    $softMatch = (count($alSoft) > 0)
        ? min(1, $softCount / max(3, count($alSoft)))
        : 0;

    $searchSpace = strtolower($job->company . " " . $job->job_title . " " . $job->description);
    $keyHits = 0;
    foreach ($alTech as $skill) {
        if (strpos($searchSpace, $skill) !== false) {
            $keyHits++;
        }
    }

    $keyMatch = count($alTech) > 0 ? $keyHits / count($alTech) : 0;

    $score = ($techMatch * $wTech) + ($softMatch * $wSoft) + ($keyMatch * $wKey) + ($titleMatch * $wTitle);
    return round($score);
}
