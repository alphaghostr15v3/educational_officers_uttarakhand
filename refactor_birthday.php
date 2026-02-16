<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

// Find where the birthday section styles begin
$startPos = strpos($content, '/* Birthday Section Styles */');
if ($startPos === false) {
    // If not found, look for where the corruption or mess might have started
    $startPos = strpos($content, '.birthday-section {');
}

if ($startPos !== false) {
    $cleanContent = substr($content, 0, $startPos);
    
    $newStyles = "
/* Birthday Section Refactor - Modern & Responsive */
.birthday-section {
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    border-bottom: 1px solid #e0e0e0;
    overflow: visible !important;
}

.birthday-card-wrapper {
    max-width: 900px;
    background-color: #f8f9fa;
    background-image: radial-gradient(#FFD700 15%, transparent 16%),
                      radial-gradient(#FF69B4 15%, transparent 16%),
                      radial-gradient(#00CED1 15%, transparent 16%),
                      radial-gradient(#32CD32 15%, transparent 16%);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px, 15px 45px, 45px 15px;
    border-radius: 20px;
    border: 2px solid #28a745;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    position: relative;
    padding: 20px;
    width: 100%;
    overflow: visible !important;
}

.birthday-card-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.85);
    z-index: 1;
    border-radius: 18px;
}

.birthday-photo-frame {
    width: 100%;
    max-width: 260px;
    aspect-ratio: 4/5;
    position: relative;
    padding: 8px;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border: 4px solid #d4edda;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
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
    background: #ff9800;
    color: white;
    padding: 8px 25px;
    border-radius: 50px;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    white-space: nowrap;
    border: 2px solid #fff;
    z-index: 5;
}

.birthday-message-box {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    height: auto !important;
    min-height: min-content;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    position: relative;
    z-index: 2;
}

.speech-arrow {
    position: absolute;
    left: -12px;
    top: 40px;
    width: 24px;
    height: 24px;
    background: #fff;
    transform: rotate(45deg);
    z-index: 1;
    box-shadow: -2px 2px 5px rgba(0,0,0,0.02);
}

.birthday-name-title {
    font-family: 'Georgia', serif;
    font-weight: bold;
    color: #1a237e;
    font-size: 1.8rem;
}

.birthday-text {
    line-height: 1.6;
    font-size: 1rem;
    color: #555;
}

.birthday-nav-btn {
    width: 40px;
    height: 40px;
    opacity: 0.8;
    transition: all 0.3s;
    z-index: 10;
}

.birthday-nav-btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Transitions */
.carousel-inner, .carousel-item {
    overflow: visible !important;
}

@media (max-width: 991px) {
    .birthday-card-wrapper {
        max-width: 700px;
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
        padding: 30px 10px;
    }

    .birthday-photo-frame {
        max-width: 200px;
        margin: 0 auto 30px;
    }

    .speech-arrow {
        display: none;
    }

    .birthday-message-box {
        text-align: center;
        padding: 20px !important;
    }
    
    .birthday-message-box .d-flex {
        justify-content: center !important;
    }

    .birthday-name-title {
        font-size: 1.4rem;
    }

    .birthday-text {
        font-size: 0.95rem;
    }
}

@media (max-width: 576px) {
    .birthday-section {
        padding: 0 !important;
    }
    
    .birthday-card-wrapper {
        padding: 40px 15px;
    }
    
    .birthday-message-box {
        margin: 0;
    }
}
";
    file_put_contents($filePath, $cleanContent . $newStyles);
    echo "Refactored successfully.";
} else {
    echo "Marker not found.";
}
