<?php
$path = __DIR__ . '/views/counsellor/listSessions.php';
exec("php -l " . escapeshellarg($path) . " 2>&1", $out, $rc);
echo "RC={$rc}\n";
foreach ($out as $line) echo $line."\n";
