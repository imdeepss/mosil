<?php
$html = file_get_contents('live_newsroom.html');
preg_match_all('/class="([^"]+)"/', $html, $matches);
$classes = [];
foreach ($matches[1] as $cls) {
    foreach (explode(' ', $cls) as $c) {
        $c = trim($c);
        if ($c) $classes[$c] = 1;
    }
}
ksort($classes);
file_put_contents('newsroom_classes.txt', implode("\n", array_keys($classes)));
echo "Done";
