<?php
$files = [
    'assets/images/banners/home-banner-poster',
    'assets/images/banners/mb-home-banner-poster'
];
foreach($files as $f) {
    $png = $f . '.png';
    $webp = $f . '.webp';
    if(file_exists($png)) {
        $img = imagecreatefrompng($png);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagewebp($img, $webp, 80);
        imagedestroy($img);
        echo "Converted $webp\n";
    }
}
