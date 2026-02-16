<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$lines = file($filePath);
if ($lines === false) {
    die("Could not read file.");
}

// We want to keep up to line 838 (index 837)
// and handle line 839 (index 838) if it has the closing brace
$goodLines = array_slice($lines, 0, 839);

// Check if the last line is corrupted
$lastLine = $goodLines[count($goodLines) - 1];
if (strpos($lastLine, '@ m e d i a') !== false) {
    // Truncate to 838 lines
    $goodLines = array_slice($lines, 0, 838);
    // Ensure it ends with a closing brace
    $lastGoodLine = trim($goodLines[count($goodLines) - 1]);
    if ($lastGoodLine !== '}') {
        $goodLines[] = "\n}\n";
    }
}

if (file_put_contents($filePath, implode("", $goodLines))) {
    echo "File cleaned up successfully.\n";
} else {
    echo "Failed to write to file.\n";
}
