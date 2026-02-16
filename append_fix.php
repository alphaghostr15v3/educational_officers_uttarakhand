<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$styles = "
/* Birthday Image Cropping Fix - Mobile */
@media (max-width: 576px) {
    .birthday-photo-frame {
        width: 160px !important;
        height: 180px !important;
        background: #fff !important;
        padding: 5px !important;
    }

    .birthday-img {
        object-fit: contain !important;
        background-color: #f8f9fa;
    }
}
";

if (file_put_contents($filePath, $styles, FILE_APPEND)) {
    echo "Styles appended successfully.\n";
} else {
    echo "Failed to append styles.\n";
}
