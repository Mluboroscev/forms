<?php
session_start();

$string = '';

for ($i = 0; $i < 5; $i++) {
  $string .= chr(rand(97, 122));
}

$_SESSION['captcha'] = $string;

$image = imagecreatetruecolor(165, 50);
$font = "../fonts/PlAGuEdEaTH.ttf";
$color = imagecolorallocate($image, 113, 193, 217);
$white = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image,0,0,399,99,$white);
imagettftext ($image, 30, 0, 10, 40, $color, $font, $_SESSION['captcha']);

header("Content-type: image/png");
imagepng($image);
?>