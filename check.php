<?php
$files = glob("assets/uploads/main-category/*.{jpg,jpeg,png}", GLOB_BRACE);
foreach($files as $f) {
    $info = pathinfo($f);
    $webp = $info["dirname"] . "/" . $info["filename"] . ".webp";
    if (!file_exists($webp)) {
        $ext = strtolower($info["extension"]);
        if ($ext === "png") {
            $img = imagecreatefrompng($f);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
        } else {
            $img = imagecreatefromjpeg($f);
        }
        imagewebp($img, $webp, 80);
        imagedestroy($img);
        echo "Converted $webp\n";
    }
}
