<?php
// Regenerate with: php tools/generate-share-card.php
// Only needed if the default card changes; the team can also upload their own
// under Settings, which takes precedence.
// Default social share card. Brand faces (Josefin Sans / Inter) are not on this
// machine, so this uses a neutral geometric sans; replace via Site settings.
$W = 1200; $H = 630;
$im = imagecreatetruecolor($W, $H);
$black = imagecolorallocate($im, 10, 10, 10);
$white = imagecolorallocate($im, 255, 255, 255);
$cyan  = imagecolorallocate($im, 53, 193, 241);
$muted = imagecolorallocate($im, 139, 150, 160);
imagefilledrectangle($im, 0, 0, $W, $H, $black);

// Radial glow bleeding off the top-right corner, echoing the site's hero.
// Computed per pixel: stacking translucent ellipses in GD accumulates far too
// fast and turns into a solid disc.
$gx = 1180; $gy = -60; $radius = 620;
for ($y = 0; $y < $H; $y++) {
    for ($x = 0; $x < $W; $x++) {
        $d = sqrt(($x - $gx) ** 2 + ($y - $gy) ** 2);
        if ($d >= $radius) {
            continue;
        }
        // Smooth quadratic falloff, peaking well below full strength.
        $t = (1 - $d / $radius) ** 2 * 0.42;
        $r = (int) round(10 + (53 - 10) * $t);
        $g = (int) round(10 + (193 - 10) * $t);
        $b = (int) round(10 + (241 - 10) * $t);
        imagesetpixel($im, $x, $y, ($r << 16) | ($g << 8) | $b);
    }
}

$font = '/mnt/skills/examples/canvas-design/canvas-fonts/InstrumentSans-Bold.ttf';
$reg  = '/mnt/skills/examples/canvas-design/canvas-fonts/InstrumentSans-Regular.ttf';

imagettftext($im, 26, 0, 90, 130, $cyan, $reg, 'JONOADS.COM');
imagettftext($im, 66, 0, 90, 260, $white, $font, 'Performance advertising,');
imagettftext($im, 66, 0, 90, 350, $white, $font, 'engineered to win.');
imagettftext($im, 28, 0, 90, 440, $muted, $reg, '$225M in media managed  ·  $750M+ client revenue');

// Accent rule, the cyan logo dot scaled up.
imagefilledrectangle($im, 90, 500, 190, 506, $cyan);

imagepng($im, 'public/share-card.png', 9);
imagedestroy($im);
printf("wrote public/share-card.png (%s bytes)\n", number_format(filesize('public/share-card.png')));
