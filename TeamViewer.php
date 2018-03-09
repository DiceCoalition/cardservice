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
$format = $_GET['format'];
$unique = uniqid();
//$team = $_GET['team'];
//echo $team;
//$cardIndex = strrpos($team, "&cards=") + 7;
//echo $cardIndex;
if($cards) {
    echo "<script type=\"text/javascript\" src=\"http://dicecoalition.com/cardservice/js/jquery-3.3.1.min.js\"></script>";
    //echo " <link href=\"http://dicecoalition.com/cardservice/css/bootstrap.min.css\" rel=\"stylesheet\" media=\"screen\" />";
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
    $cardsArray = explode(';', $cards);
    if($format === "hybrid" or !$format) {
        //echo "<div class='container teamview'><div class='row'><div class='col-sm-4'>";
        echo "<div class='teamview'>";
        if($name)
            echo "<label class='teamLabel'>".$name."</label></td></tr><tr><td>";
        //echo "<ul id=\"cards\" style=\"list-style: none;\">";
        echo "<table><tr><td style='vertical-align: top;'>";
        echo "<table id=\"cards" . $unique . "\" ><tr class='cardLabel'><td>Card</td><td>Dice</td></tr>";
        //$cardsString = substr($team, $cardIndex);
        $index = 1;
        $firstCard;
        foreach ($cardsArray as $card) {
            $dice = substr($card, 0, 1);
            $cardinfoString = substr($card, 2);
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $cardinfoString);
            $cardNum = $arr[0];
            $cardSet = $arr[1];

            $cardArrayIndex = $cardNum - 1;
            $cardName = get_object_vars($cardInfo)[$cardSet][$cardArrayIndex];

            $url = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=m";
            $urlHigh = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=l";
            if ($index === 1)
                $firstCard = $url;
            //$img = file_get_contents($url);
            //echo "<li>".$dice." <a id=\"1\" href=\"".$urlHigh."\" data-filename=\"".$url."\" target=\"_new\">".$cardName."</a></li>";
            $link = "<a id=\"" . $index . "\" href=\"" . $urlHigh . "\" data-filename=\"" . $url . "\" data-lightbox=\"team" . $unique . "\" >" . $cardName . "</a>";
            //echo "<li>".$dice." ".$link."</li>";
            if ($index === 9) {

                echo "</table><br><label class='cardLabel'>Basic Actions</label><table id='cards" . $unique . "'>";
            }
            if ($index < 9)
                echo "<tr><td data-filename=\"" . $url . "\">" . $link . "</td><td style='text-align: center'>" . $dice . "</td></tr>";
            else
                echo "<tr><td data-filename=\"" . $url . "\">" . $link . "</td></tr>";

            //echo $img;
            $index += 1;
        }

        //echo "</ul></div>";
        echo "</table>";
        //echo "<a href=\"http://tb.dicecoalition.com/?view&cards=".$cards."\" target=\"_new\" style='font-size:0.9rem'>View In Team Builder</a><br>";
        echo "<a href=\"http://tb.dicecoalition.com/?view&cards=".$cards."\" target=\"_new\"><img src='http://dicecoalition.com/cardservice/images/tb-small.png' title='View In Team Builder'></a><br>";
        //echo "</div>";
        echo "</td><td>";
        echo "<div class='box".$unique."' style='height:350px'><img src=\"".$firstCard."\"/ class='regImage img-responsive pluginImg'></div></div></div><br>";
        echo "</td></tr></table></div>";
    }
    else if($format === 'images'){
        //echo "<div class='container tbDiv'><div class='row'>";
        $index = 1;
        $diceArray = array();
        echo "<div class='teamview'>";
        if($name)
            echo "<label class='teamLabel'>".$name."</label>";
        echo "<table><tr>";
        $cardCount = count($cardsArray);
        foreach ($cardsArray as $card) {
            $dice = substr($card, 0, 1);
            $cardinfoString = substr($card, 2);
            $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i', $cardinfoString);
            $cardNum = $arr[0];
            $cardSet = $arr[1];
            array_push($diceArray, $dice);
            $cardArrayIndex = $cardNum - 1;
            $cardName = get_object_vars($cardInfo)[$cardSet][$cardArrayIndex];

            $url = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=s";
            $urlHigh = "http://dicecoalition.com/cardservice/Image.php?set=" . $cardSet . "&cardnum=" . $cardNum . "&res=l";
            $link = "<a id=\"" . $index . "\" href=\"" . $urlHigh . "\" data-filename=\"" . $url . "\" data-lightbox=\"team" . $unique . "\" ><img src='" . $url . "' width='150px' class='regImage img-responsive pluginImg'></a>";

            //echo "<div class='col-sm-2'>".$link."</div>";
            echo "<td>".$link."</td>";
            if($index === $cardCount/2){
                echo "</tr><tr>";
                foreach ($diceArray as $diceCount) {
                    echo "<td class='even'>Dice: " . $diceCount . "</td>";
                }
                echo "</tr><tr>";
                unset($diceArray); // $foo is gone
                $diceArray = array();
            }
            else if($index === $cardCount){
                echo "</tr><tr>";
                foreach ($diceArray as $diceCount) {
                    echo "<td class='even'>Dice: " . $diceCount . "</td>";
                }
                echo "</tr>";
                unset($diceArray); // $foo is gone
            }

            $index += 1;
        }
        echo "</tr></table>";
        echo "<a href=\"http://tb.dicecoalition.com/?view&cards=".$cards."\" target=\"_new\"><img src='http://dicecoalition.com/cardservice/images/tb-small.png' title='View In Team Builder'></a><br>";
        echo "</div>";
    }

    echo "<style>.teamview { background: white;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}</style>";
    echo "<style>.teamLabel { font-weight:700;font-style:italic;font-size:1.4rem;margin:0;padding:0;text-align: left}</style>";
    echo "<style>.cardLabel { font-weight:700;font-size:1.4rem;margin:0;padding:0}</style>";
    //echo "<link href=\"http://dicecoalition.com/cardservice/css/lightbox.css\" rel=\"stylesheet\">";
    echo "<script src=\"http://dicecoalition.com/cardservice/js/lightbox.js\"></script>";

}