<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


// definitions
//digisign
$bgd = array("blue" => "images/Blue1920x1080.png",
	    "corporate" => "images/Corporate1920x1080.png",
	    "yellow" => "images/Yellow1920x1080.png",
	    "orange" => "images/Orange1920x1080.png");

$format["digisign"] = array(
	"bg" => $bgd,
	"isaidoffsetx" => 800, "isaidoffsety" => 1650,
	"logooffsetx" => 800, "logooffsety" => 3100,
	"unididoffsetx" => 4600, "unididoffsety" => 1650,
	"fontSize" => 200,
	"logoSize" => 150,
	"wordlimit" => 30,
	"output" => "png"
);


//screensaver
$bgs = array("blue" => "images/Blue800x600.png",
	    "corporate" => "images/Corporate800x600.png",
	    "yellow" => "images/Yellow800x600.png",
	    "orange" => "images/Orange800x600.png");

$format["screensaver"] = array(
	"bg" => $bgs,
	"isaidoffsetx" => 130, "isaidoffsety" => 800,
	"logooffsetx" => 130, "logooffsety" => 1750,
	"unididoffsetx" => 1650, "unididoffsety" => 800,
	"wordlimit" => 35,
	"fontSize" => 85,
	"logoSize" => 60,
	"output" => "png"
);


//a3
$bga = array("blue" => "images/BlueA3.png",
	    "corporate" => "images/CorporateA3.png",
	    "yellow" => "images/YellowA3.png",
	    "orange" => "images/OrangeA3.png");

$format["a3"] = array(
	"bg" => $bga,
	"isaidoffsetx" => 280, "isaidoffsety" => 1250,
	"logooffsetx" => 280, "logooffsety" => 2000,
	"unididoffsetx" => 280, "unididoffsety" => 2600,
	"fontSize" => 140,
	"logoSize" => 100,
	"wordlimit" => 40,
	"output" => "png"
);



//Select background
$current = $_POST["size"];
$color = $_POST["selected-colour"];

$image = new Imagick();
$image->addImage(new Imagick($format[$current]["bg"][$color])); 

/* No longer needed
$draw = new ImagickDraw();
$draw->setFillColor($_POST["selected-colour"]);
$draw->rectangle($format[$current]["x"], 0, 0, $format[$current]["y"]);

$image->drawImage($draw);

$draw = new ImagickDraw();

$image->compositeImage(new Imagick($format[$current]["bg"]), imagick::COMPOSITE_DEFAULT, 0, 0);
*/

// I SAID
$draw = new ImagickDraw();
$draw->setFont('Ubuntu');
$draw->setFillColor('black');
$draw->setFontSize($format[$current]["fontSize"]);
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


// LOGO 
$draw = new ImagickDraw();
$draw->setFont('Ubuntu');
$draw->setFillColor('black');
$draw->setFontSize($format[$current]["logoSize"]);
$image->annotateImage($draw,
	$format[$current]["logooffsetx"], 
	$format[$current]["logooffsety"], 
	0, 
	wordwrap($_POST["survey-source"], 
		$format[$current]["wordlimit"], 
		"\n",
		 true
	)
);
// THEY DID
$draw->setFontSize($format[$current]["fontSize"]);
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


/* add a logo - no longer needed
$logooverlay = new Imagick($_POST["selected-image"]);
$logooverlay->resizeImage(200,200, imagick::FILTER_LANCZOS, 1);



$image->compositeImage($logooverlay, imagick::COMPOSITE_DEFAULT, $format[$current]["logooffsetx"], $format[$current]["logooffsety"]);

*/
header('Content-type: image/' . $format[$current]["output"]);

echo $image;
