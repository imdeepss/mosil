<?php
$ui_files = glob("assets/images/ui/*.{jpg,jpeg,png}", GLOB_BRACE);
$brand_files = glob("assets/images/brand/*.{jpg,jpeg,png}", GLOB_BRACE);
$all_files = array_merge($ui_files, $brand_files);

foreach ($all_files as $file) {
    $info = pathinfo($file);
    $webp_file = $info["dirname"] . "/" . $info["filename"] . ".webp";
    
    if (file_exists($webp_file)) {
        echo "Already exists: $webp_file\n";
        continue;
    }
    
    $ext = strtolower($info["extension"]);
    if ($ext === "png") {
        $img = imagecreatefrompng($file);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
    } else {
        $img = imagecreatefromjpeg($file);
    }
    
    if ($img) {
        imagewebp($img, $webp_file, 80);
        imagedestroy($img);
        echo "Converted: $file -> $webp_file\n";
    } else {
        echo "Failed: $file\n";
    }
}
?>
