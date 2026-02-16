<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$styles = "
/* Birthday Image Cropping Final Fix */
@media (max-width: 576px) {
    .birthday-photo-frame {
        width: 170px !important;
        height: auto !important;
        min-height: 190px !important;
        background: #fff !important;
        padding: 5px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border: 4px solid #d4edda !important;
        margin-bottom: 30px !important;
    }

    .birthday-img {
        width: 100% !important;
        height: auto !important;
        max-height: 180px !important;
        object-fit: contain !important;
        background-color: #fff !important;
        border: none !important;
    }
}
";

if (file_put_contents($filePath, $styles, FILE_APPEND)) {
    echo "Styles applied successfully.\n";
} else {
    echo "Failed to apply styles.\n";
}
