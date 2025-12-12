<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function ai_similarity_score($source, $target)
{
    // HuggingFace model (free)
    $modelUrl = "https://api-inference.huggingface.co/models/sentence-transformers/all-MiniLM-L6-v2";

    $payload = [
        "inputs" => [
            "source_sentence" => $source,
            "sentences" => [$target]
        ]
    ];

    $apiKey = ""; // Free key from HuggingFace

    $ch = curl_init($modelUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (!isset($result[0])) {
        return 0; // Fail safe
    }

    // Convert similarity into 0–100%
    return round($result[0] * 100);
}
