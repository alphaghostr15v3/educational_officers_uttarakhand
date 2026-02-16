<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

// Find the last legitimate brace before the corruption.
// Looking at the previous views, line 838 was a closing brace.
// Line 839 started with }@ m e d i a
// So we want to find where line 839 starts.
// Actually, let's just find the first occurrence of '@ m e d i a' and truncate there.
$pos = strpos($content, '@ m e d i a');
if ($pos !== false) {
    // Truncate just before the weird media query but KEEP the closing brace if it's there.
    // The brace before @ m e d i a is part of line 839.
    $validContent = substr($content, 0, $pos);
    // Ensure it ends with }
    $validContent = rtrim($validContent);
    if (substr($validContent, -1) !== '}') {
        $validContent .= "\n}\n";
    }
    file_put_contents($filePath, $validContent);
    echo "Corrected.";
} else {
    echo "Not found.";
}
