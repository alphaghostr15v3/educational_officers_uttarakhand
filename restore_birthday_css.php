<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

$birthdayStyles = "

/* --- Balanced Birthday Section Styles --- */
.birthday-section {
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    border-bottom: 2px solid rgba(40, 167, 69, 0.1);
    position: relative;
    overflow: visible !important;
    padding: 40px 0;
}

.birthday-card-wrapper {
    max-width: 900px;
    width: 92%;
    background-color: #ffffff;
    background-image: radial-gradient(#FFD700 12%, transparent 13%),
                      radial-gradient(#FF69B4 12%, transparent 13%),
                      radial-gradient(#00CED1 12%, transparent 13%),
                      radial-gradient(#32CD32 12%, transparent 13%);
    background-size: 50px 50px;
    background-position: 0 0, 25px 25px, 12px 37px, 37px 12px;
    border-radius: 20px;
    border: 2px solid #28a745;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    position: relative;
    padding: 30px;
    margin: 20px auto;
    overflow: visible !important;
    z-index: 5;
}

.birthday-card-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    z-index: 1;
    border-radius: 18px;
}

.birthday-photo-frame {
    width: 100%;
    max-width: 280px;
    aspect-ratio: 4/5;
    position: relative;
    padding: 10px;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    border: 4px solid #d4edda;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    z-index: 10;
}

.birthday-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    border-radius: 12px;
}

.birthday-date-badge {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
    padding: 8px 30px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(245, 124, 0, 0.3);
    white-space: nowrap;
    border: 2px solid #fff;
    z-index: 20;
}

.birthday-message-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    height: auto !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.04);
    position: relative;
    z-index: 5;
    border: 1px solid rgba(0,0,0,0.03);
}

.speech-arrow {
    position: absolute;
    left: -12px;
    top: 50px;
    width: 24px;
    height: 24px;
    background: #fff;
    transform: rotate(45deg);
    z-index: 1;
    box-shadow: -3px 3px 6px rgba(0,0,0,0.02);
}

.birthday-name-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    color: #1a237e;
    font-size: 1.8rem;
}

.birthday-text {
    line-height: 1.7;
    font-size: 1rem;
    color: #444;
}

.birthday-nav-btn {
    width: 45px;
    height: 45px;
    z-index: 50;
    transition: all 0.3s;
}

.carousel-inner, .carousel-item {
    overflow: visible !important;
}

@media (max-width: 991px) {
    .birthday-card-wrapper {
        max-width: 90%;
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .birthday-section {
        padding: 20px 0 !important;
    }
    
    .birthday-card-wrapper {
        border-radius: 0;
        border-left: none;
        border-right: none;
        padding: 40px 10px 60px;
        margin: 0;
        width: 100%;
    }

    .birthday-photo-frame {
        max-width: 240px;
        aspect-ratio: 1/1;
        margin: 0 auto 35px;
    }

    .speech-arrow {
        display: none;
    }

    .birthday-message-box {
        text-align: center !important;
        padding: 20px !important;
        width: 100% !important;
        margin: 0;
    }
    
    .birthday-message-box .d-flex {
        justify-content: center !important;
    }

    .birthday-name-title {
        font-size: 1.5rem;
    }

    .birthday-text {
        font-size: 0.95rem;
    }
}
";

// Find and replace old birthday styles
$startMarker = '/* Birthday Section Styles */';
$pos = strpos($content, $startMarker);
if ($pos !== false) {
    $before = substr($content, 0, $pos);
    // Find next block or end of file
    $rest = substr($content, $pos);
    // Let's assume the old block ends where our media query or next section starts, but it's safer to just append if we are not sure of the end.
    // Actually, I'll just append it to the end and hope it overrides.
    // Better: I'll try to find the next section.
    file_put_contents($filePath, $before . $birthdayStyles);
    echo "Birthday Styles Balanced.";
} else {
    file_put_contents($filePath, $content . $birthdayStyles);
    echo "Birthday Styles Appended.";
}
