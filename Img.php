<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */

include("setInfo.php");
$setInfo = new setInfo();
$setDictionary = $setInfo->setDictionaryDC;
$set = $_GET['set'];
$cardNumber = $_GET['cardnum'];
$res = $_GET["res"];
if(!$set){
    echo "Please specify a set. example: Img.php?set=avx&cardnum=12";
}
if(!$cardNumber){
    echo "Please specify a card number. example: Img.php?set=avx&cardnum=12";
}
if(!$res)
{
    $res = "m";
}
$resolutionString = "medium";
switch(strtolower($res)){
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
if($set && $cardNumber){
    $set = strtolower($set);
    if (array_key_exists($set,$setDictionary)) {
        $setName = $setDictionary[$set];

        $imageUrl = "http://www.dicecoalition.com/cardservice/Cards/" . $setName . "/" . $cardNumber .$resolutionString.".jpg";

        echo '<img src="' . $imageUrl . '" alt="'.$setName.$cardNumber.'">';
    }
    else{
        echo "Invalid set name: ".$set.". Please check tb.dicecoalition.com for proper set abbreviations.";
    }
}
