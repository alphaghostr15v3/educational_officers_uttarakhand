<?php
$filePath = 'c:/xampp/htdocs/EducationalMinisterialOfficersUttarakhand/public/css/public.css';
$content = file_get_contents($filePath);
if ($content === false) die("Error reading");

$newsTickerStyles = "

/* --- News Ticker & Top Bar Enhancement --- */
.top-bar {
    background-color: var(--gov-blue);
    color: white;
    padding: 2px 0;
    font-size: 0.8rem;
    position: relative;
    z-index: 1060;
    border-bottom: 2px solid var(--uk-saffron);
}

.contact-info-top span {
    font-weight: 500;
    white-space: nowrap;
}

.news-ticker-integrated {
    height: 30px;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.ticker-wrapper {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.ticker-content {
    display: inline-block;
    white-space: nowrap;
    animation: ticker 30s linear infinite;
    padding-left: 20px;
}

.ticker-content:hover {
    animation-play-state: paused;
}

.ticker-item {
    display: inline-block;
    padding-right: 50px;
    font-weight: 500;
}

@keyframes ticker {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

@media (max-width: 991px) {
    .news-ticker-integrated {
        height: 25px;
    }
    .ticker-item {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .top-bar {
        font-size: 0.7rem;
    }
    .contact-info-top {
        flex-direction: column;
        align-items: center;
        gap: 2px;
    }
}
";

if (strpos($content, '/* --- News Ticker') === false) {
    file_put_contents($filePath, $content . $newsTickerStyles);
    echo "News Ticker Styles Re-injected.";
} else {
    echo "Styles already exist.";
}
