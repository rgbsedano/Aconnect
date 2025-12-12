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
