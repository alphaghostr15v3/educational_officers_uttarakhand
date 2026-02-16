<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

// Find the last legitimate brace '}' in the first roughly 16900 bytes
// (The file was about 16895 bytes before the corruption).
$limit = 16950; // A bit more than the expected size
$lastBracePos = -1;

for ($i = 0; $i < strlen($content) && $i < $limit; $i++) {
    if ($content[$i] === '}') {
        $lastBracePos = $i;
    }
}

if ($lastBracePos !== -1) {
    $validContent = substr($content, 0, $lastBracePos + 1);
    file_put_contents($filePath, $validContent . "\n");
    echo "Corrected at position $lastBracePos";
} else {
    echo "No brace found within limit.";
}
