<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/16/2018
 * Time: 6:03 PM
 */

class Card
{
    public $Set;
    public $Number;
    public $Rarity;

    function __construct($set, $number, $rarity = null) {
        $this->Set  = $set;
        $this->Number  = $number;
        $this->Rarity  = $rarity;

    }
}