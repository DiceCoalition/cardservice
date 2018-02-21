<?php
/**
 * Author: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */
//README!  This script resizes pulled images to Thumbnail, Small, Medium, Large, and Full resolution
//README!  If this is copied to the server DELETE IT WHEN YOU ARE DONE!  
//README!  We should NOT leave this script accessible. 
//README!  Nefarious hands could use it to bog down our server.
function resize_image($file, $res, $crop=FALSE) {
/*490x694 Full
368x521 Large
245x347 Medium
163x231 Small
61x86 Thumb
*/
    $w = 245;
    $h = 347;
    if($res === "full")
    {
        $w = 490;
        $h = 694;
    }
    else if($res ==="large")
    {
        $w = 368;
        $h = 521;
    }
    else if($res === "small")
    {
        $w = 163;
        $h = 231;
    }
    else if($res === "thumb")
    {
        $w = 61;
        $h = 86;
    }
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if($r > 0.75)
    {
        $percent = $h/$height;
        $w = $width * $percent;
    }
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

include("setInfo.php");
$setInfo = new setInfo();
$setDictionaryDC = $setInfo->setDictionaryDC;
$set = $_GET['set'];
$cardNumber = $_GET['cardnum'];

if(!$set){
    echo "Please specify a set. example: Img.php?set=avx&cardnum=12";
}

if($set){
    $set = strtolower($set);
    if (array_key_exists($set,$setDictionaryDC)) {

        $setNameDC =  $setDictionaryDC[$set];
        if($cardNumber) {
            $imageUrl = "Cards/".$setNameDC."/".$cardNumber.".jpg";
            if (file_exists($imageUrl)) {
                $destination = "Cards/" . $setNameDC . "/" . $cardNumber . "full.jpg";
                $img = resize_image($imageUrl, "full");
                if ($img && !file_exists($destination)) {
                    imagejpeg($img, $destination);
                    imagedestroy($img);
                }
                $destination = "Cards/" . $setNameDC . "/" . $cardNumber . "large.jpg";
                $img = resize_image($imageUrl, "large");
                if ($img && !file_exists($destination)) {
                    imagejpeg($img, $destination);
                    imagedestroy($img);
                }
                $destination = "Cards/" . $setNameDC . "/" . $cardNumber . "medium.jpg";
                $img = resize_image($imageUrl, "medium");
                if ($img && !file_exists($destination)) {
                    imagejpeg($img, $destination);
                    imagedestroy($img);
                }
                $destination = "Cards/" . $setNameDC . "/" . $cardNumber . "small.jpg";
                $img = resize_image($imageUrl, "small");
                if ($img && !file_exists($destination)) {
                    imagejpeg($img, $destination);
                    imagedestroy($img);
                }
                $destination = "Cards/" . $setNameDC . "/" . $cardNumber . "thumb.jpg";
                $img = resize_image($imageUrl, "thumb");
                if ($img && !file_exists($destination)) {
                    imagejpeg($img, $destination);
                    imagedestroy($img);
                }
            }
            else
                echo "Could no get ".$imageUrl."<br>";
        }
        else
        {
            for($i = 1; $i <= $setInfo->cardCount[$set]; $i++) {
                $imageUrl = "Cards/" . $setNameDC . "/" . $i . ".jpg";
                echo "Getting " . $imageUrl . "<br>";
                if (file_exists($imageUrl)) {
                    $destination = "Cards/" . $setNameDC . "/" . $i . "full.jpg";
                    $img = resize_image($imageUrl, "full");
                    if($img && !file_exists($destination)) {
                        imagejpeg($img, $destination);
                        imagedestroy($img);
                    }
                    $destination = "Cards/" . $setNameDC . "/" . $i . "large.jpg";
                    $img = resize_image($imageUrl, "large");
                    if($img && !file_exists($destination)) {
                        imagejpeg($img, $destination);
                        imagedestroy($img);
                    }
                    $destination = "Cards/" . $setNameDC . "/" . $i . "medium.jpg";
                    $img = resize_image($imageUrl, "medium");
                    if($img && !file_exists($destination)) {
                        imagejpeg($img, $destination);
                        imagedestroy($img);
                    }
                    $destination = "Cards/" . $setNameDC . "/" . $i . "small.jpg";
                    $img = resize_image($imageUrl, "small");
                    if($img && !file_exists($destination)) {
                        imagejpeg($img, $destination);
                        imagedestroy($img);
                    }
                    $destination = "Cards/" . $setNameDC . "/" . $i . "thumb.jpg";
                    $img = resize_image($imageUrl, "thumb");
                    if($img && !file_exists($destination)) {
                        imagejpeg($img, $destination);
                        imagedestroy($img);
                    }
                }
                else
                    echo "Could no get ".$imageUrl."<br>";
            }
        }
    }
    else{
        echo "Invalid set name: ".$set.". Please check tb.dicecoalition.com for proper set abbreviations.";
    }
}
