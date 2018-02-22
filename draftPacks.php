<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/16/2018
 * Time: 5:40 PM
 */
include("setInfo.php");
include("Card.php");

$setInfo = new setInfo();

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

if(!$set){
    echo "Please specify a set. example: draftpacks.php?set=avx";
}
//get BACs
$cardBacPool = array();
if($bacSet === 'all'){
	foreach($setInfo->setBACs as $key=>$value)
	{
		$cardBacPool = array_merge($cardBacPool, getBacs($key, 2));
	}
}
else{
	$cardBacPool = array_merge($cardBacPool, getBacs($bacSet, 2));
}

//get SRs
$cardSRPool = array();
$cardSRPool = array_merge($cardSRPool, getSRs($set));

//get Rares
$cardRarePool = array();
$cardRarePool = array_merge($cardRarePool, getRares($set));

//get UCs
$cardUCPool = array();
$cardUCPool = array_merge($cardUCPool, getUncommons($set));

//get Commons
$cardCPool = array();
$cardCPool = array_merge($cardCPool, getCommons($set, $includeStarter, 2));

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
	
	$size = count($cardSRPool);
	if($size > 0){
		if($p <2) {
			
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
	}
	else {
		$ucCount = 0;
		$cCount = 12;
	}
    
    $size = count($cardCPool);
	if($size > 0)
	{
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
	else{
		echo "no commons found";
	}
}

function getBacs($set, $instances = 2){	
	global $setInfo;
    $cardBacPool = array();	
    if(array_key_exists($set, $setInfo->setBACs)) {
        $cardBacRange = explode("-", $setInfo->setBACs[$set]);
        $cardNumRange = range(intval($cardBacRange[0]), intval($cardBacRange[1]));
        foreach($cardNumRange as &$value)
        {			
            $card = new Card($set, $value, "bac");		
            array_push($cardBacPool, $card);
        }
        for($i =1; $i < $instances; $i++) {
            $cardBacPool = array_merge($cardBacPool, $cardBacPool);
        }
    }	
    return $cardBacPool;
}

function getSRs($set, $instances = 1){
	global $setInfo;
    $cardSRPool = array();	
    if(array_key_exists($set, $setInfo->setSuperRares)) {
        $cardSRRange = explode("-", $setInfo->setSuperRares[$set]);
        $cardNumRange= range(intval($cardSRRange[0]), intval($cardSRRange[1]));
        foreach($cardNumRange as &$value)
        {
            array_push($cardSRPool, new Card($set, $value, "sr"));
        }
        for($i =1; $i < $instances; $i++) {
            $cardSRPool = array_merge($cardSRPool, $cardSRPool);
        }
    }
    return $cardSRPool;
}

function getRares($set, $instances = 1){
	global $setInfo;
    $cardRarePool = array();
    if(array_key_exists($set, $setInfo->setRares)) {
        $cardRareRange = explode("-", $setInfo->setRares[$set]);
        $cardNumRange= range(intval($cardRareRange[0]), intval($cardRareRange[1]));
        foreach($cardNumRange as &$value)
        {
            array_push($cardRarePool, new Card($set, $value, "r"));
        }
        for($i =1; $i < $instances; $i++) {
            $cardRarePool = array_merge($cardRarePool, $cardRarePool);
        }
    }
    return $cardRarePool;
}

function getUncommons($set, $instances = 1){
	global $setInfo;
    $cardUCPool = array();
    if(array_key_exists($set, $setInfo->setUncommons)) {
        $cardUCRange = explode("-", $setInfo->setUncommons[$set]);
        $cardNumRange= range(intval($cardUCRange[0]), intval($cardUCRange[1]));
        foreach($cardNumRange as &$value)
        {
            array_push($cardUCPool, new Card($set, $value, "uc"));
        }
        for($i =1; $i < $instances; $i++) {
            $cardUCPool = array_merge($cardUCPool, $cardUCPool);
        }
    }
    return $cardUCPool;
}

function getCommons($set, $includeStarter = "false", $instances = 2){
	global $setInfo;
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
    for($i =1; $i < $instances; $i++) {
        $cardCPool = array_merge($cardCPool, $cardCPool);
    }

    return $cardCPool;
}

