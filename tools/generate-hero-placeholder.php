<?php

/**
 * Regenerate with: php tools/generate-hero-placeholder.php
 *
 * A stand-in for the hero photo so the layout can be reviewed before the real
 * one arrives. Deliberately an illustration rather than anything resembling a
 * photograph — it is not a picture of Miami and should not be mistaken for
 * the finished asset. Replace it under Settings → Brand → Homepage hero image.
 */

$W = 1920;
$H = 1080;
$im = imagecreatetruecolor($W, $H);
imagealphablending($im, true);

$sky = static fn (int $y): array => (function () use ($y, $H) {
    // Night sky: deep blue at the top easing into a warmer horizon.
    $t = $y / $H;
    return [
        (int) (8 + 26 * $t ** 2),
        (int) (14 + 34 * $t ** 2),
        (int) (26 + 48 * $t ** 2),
    ];
})();

for ($y = 0; $y < $H; $y++) {
    [$r, $g, $b] = $sky($y);
    $c = imagecolorallocate($im, $r, $g, $b);
    imageline($im, 0, $y, $W, $y, $c);
}

// Cyan glow low on the right, echoing the site's accent.
$gx = 1450;
$gy = 760;
$radius = 760;
for ($y = max(0, $gy - $radius); $y < min($H, $gy + $radius); $y++) {
    for ($x = max(0, $gx - $radius); $x < min($W, $gx + $radius); $x++) {
        $d = sqrt(($x - $gx) ** 2 + ($y - $gy) ** 2);
        if ($d > $radius) {
            continue;
        }
        $fall = (1 - $d / $radius) ** 2 * 0.30;
        $rgb = imagecolorat($im, $x, $y);
        $r = (int) min(255, (($rgb >> 16) & 0xFF) + 53 * $fall);
        $g = (int) min(255, (($rgb >> 8) & 0xFF) + 193 * $fall);
        $b = (int) min(255, ($rgb & 0xFF) + 241 * $fall);
        imagesetpixel($im, $x, $y, imagecolorallocate($im, $r, $g, $b));
    }
}

/**
 * Towers, back to front: the further back a band sits, the lighter and hazier
 * it is, which is what reads as depth.
 */
$bands = [
    ['base' => 0.78, 'min' => 90,  'max' => 260, 'width' => [70, 150], 'shade' => 0.34, 'lit' => 0.05],
    ['base' => 0.86, 'min' => 140, 'max' => 400, 'width' => [60, 130], 'shade' => 0.20, 'lit' => 0.10],
    ['base' => 1.00, 'min' => 200, 'max' => 560, 'width' => [80, 170], 'shade' => 0.08, 'lit' => 0.16],
];

mt_srand(20260922); // Stable output, so regenerating does not churn the file.

foreach ($bands as $band) {
    $groundY = (int) ($H * $band['base']);
    $x = -60;

    while ($x < $W) {
        $w = mt_rand($band['width'][0], $band['width'][1]);
        $h = mt_rand($band['min'], $band['max']);
        $topY = $groundY - $h;

        $shade = $band['shade'];
        $colour = imagecolorallocate(
            $im,
            (int) (10 + 26 * $shade),
            (int) (14 + 30 * $shade),
            (int) (20 + 38 * $shade),
        );
        imagefilledrectangle($im, $x, $topY, $x + $w, $H, $colour);

        // Lit windows, sparse and irregular.
        $lit = imagecolorallocate($im, 120, 200, 230);
        for ($wy = $topY + 16; $wy < $groundY - 10; $wy += 22) {
            for ($wx = $x + 12; $wx < $x + $w - 12; $wx += 18) {
                if (mt_rand(0, 100) / 100 > $band['lit']) {
                    continue;
                }
                imagefilledrectangle($im, $wx, $wy, $wx + 5, $wy + 9, $lit);
            }
        }

        $x += $w + mt_rand(6, 26);
    }
}

// A clear label, so nobody ships this by accident.
$font = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
if (is_file($font)) {
    $label = imagecolorallocatealpha($im, 255, 255, 255, 96);
    imagettftext($im, 22, 0, 60, $H - 60, $label, $font, 'PLACEHOLDER — replace under Settings → Brand');
}

$out = __DIR__ . '/../public/placeholders/hero-placeholder.jpg';
@mkdir(dirname($out), 0755, true);
imagejpeg($im, $out, 86);
imagedestroy($im);

echo "wrote {$out} (" . number_format(filesize($out) / 1024, 1) . " KB)\n";
