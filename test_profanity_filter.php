<?php
// Simple profanity filter test
define('BASEPATH', __DIR__ . '/');

// Load CodeIgniter core
require_once 'system/core/Common.php';

// Test simple censoring function
function _get_simple_profanity_list() {
    return [
        'gago', 'tangina', 'putang', 'puta', 'bobo', 'tanga', 'patos', 'gata', 
        'iyak', 'kingina', 'punyeta', 'pakshet', 'pakshit', 'bastos', 'layunin',
        'hudas', 'taksil', 'judas', 'mga putang ina', 'putang-ina', 'tangina mo',
        'gago ka', 'bobo ka', 'tanga ka', 'bastos na', 'mabastos',
        'fuck', 'shit', 'ass', 'bitch', 'damn', 'crap', 'piss', 'hell',
        'bastard', 'slut', 'whore', 'dick', 'pussy', 'asshole', 'bloody',
        'bollocks', 'bugger', 'arse', 'twat', 'wanker', 'shag', 'sod',
        'cock', 'fucks', 'fucked', 'fucker', 'fucking',
        'shits', 'shitty', 'shitting',
        'damned', 'dammit', 'damnit'
    ];
}

function _simple_censor_profanities($text) {
    if (empty($text)) {
        return ['is_profane' => false, 'censored_text' => $text, 'detected_words' => []];
    }
    
    $profanities = _get_simple_profanity_list();
    $detected = [];
    $censored = $text;
    
    foreach ($profanities as $word) {
        $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
        if (preg_match($pattern, $censored)) {
            $detected[] = $word;
            $replacement = str_repeat('*', strlen($word));
            $censored = preg_replace($pattern, $replacement, $censored);
        }
    }
    
    return [
        'is_profane' => !empty($detected),
        'censored_text' => $censored,
        'detected_words' => $detected
    ];
}

// Test cases
$test_cases = [
    "This is GAGO",
    "TANGINA MO!",
    "What a bobo person",
    "Hello world, this is a normal post",
    "GAGO, bobo, and tanga",
];

echo "<h2>Profanity Filter Test Results</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Original</th><th>Censored</th><th>Flagged</th></tr>";

foreach ($test_cases as $test) {
    $result = _simple_censor_profanities($test);
    echo "<tr>";
    echo "<td>" . htmlspecialchars($test) . "</td>";
    echo "<td>" . htmlspecialchars($result['censored_text']) . "</td>";
    echo "<td>" . ($result['is_profane'] ? "YES" : "NO") . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
