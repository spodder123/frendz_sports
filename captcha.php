<?php
session_start();


$captcha = substr(md5(mt_rand()), 0, 6);


$_SESSION['captcha'] = $captcha;


$image = imagecreate(100, 50);


$bg_color = imagecolorallocate($image, 255, 255, 255);


$text_color = imagecolorallocate($image, 0, 0, 0);


imagestring($image, 5, 25, 18, $captcha, $text_color);


header('Content-type: image/png');
imagepng($image);

imagedestroy($image);
?>
