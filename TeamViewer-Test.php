<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 3/5/2018
 * Time: 3:04 PM
 *
 * something that takes in a Teambuilder link and then turns that into something like
 * http://tb.dicecoalition.com/?view&cards=2x31xfc;2x16smc;2x113fus;2x13wf;2x87xfc;4x86gaf;4x119gotg;2x59gotg;3x27fus;3x12thor
 * https://magic.wizards.com/en/articles/archive/how-build/almost-there-white-blue-auras-2018-02-09
 *
 */

include("setInfo.php");
include("cardInfo.php");
$setInfo = new setInfo();
$cardInfo = new cardInfo();

$setDictionary = $setInfo->setDictionaryDC;

$cards = $_GET['cards'];
$name = $_GET['name'];
$unique = uniqid();
//$team = $_GET['team'];
//echo $team;
//$cardIndex = strrpos($team, "&cards=") + 7;
//echo $cardIndex;
if($cards) {
    echo "<script type=\"text/javascript\" src=\"http://dicecoalition.com/cardservice/js/jquery-3.3.1.min.js\"></script>";
    echo " <link href=\"http://dicecoalition.com/cardservice/css/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\" />";
    echo "<link href=\"http://dicecoalition.com/cardservice/css/lightbox.css\" rel=\"stylesheet\">";
    echo "<script>
        $(document).ready(function() {                        
            $('#cards".$unique." td a').hover(
                function(){
                    //we get our current filename and use it for the src
                    var linkIndex = $(this).attr('data-filename');
                    $(this).addClass('hover');
                    $('.box".$unique." img').attr('src', linkIndex);
                }            
            );        
        });
        
    </script>";
    echo "<style>.cardLabel { font-weight:700;font-style:italic;font-size:1.6rem;margin:0;padding:0}</style>";
    echo "<div class='container'><div class='row'><div class='col-sm-4'>";
    echo "<a href=\"http://tb.dicecoalition.com/?view&cards=".$cards."\" target=\"_new\" style='font-size:1.6rem'>View In Team Builder</a><br>";
    if($name)
        echo "<label class='cardLabel'>".$name."</label>";
    //echo "<ul id=\"cards\" style=\"list-style: none;\">";
    echo "<table id=\"cards".$unique."\"><tr class='cardLabel'><td>Card</td><td>Dice</td></tr>";
    //$cardsString = substr($team, $cardIndex);
    $cardsArray = explode(';', $cards);
    $index=1;
    $firstCard;
    foreach($cardsArray as $card){
        $dice = substr($card, 0, 1);
        $cardinfoString = substr($card, 2);
        $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$cardinfoString);
        $cardNum = $arr[0];
        $cardSet = $arr[1];

        $cardArrayIndex = $cardNum - 1;
        $cardName = get_object_vars($cardInfo)[$cardSet][$cardArrayIndex];

        $url = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=m";
        $urlHigh = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=l";
        if($index ===1)
            $firstCard = $url;
        //$img = file_get_contents($url);
        //echo "<li>".$dice." <a id=\"1\" href=\"".$urlHigh."\" data-filename=\"".$url."\" target=\"_new\">".$cardName."</a></li>";
        $link = "<a id=\"".$index."\" href=\"".$urlHigh."\" data-filename=\"".$url."\" data-lightbox=\"team".$unique."\" >".$cardName."</a>";
        //echo "<li>".$dice." ".$link."</li>";
        if($index ===9) {

            echo "</table><label class='cardLabel'>Basic Actions</label><table id='cards".$unique."'>";
        }
        if($index < 9)
            echo "<tr><td data-filename=\"".$url."\">".$link."</td><td style='text-align: center'>".$dice."</td></tr>";
        else
            echo "<tr><td data-filename=\"".$url."\">".$link."</td></tr>";

        //echo $img;
        $index +=1;
    }
    //echo "</ul></div>";
    echo "</table></div>";
    echo "<div class='box".$unique." col-sm-4'><img src=\"".$firstCard."\"/></div></div></div>";
    echo "<script src=\"http://dicecoalition.com/cardservice/js/lightbox.js\"></script>";

}