<?php
/**
 * Author: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */
//README!  This script pulls images from CoolStuffInc's card scan repository.  
//README!  If this is copied to the server DELETE IT WHEN YOU ARE DONE!  
//README!  We should NOT leave this script accessible. 
//README!  Nefarious hands could use it to bog down our server and CSI's.
include("setInfo.php");
$setInfo = new setInfo();
$setDictionaryCSI = $setInfo->setDictionaryCSI;
$setDictionaryDC = $setInfo->setDictionaryDC;
$set = $_GET['set'];
$cardNumber = $_GET['cardnum'];
if(!$set){
    echo "Please specify a set. example: Img.php?set=avx&cardnum=12";
}

if($set){
    $set = strtolower($set);
    if (array_key_exists($set,$setDictionaryCSI)) {
        $setNameCSI = $setDictionaryCSI[$set];
        $setNameDC =  $setDictionaryDC[$set];
        $baseUrl = "https://res.cloudinary.com/csicdn/image/upload//v1/Images/Products/Dice%20Masters%20Art/";
        if($cardNumber) {
            $imageUrl = $baseUrl . $setNameCSI . "/full/" . $cardNumber . ".jpg";
            $destination = "Cards/".$setNameDC."/".$cardNumber.".jpg";
            //$img = imagecreatefromstring(file_get_contents($imageUrl));
            file_put_contents($destination, file_get_contents($imageUrl));
            echo $imageUrl." copied to ".$destination;
        }
        else
        {
            $cardNumber = 1;
            $imageUrl = $baseUrl . $setNameCSI . "/full/" . $cardNumber . ".jpg";
            $destination = "Cards/".$setNameDC."/".$cardNumber.".jpg";
            //$img =  file_get_contents($imageUrl);
            echo "Getting ".$imageUrl."<br>";
            while(FALSE != ($img = @file_get_contents($imageUrl))){
                file_put_contents($destination, $img);
                echo $imageUrl." copied to ".$destination."<br>";
                $cardNumber++;
                $imageUrl = $baseUrl . $setNameCSI . "/full/" . $cardNumber . ".jpg";
                $destination = "Cards/".$setNameDC."/".$cardNumber.".jpg";
                echo "Getting ".$imageUrl."<br>";
            }
            echo $cardNumer." cards copied to Cards/".$setNameDC;
        }
    }
    else{
        echo "Invalid set name: ".$set.". Please check tb.dicecoalition.com for proper set abbreviations.";
    }
}
