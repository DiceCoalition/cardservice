<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/24/2018
 * Time: 5:31 PM
 */
include("setInfo.php");
$lines = file_get_contents('http://dicecoalition.com/teambuilder/cards.php');
echo $lines;
$characters = array();
$listNum = 1;
foreach($setInfo->setCommons as $key=>$value){
    $varindex = strpos($lines, "var ".$key);
    $bracIndex1 = strpos($lines, '[', $varindex);
    $bracIndex2 = strpos($lines, ']', $varindex);
    $length = $bracIndex2 - $bracIndex1;
    echo $key.": ".substr($lines, $bracIndex1+1, $length-1);
    //array_push($sets, $key);
}


var_dump($pages);