<?php

// definitions
$format["digisign"] = array(
	"bg" => "digibg.png", "x" => 1280, "y" => 720, "isaidoffsetx" => 60, "isaidoffsety" => 300,
	"unididoffsetx" => 660, "unididoffsety" => 300,
	"wordlimit" => 50, "logooffsetx" => 1000, "logooffsety" => 450,
	"output" => "png"
);

$format["screensaver"] = array(
	"bg" => "screensaver.png", "x" => 800, "y" => 600, "isaidoffsetx" => 30, "isaidoffsety" => 250,
	"unididoffsetx" => 410, "unididoffsety" => 250,
	"wordlimit" => 30, "logooffsetx" => 575, "logooffsety" => 350,
	"output" => "jpg"
);

$current = $_POST["size"];

$image = new Imagick();

$image->addImage(new Imagick($format[$current]["bg"])); 

$draw = new ImagickDraw();
$draw->setFillColor($_POST["selected-colour"]);
$draw->rectangle($format[$current]["x"], 0, 0, $format[$current]["y"]);

$image->drawImage($draw);

$draw = new ImagickDraw();

$image->compositeImage(new Imagick($format[$current]["bg"]), imagick::COMPOSITE_DEFAULT, 0, 0);


// I SAID
$draw->setFontSize(25);
$draw->setFillColor('black');
$image->annotateImage($draw,
	$format[$current]["isaidoffsetx"], 
	$format[$current]["isaidoffsety"], 
	0, 
	wordwrap($_POST["isaid"], 
		$format[$current]["wordlimit"], 
		"\n",
		 true
	)
);


// THEY DID
$draw->setFontSize(25);
$draw->setFillColor('black');
$image->annotateImage($draw, 
	$format[$current]["unididoffsetx"], 
	$format[$current]["unididoffsety"], 
	0, 
	wordwrap($_POST["unidid"], 
		$format[$current]["wordlimit"], 
		"\n", 
		true
	)
);


// add a logo
$logooverlay = new Imagick($_POST["selected-image"]);
$logooverlay->resizeImage(200,200, imagick::FILTER_LANCZOS, 1);



$image->compositeImage($logooverlay, imagick::COMPOSITE_DEFAULT, $format[$current]["logooffsetx"], $format[$current]["logooffsety"]);


header('Content-type: image/' . $format[$current]["output"]);

echo $image;