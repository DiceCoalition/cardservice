<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */
include("setInfo.php");

function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}

$setInfo = new setInfo();
$setDictionary = $setInfo->setDictionaryDC;

$set = strtolower($_GET['set']);
$setName = $setDictionary[$set];
$cardNumber = $_GET['cardnum'];

$res = strtolower($_GET['res']);
if(!$res)
{
    $res = "m";
}
$resolutionString = "medium";
switch($res){
    case 'f':
        $resolutionString = "full";
        break;
    case 'l':
        $resolutionString = "large";
        break;
    case 'm':
        $resolutionString = "medium";
        break;
    case 's':
        $resolutionString = "small";
        break;
    case 't':
        $resolutionString = "thumb";
        break;
}

$imageUrl = "http://www.dicecoalition.com/cardservice/Cards/".$setName."/".$cardNumber.$resolutionString.".jpg";

$img = LoadJpeg($imageUrl);
//$img = file_get_contents($imageUrl);
if($img === false){
  echo "file load failed";	
} else{
header('Content-Type: image/jpeg');
imagejpeg($img);
imagedestroy($img);
}