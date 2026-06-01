<?php
define('BASEPATH', 'd:\\xamp1\\htdocs\\Aconnect_ci3\\application\\');
define('APPPATH', BASEPATH);
require_once('d:\\xamp1\\htdocs\\Aconnect_ci3\\index.php');

$CI = get_instance();
$result = $CI->db->where('alumni_id', 50)->get('ai_match_cache')->result();

echo "Found " . count($result) . " cached results:\n";
foreach ($result as $row) {
    echo "Job {->job_id}: {->match_percentage}%\n";
}
?>
