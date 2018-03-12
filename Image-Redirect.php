<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */
include("setInfo.php");

function Redirect($url, $permanent = false){
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
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
Redirect($imageUrl);

foreach (array_keys($GLOBALS) as $k) unset($$k);
unset($k);

