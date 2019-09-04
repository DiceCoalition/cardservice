<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/15/2018
 * Time: 9:38 AM
 */

include_once("ImgFunc.php");
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
echo getImg($set, $cardNumber, $res);
?>
