<?php

$image = new Imagick();
$image->newImage(1024, 860, new ImagickPixel('yellow'));
$image->setImageFormat('png');
$image->setBackgroundColor(new ImagickPixel('yellow'));

$draw = new ImagickDraw();
$draw->setFillColor('yellow');
$draw->setStrokeColor( new ImagickPixel('yellow') );
$draw->rectangle(1024, 0, 0, 680);

$image->drawImage( $draw );

$draw = new ImagickDraw();

$image->addImage(new Imagick("background.png"));

$draw->setFontSize(25);
$draw->setFillColor('black');
$image->annotateImage($draw, 30, 250, 0, $_POST["isaid"]);


$draw->setFontSize(25);
$draw->setFillColor('black');
$image->annotateImage($draw, 409, 250, 0, wordwrap($_POST["unidid"], 5));

header('Content-type: image/png');

echo $image;