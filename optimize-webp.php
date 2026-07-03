<?php
// optimize-webp.php - Run this once on the live server to optimize images!

$dirs = ['assets/images', 'assets/uploads'];

function createWebp($source, $dest, $quality = 80) {
    $info = getimagesize($source);
    if ($info === false) return false;
    
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
    } else {
        return false;
    }
    
    if ($image) {
        $result = imagewebp($image, $dest, $quality);
        imagedestroy($image);
        return $result;
    }
    return false;
}

echo "<h3>Starting WebP Optimization</h3>";
$count = 0;
foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                $source = $file->getPathname();
                $dest = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $source);
                if (!file_exists($dest)) {
                    if (createWebp($source, $dest)) {
                        echo "Created WebP for: $source <br>\n";
                        $count++;
                    } else {
                        echo "Failed to create WebP for: $source <br>\n";
                    }
                }
            }
        }
    }
}
echo "<br><strong>Optimization complete. Generated $count WebP images.</strong><br>";

// Now append .htaccess rules
$htaccessFile = '.htaccess';
if (file_exists($htaccessFile)) {
    $content = file_get_contents($htaccessFile);
    if (strpos($content, '%1.webp -f') === false) {
        $rules = <<<EOT

# --- WEBP OPTIMIZATION RULES ---
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{REQUEST_FILENAME} (.*)\.(jpe?g|png)$
  RewriteCond %1.webp -f
  RewriteRule ^(.*)\.(jpe?g|png)$ $1.webp [T=image/webp,L]
</IfModule>
<IfModule mod_headers.c>
  <FilesMatch "\.(webp)$">
    Header append Vary Accept
  </FilesMatch>
</IfModule>
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
</IfModule>
# --- END WEBP OPTIMIZATION RULES ---

EOT;
        file_put_contents($htaccessFile, $rules, FILE_APPEND);
        echo "<br><strong>Successfully added WebP rewrite rules to .htaccess!</strong><br>";
    } else {
        echo "<br>.htaccess already contains WebP rewrite rules.<br>";
    }
} else {
    echo "<br>No .htaccess found. Please ensure Apache allows rewrites.<br>";
}

echo "<br><strong style='color:red;'>Important: Please delete this optimize-webp.php script from the server now for security.</strong>";
?>
