<?php
/**
 * User: tturner
 * Date: 9/3/2019
 * Time: 9:38 AM
 */
include_once("setInfo.php");

function getImg($set, $cardNumber, $res)
{	
	$setInfoLoc = new setInfo();
	$setDictionary = $setInfoLoc->setDictionaryDC;
	$returnString = "";
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

			$returnString = '<img src="' . $imageUrl . '" alt="'.$setName.$cardNumber.'">';			
		}
		else{
			$returnString = "Invalid set name: ".$set.". Please check tb.dicecoalition.com for proper set abbreviations.";	
			echo $returnString;
		}
	}

	foreach (array_keys($GLOBALS) as $k) unset($$k);
	unset($k);
	return $returnString;
}
?>