<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ollama AI Configuration
 * Local Ollama endpoint settings for CodeIgniter 3
 */

$config['ollama_host'] = getenv('OLLAMA_HOST') ?: 'http://127.0.0.1:11434';
$ollama_hosts = getenv('OLLAMA_HOSTS');
if ($ollama_hosts !== false && trim((string)$ollama_hosts) !== '') {
	$config['ollama_hosts'] = array_values(array_filter(array_map('trim', preg_split('/\s*,\s*/', (string)$ollama_hosts))));
} else {
	$config['ollama_hosts'] = [$config['ollama_host']];
}
$config['ollama_model'] = getenv('OLLAMA_MODEL') ?: 'gemma4:e4b';
$config['ollama_timeout'] = (int)(getenv('OLLAMA_TIMEOUT') ?: 30);
$config['ollama_temperature'] = (float)(getenv('OLLAMA_TEMPERATURE') ?: 0.3);
$config['ollama_enabled'] = !empty($config['ollama_host']) && !empty($config['ollama_model']);