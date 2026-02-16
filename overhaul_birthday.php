<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

// Find the start of the birthday section block (any of our previous markers)
$blockStart = strpos($content, '/* Birthday Section Refactor');
if ($blockStart === false) {
    $blockStart = strpos($content, '/* Birthday Section Universal');
}
if ($blockStart === false) {
    $blockStart = strpos($content, '/* Birthday Section Final');
}

if ($blockStart !== false) {
    $baseContent = substr($content, 0, $blockStart);
    
    $comprehensiveStyles = "
/* Birthday Section - Comprehensive Responsiveness (Source of Truth) */
.birthday-section {
    background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    border-bottom: 2px solid rgba(40, 167, 69, 0.1);
    position: relative;
    overflow: hidden;
    padding: 60px 0;
}

.birthday-card-wrapper {
    max-width: 1200px; /* Desktop Base */
    width: 95%;
    background-color: #ffffff;
    background-image: radial-gradient(#FFD700 12%, transparent 13%),
                      radial-gradient(#FF69B4 12%, transparent 13%),
                      radial-gradient(#00CED1 12%, transparent 13%),
                      radial-gradient(#32CD32 12%, transparent 13%);
    background-size: 50px 50px;
    background-position: 0 0, 25px 25px, 12px 37px, 37px 12px;
    border-radius: 20px;
    border: 3px solid #28a745;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    position: relative;
    padding: 40px; /* Desktop Padding Requirement */
    margin: 20px auto;
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
    border-radius: 17px;
}

/* Base Flex Structure for Desktop/Laptop */
.birthday-flex-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 5;
    gap: 30px;
}

.birthday-photo-column {
    flex: 0 0 40%; /* 40% Image Width Requirement */
    display: flex;
    justify-content: center;
}

.birthday-content-column {
    flex: 0 0 60%; /* 60% Content Width Requirement */
}

/* Photo Frame */
.birthday-photo-frame {
    width: 100%;
    max-width: 350px;
    aspect-ratio: 4/5;
    position: relative;
    padding: 10px;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    border: 5px solid #d4edda;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: visible; /* Prevent badge clipping */
}

.birthday-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 10%;
    border-radius: 12px;
}

.birthday-date-badge {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
    padding: 8px 25px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.1rem;
    box-shadow: 0 5px 15px rgba(245, 124, 0, 0.3);
    white-space: nowrap;
    border: 3px solid #fff;
    z-index: 10;
}

/* Message Box */
.birthday-message-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 35px;
    height: auto;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    position: relative;
    border: 1px solid rgba(0,0,0,0.03);
}

.birthday-name-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    color: #1a237e;
    font-size: 2.2rem; /* Desktop size */
    margin-bottom: 15px;
}

.birthday-text {
    line-height: 1.7;
    font-size: 1.05rem;
    color: #444;
}

/* Nav Buttons */
.birthday-nav-btn {
    width: 45px;
    height: 45px;
    z-index: 50;
}

/* Responsive Overrides */

/* Laptop (992px–1199px) */
@media (max-width: 1199px) {
    .birthday-card-wrapper {
        padding: 30px; /* Reduced Padding Requirement */
    }
    .birthday-name-title {
        font-size: 1.8rem; /* Scaled down Requirement */
    }
}

/* Tablet (768px–991px) */
@media (max-width: 991px) {
    .birthday-section {
        padding: 40px 0;
    }
    .birthday-flex-container {
        flex-direction: column; /* Stacked Requirement */
        text-align: center; /* Center aligned Requirement */
        gap: 40px;
    }
    .birthday-photo-column, .birthday-content-column {
        flex: 0 0 100%;
        width: 100%;
    }
    .birthday-card-wrapper {
        margin: 10px auto;
        padding: 25px; /* Reduced margins Requirement */
    }
    .birthday-message-box {
        padding: 25px;
    }
    .birthday-message-box .d-flex {
        justify-content: center !important;
    }
}

/* Mobile (320px–767px) */
@media (max-width: 767px) {
    .birthday-section {
        padding: 20px 0 !important;
    }
    .birthday-card-wrapper {
        border-radius: 0; /* Modern Mobile Clean Look */
        width: 100%;
        padding: 40px 15px 60px; /* Optimized Mobile Spacing */
        margin: 0;
        border-left: none;
        border-right: none;
    }
    .birthday-photo-frame {
        max-width: 250px;
        height: 280px; /* Reduced image height Requirement */
        aspect-ratio: auto; /* Fixed for custom height */
        margin: 0 auto;
    }
    .birthday-name-title {
        font-size: clamp(22px, 5vw, 26px); /* 22px-26px Requirement */
    }
    .birthday-text {
        font-size: clamp(14px, 4vw, 16px); /* 14px-16px Requirement */
    }
    .birthday-nav-btn {
        width: 35px; /* Smaller arrows Requirement */
        height: 35px;
    }
    .birthday-message-box {
        padding: 20px 15px;
    }
    
    /* Center Date Badge strictly */
    .birthday-date-badge {
        font-size: 0.95rem;
        padding: 6px 20px;
    }
}

/* Extreme Small Screens Fix */
@media (max-width: 360px) {
    .birthday-card-wrapper {
        padding: 30px 10px 50px;
    }
    .birthday-photo-frame {
        max-width: 200px;
        height: 240px;
    }
}
";
    file_put_contents($filePath, $baseContent . $comprehensiveStyles);
    echo "Comprehensive Responsiveness Overhaul Applied.";
} else {
    echo "Marker not found.";
}
