<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/16/2018
 * Time: 5:40 PM
 */
include("setInfo.php");
include("Card.php");

$set = strtolower($_GET['set']);
$bacSet = strtolower($_GET['bac']);
$res = strtolower($_GET['res']);
$includeStarter = $_GET['starter'];
if(!$bacSet)
    $bacSet = $set;
if(!$res)
    $res = "s";
if(!$includeStarter)
    $includeStarter = "false";

$setInfo = new setInfo();

if(!$set){
    echo "Please specify a set. example: draftpacks.php?set=avx";
}
//get BACs
$cardBacPool = array();
if(array_key_exists($bacSet, $setInfo->setBACs)) {
    $cardBacRange = explode("-", $setInfo->setBACs[$bacSet]);
    $cardNumRange = range(intval($cardBacRange[0]), intval($cardBacRange[1]));
    foreach($cardNumRange as &$value)
    {
        $card = new Card($bacSet, $value, "bac");
        array_push($cardBacPool, $card);
    }

    $cardBacPool = array_merge($cardBacPool, $cardBacPool);
}

//get SRs
$cardSRPool = array();
$cardSRRange = explode("-", $setInfo->setSuperRares[$set]);
$cardNumRange= range(intval($cardSRRange[0]), intval($cardSRRange[1]));
foreach($cardNumRange as &$value)
{
    array_push($cardSRPool, new Card($set, $value, "sr"));
}

//get Rares
$cardRarePool = array();
$cardRareRange = explode("-", $setInfo->setRares[$set]);
$cardNumRange= range(intval($cardRareRange[0]), intval($cardRareRange[1]));
foreach($cardNumRange as &$value)
{
    array_push($cardRarePool, new Card($set, $value, "r"));
}

//get UCs
$cardUCPool = array();
$cardUCRange = explode("-", $setInfo->setUncommons[$set]);
$cardNumRange= range(intval($cardUCRange[0]), intval($cardUCRange[1]));
foreach($cardNumRange as &$value)
{
    array_push($cardUCPool, new Card($set, $value, "uc"));
}

//get Commons
$cardCPool = array();
$commons = $setInfo->setCommons[$set];
if(strpos($commons, ',') !== false)
{
    $cardCArray = explode(",", $commons);
    if($includeStarter == "true") {
        $cards1 = explode("-", $cardCArray[0]);
        $cards2 = explode("-", $cardCArray[1]);
        $cardNumRange = range(intval($cards1[0]), intval($cards1[1]));
        $cardNumRange = array_merge($cardNumRange, range(intval($cards2[0]), intval($cards2[1])));
    }
    else{
        $cards = explode("-", $cardCArray[1]);
        $cardNumRange = range(intval($cards[0]), intval($cards[1]));
    }
}
else {
    $cardCRange = explode("-", $setInfo->setCommons[$set]);
    $cardNumRange = range(intval($cardCRange[0]), intval($cardCRange[1]));
}
foreach($cardNumRange as &$value) {
    array_push($cardCPool, new Card($set, $value, "c"));
}
//double the number of possible commons
$cardCPool = array_merge($cardCPool, $cardCPool);

shuffle($cardBacPool);
shuffle($cardSRPool);
shuffle($cardRarePool);
shuffle($cardUCPool);
shuffle($cardCPool);

for($p = 0; $p < 8; $p++) {
    $cards = array();
    $ucCount = 4;
    $cCount = 6;

    $size = count($cardBacPool);
    if($size>2) {
        $cardNums = array();
        for ($i = 0; $i < 2; $i++) {
            $index = rand(0, $size - 1);
            $card = $cardBacPool[$index];
            while (in_array($card->Number, $cardNums)){
                $index = rand(0, $size - 1);
                $card = $cardBacPool[$index];
            }
            array_push($cardNums, $card->Number);
            array_push($cards, $card);
            array_splice($cardBacPool, $index, 1);
            $size = $size-1;
        }
        unset($cardNums);
    }
    if($p <2) {
        $size = count($cardSRPool);
        $index = rand(0, $size - 1);
        array_push($cards, $cardSRPool[$index]);
        array_splice($cardSRPool, $index, 1);
        $ucCount = 3;
        $cCount = 7;
    }
    else
    {
        $size = count($cardRarePool);
        $index = rand(0, $size - 1);
        array_push($cards, $cardRarePool[$index]);
        array_splice($cardRarePool, $index, 1);
    }
    $size = count($cardRarePool);
    $index = rand(0, $size - 1);
    array_push($cards, $cardRarePool[$index]);
    array_splice($cardRarePool, $index, 1);

    $size = count($cardUCPool);
    for ($i = 0; $i < $ucCount; $i++) {
        $index = rand(0, $size - 1);
        array_push($cards, $cardUCPool[$index]);
        array_splice($cardUCPool, $index, 1);
        $size = $size-1;
    }

    $size = count($cardCPool);
    $cardNums = array();
    for ($i = 0; $i < $cCount; $i++) {
        $index = rand(0, $size - 1);
        $card = $cardCPool[$index];
        while (in_array($card->Number, $cardNums)){
            $index = rand(0, $size - 1);
            $card = $cardCPool[$index];
        }
        array_push($cardNums, $card->Number);
        array_push($cards, $card);
        array_splice($cardCPool, $index, 1);
        $size = $size-1;
    }

    $packNum = $p+1;
    echo "<h1>Pack ".$packNum."</h1><br>";
    for ($i = 0; $i < count($cards); $i++) {
        $card = $cards[$i];
        $url = "http://dicecoalition.com/cardservice/Img.php?set=" . $card->Set . "&cardnum=" . $card->Number . "&res=".$res;
        //$out = exec($url);
        $color = "black";
        if($card->Rarity == "sr") $color = "red";
        else if($card->Rarity == "r") $color = "yellow";
        else if($card->Rarity == "uc") $color = "green";
        else if($card->Rarity == "c") $color = "grey";
        $style = "style=\"border:3px solid ".$color.";\" ";
        $img = file_get_contents($url);
        $img = substr_replace($img, $style, 5, 0);
        echo $img; //readfile($url)."<br>";
    }
}
