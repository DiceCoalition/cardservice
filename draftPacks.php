<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/16/2018
 * Time: 5:40 PM
 */

include("setInfo.php");
include("Card.php");
include("cardInfo.php");

$setInfo = new setInfo();
$cardInfo = new cardInfo();

$set = strtolower($_GET['set']);
$bacSet = strtolower($_GET['bac']);
$res = strtolower($_GET['res']);
$includeStarter = $_GET['starter'];
$packCountString = $_GET['packs'];
$hidePacks = $_GET['hide'];
$cap = $_GET['cap'];


if(!$packCountString)
    $packCount = 8;
else
    $packCount = intval($packCountString);

if(!$bacSet)
    $bacSet = $set;
if(!$res)
    $res = "s";
if(!$includeStarter)
    $includeStarter = "false";
if(!$hidePacks)
    $hidePacks = "false";
if(!$cap)
    $cap = "0";


if(!$set){
    echo "Please specify a set. example: draftpacks.php?set=avx";
}
//get BACs
$cardBacPool = array();
$sets = getBacSets($bacSet);
foreach($sets as &$value){
    $cardBacPool = array_merge($cardBacPool, getBacs($value, 2));
}

//get SRs
$cardSRPool = array();
$sets = getSets($set);
foreach($sets as &$value){
    $cardSRPool = array_merge($cardSRPool, getSRs($value));
}

//get Rares
$cardRarePool = array();
$sets = getSets($set);
foreach($sets as &$value){
    $cardRarePool = array_merge($cardRarePool, getRares($value));
}

//get UCs
$cardUCPool = array();
$sets = getSets($set);
foreach($sets as &$value){
    $cardUCPool = array_merge($cardUCPool, getUncommons($value));
}


//get Commons
$cardCPool = array();
$sets = getSets($set);
foreach($sets as &$value){
    $cardCPool = array_merge($cardCPool, getCommons($value, $includeStarter, 2));
}

$cardCount = count($cardSRPool) + count($cardRarePool)+count($cardUCPool)+count($cardCPool);
while($cardCount < 192){
	foreach($sets as &$value){
		$cardCPool = array_merge($cardCPool, getCommons($value, $includeStarter, 1));
	}
	$cardCount = count($cardSRPool) + count($cardRarePool)+count($cardUCPool)+count($cardCPool);
}
shuffle($cardBacPool);
shuffle($cardSRPool);
shuffle($cardRarePool);
shuffle($cardUCPool);
shuffle($cardCPool);

$poolDict = array();

$ctDisplay = array();
for($p = 0; $p < 8; $p++) {
    $cards = array();
    $ucCount = 4;
    $cCount = 6;

    $size = count($cardBacPool);
    if ($size > 2) {
        $cardNums = array();
        for ($i = 0; $i < 2; $i++) {
            $index = rand(0, $size - 1);
            $card = $cardBacPool[$index];
            while (in_array($card->Number, $cardNums)) {
                $index = rand(0, $size - 1);
                $card = $cardBacPool[$index];
            }
            array_push($cardNums, $card->Number);
            array_push($cards, $card);
            array_splice($cardBacPool, $index, 1);
            $size = $size - 1;
        }
        unset($cardNums);
    }

    $size = count($cardSRPool);
    if ($size > 0) {
        if ($p < 2) {

            $index = rand(0, $size - 1);
			$card = $cardSRPool[$index];
			$cardInt = intval($card->Number)-1;
			$cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
			if (isset($poolDict[$cardName])) {
				$poolDict[$cardName] +=1 ;
			}
			else {						
				$poolDict[$cardName] = 1;
			}
            array_push($cards, $cardSRPool[$index]);
            array_splice($cardSRPool, $index, 1);
            $ucCount = 3;
            $cCount = 7;
        } else {
            $size = count($cardRarePool);
            $index = rand(0, $size - 1);
			$card = $cardRarePool[$index];
			$cardInt = intval($card->Number)-1;
			$cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
			if (isset($poolDict[$cardName])) {
				$poolDict[$cardName] +=1 ;
			}
			else {						
				$poolDict[$cardName] = 1;
			}
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
			$card = $cardUCPool[$index];
			$cardInt = intval($card->Number)-1;
			$cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
			if (isset($poolDict[$cardName])) {
				$poolDict[$cardName] +=1 ;
			}
			else {						
				$poolDict[$cardName] = 1;
			}
            array_push($cards, $cardUCPool[$index]);
            array_splice($cardUCPool, $index, 1);
            $size = $size - 1;
        }
    } else {
        $ucCount = 0;
        $cCount = 12;
    }

    $size = count($cardCPool);	
    if ($size > 0) {
        $cardNums = array();
        for ($i = 0; $i < $cCount; $i++) {
            $index = rand(0, $size - 1);
            $card = $cardCPool[$index];
            while (in_array($card->Number, $cardNums)) {
                $index = rand(0, $size - 1);
                $card = $cardCPool[$index];				
            }
			if($cap >2 ){				
					$cardInt = intval($card->Number)-1;
					$cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
					//echo $cardName;
					if (isset($poolDict[$cardName])) {							
						if($poolDict[$cardName] < $cap){							
							$poolDict[$cardName] +=1; 
						} else{							
							while($poolDict[$cardName] > $cap-1){								
								$index = rand(0, $size - 1);
								$card = $cardCPool[$index];
								$cardInt = intval($card->Number)-1;
								$cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
							}
							if (isset($poolDict[$cardName])) {
								$poolDict[$cardName] +=1 ;
							}
							else {						
								$poolDict[$cardName] = 1;
							}
						}						
					} else {						
						$poolDict[$cardName] = 1;
					}					
				}
            array_push($cardNums, $card->Number);
            array_push($cards, $card);
            array_splice($cardCPool, $index, 1);
            $size = $size - 1;
        }
    }
    array_push($ctDisplay, $cards);
}

shuffle($ctDisplay);

$cardDict = array();
$bacDict = array();
$draftCards = "";

$echoString ="";
for($c = 0; $c < $packCount; $c++) {
    $packNum = $c+1;
    $cards = $ctDisplay[$c];
	$packstring = "";
	for ($i = 0; $i < count($cards); $i++) {
		if($i !=0){
			$packstring = $packstring.";";
		}
		$card = $cards[$i];
		$packstring= $packstring.$card->Set.$card->Number;		
	}
	$packurl = "http://dp.dicecoalition.com/pack.html#?pack=".$packstring;
	$draftCards = $draftCards."#".$packNum.":".$packstring;
//	echo $draftCards;
    //echo "<h1><a href='".$packurl."' target='_blank'> Pack ".$packNum."</a></h1><br>";
	$echoString .= "<h1><a href='".$packurl."' target='_blank'> Pack ".$packNum."</a></h1><br>";
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
		$echoString .= $img;
			//echo $img; //readfile($url)."<br>";
        //minus 1 because we are retrievning from 0 based arrays
        $cardInt = intval($card->Number)-1;
        $cardName = get_object_vars($cardInfo)[$card->Set][$cardInt]."-".$card->Set;
        if($card->Rarity != "bac") {
            if (isset($cardDict[$cardName])) {
                $cardDict[$cardName] += 1;
            } else {
                $cardDict[$cardName] = 1;
            }
        }
        else{
            if (isset($bacDict[$cardName])) {
                $bacDict[$cardName] += 1;
            } else {
                $bacDict[$cardName] = 1;
            }
        }
    }
}
$b64packs = base64_encode($draftCards);
$drafturl = "http://dp.dicecoalition.com/vd.html#?pack=".$b64packs;
echo "<h1><a href='".$drafturl."' target='_blank'> Create Draft Room</a></h1><br>";
if($hidePacks == "false")
	echo $echoString;
ksort($cardDict);
ksort($bacDict);
echo "<style>tr:nth-child(even) {background: #CCC} tr:nth-child(odd) {background: #FFF} </style>";
echo "<h3>Dice Counts</h3>";
echo "<table><tr><td>[CHARACTER]</td><td>[SINGLE DRAFT #]</td><td>[DOUBLE DRAFT #]</td></tr>";

foreach($cardDict as $key=>$value){
    $val2 = $value*2;
    echo "<tr><td>".$key."</td><td>".$value."</td><td>".$val2."</td></tr>";
}
echo "</table>";
echo "<h3>BAC Counts</h3>";
echo "<table><tr><td>[CARD NAME]</td><td>[CARD #]</td></tr>";
foreach($bacDict as $key=>$value){
    echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
}
echo "</table>";

foreach (array_keys($GLOBALS) as $k) unset($$k);
unset($k);

function getBacs($set, $instances = 2){
    global $setInfo;
    $cardBacPool = array();
    if(array_key_exists($set, $setInfo->setBACs)){
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

function getBacSets($setsType){
    global $setInfo;
    if(strpos($setsType, ',') !== false){
        $sets = array();
        $setList = explode(',', $setsType);
        foreach($setList as $setname){
            array_push($sets, $setname);
        }
    } else if($setsType === 'all'){
        $sets = array();
        foreach($setInfo->setBACs as $key=>$value){
            array_push($sets, $key);
        }
    }else if($setsType === 'allmarvel'){
        $sets = $setInfo->bacMarvel;
    } else if($setsType === 'alldc'){
        $sets = $setInfo->bacDC;
    } else if($setsType === 'alltmnt'){
        $sets = $setInfo->bacTMNT;
    } else if($setsType === 'alldnd'){
        $sets = $setInfo->bacDnD;
    } else if($setsType === 'modern'){
        $sets = $setInfo->bacModern;
    } else if($setsType === 'modernmarvel'){
        $sets = $setInfo->bacModernMarvel;
    } else if($setsType === 'moderndc'){
        $sets = $setInfo->bacModernDC;
    } else if($setsType === 'moderndnd'){
        $sets = $setInfo->bacModernDnD;
    } else if($setsType === 'moderntmnt'){
        $sets = $setInfo->bacModernTMNT;
    } else{
        $sets = array();
        array_push($sets, $setsType);
    }
    return $sets;
}

function getSets($setsType){
    global $setInfo;
    if(strpos($setsType, ',') !== false){
        $sets = array();
        $setList = explode(',', $setsType);
        foreach($setList as $setname){
            array_push($sets, $setname);
        }
    } else if($setsType === 'all'){
        $sets = array();
        foreach($setInfo->setCommons as $key=>$value){
            array_push($sets, $key);
        }
    }else if($setsType === 'allmarvel'){
        $sets = $setInfo->Marvel;
    } else if($setsType === 'alldc'){
        $sets = $setInfo->DC;
    } else if($setsType === 'alltmnt'){
        $sets = $setInfo->TMNT;
    } else if($setsType === 'alldnd'){
        $sets = $setInfo->DnD;
    } else if($setsType === 'modern'){
        $sets = $setInfo->modern;
    } else if($setsType === 'modernmarvel'){
        $sets = $setInfo->modernMarvel;
    } else if($setsType === 'moderndc'){
        $sets = $setInfo->modernDC;
    } else if($setsType === 'moderndnd'){
        $sets = $setInfo->modernDnD;
    } else if($setsType === 'moderntmnt'){
        $sets = $setInfo->modernTMNT;
    } else{
        $sets = array();
        array_push($sets, $setsType);
    }
    return $sets;
}

