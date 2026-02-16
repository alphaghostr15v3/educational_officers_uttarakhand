<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$styles = "
/* Birthday Text Box Cropping Fix - Mobile */
@media (max-width: 768px) {
    .birthday-section {
        overflow: visible !important;
    }
    
    .birthday-card-wrapper {
        overflow: visible !important;
    }

    .carousel-inner, .carousel-item {
        overflow: visible !important;
        height: auto !important;
    }

    .birthday-message-box {
        height: auto !important;
        min-height: min-content !important;
        overflow: visible !important;
        margin-bottom: 20px !important;
    }
}
";

if (file_put_contents($filePath, $styles, FILE_APPEND)) {
    echo "Text box fix applied successfully.\n";
} else {
    echo "Failed to apply text box fix.\n";
}
