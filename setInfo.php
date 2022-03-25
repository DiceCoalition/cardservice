<?php
/**
 * Created by PhpStorm.
 * User: tturner
 * Date: 2/15/2018
 * Time: 8:40 PM
 */

class setInfo
{
	//TODO:  Forgot to add Infinity Gauntlet
    public $setDictionaryCSI = array(
    "avx" => "Avengers%20vs%20X-Men" ,
    "uxm" => "The%20Uncanny%20X-men" ,
    "aou" => "Marvel%20Avengers%20Age%20of%20Ultron" ,
    "asm" => "Marvel%20The%20Amazing%20Spider-Man" ,
    "cw" => "Marvel%20Civil%20War" ,
    "drs" => "Doctor%20Strange" ,
    "dp" => "Deadpool" ,
    "imw" => "Iron%20Man%20and%20War%20Machine" ,
    "def" => "Marvel%20Defenders" ,
    "smc" => "Spider-Man%20Maximum%20Carnage" ,
    "gotg" => "Marvel%20Guardians%20of%20the%20Galaxy" ,
    "xfc" => "Marvel%20X-Men%20First%20Class" ,
    "thor" => "Marvel%20The%20Mighty%20Thor" ,

    "jl" => "DC%20Justice%20League" ,
    "wol" => "DC%20War%20of%20Light" ,
    "wf" => "DC%20Worlds%20Finest" ,
    "gaf" => "Green%20Arrow%20and%20The%20Flash" ,
    "bat" => "DC%20Batman" ,
    "sww" => "DC%20Superman%20and%20Wonder%20Woman" ,

    "bff" => "DandD%20Dice%20Masters%20Battle%20for%20Faerun" ,
    "fus" => "DandD%20Dice%20Masters%20Faerun%20Under%20Siege" ,
    "toa" => "DandD%20Dice%20Masters%20Tomb%20of%20Annihilation" ,
    "tmnt" => "TMNT" ,
    "hhs" => "TMNT%20Heroes%20in%20a%20Half%20Shell" ,
    "ygo" => "Yu-Gi-Oh%20Dice%20Masters%20Series%20One"
    );

    public $setDictionaryDC = array(
    "avx" => "AVX" ,
    "uxm" => "UXM" ,
    "aou" => "AOU" ,
    "asm" => "ASM" ,
    "cw" => "CW" ,
    "drs" => "DS" ,
    "dp" => "DP" ,
    "imw" => "IMWW" ,
    "def" => "DEF" ,
    "smc" => "SMMC" ,
    "gotg" => "GOTG" ,
    "xfc" => "XFC" ,
    "thor" => "TMT" ,
	"ai" => "AI" ,
	"ki" => "KI" ,
	"jll" => "JLL",
	"xmf" => "XMF",
	"xfo" => "XFO",
	"dxm" => "DXM",
	"ig" => "IG",
	"dps" => "DPS",

    "jl" => "JL" ,
    "wol" => "WOL" ,
    "wf" => "WF" ,
    "gaf" => "GAF" ,
    "bat" => "BAT" ,
    "sww" => "SMWW" ,
    "hq" => "HQ" ,
    "jus" => "JUS",
    "doom" => "DOOM",
    "myst" => "MYST",

    "bff" => "BFF" ,
    "fus" => "FUS" ,
    "toa" => "TOA" ,
	"tiw" => "TIW" ,
	"aiw" => "AIW" ,
	"zhn" => "ZHN" ,
    "tmnt" => "TMNT" ,
    "hhs" => "HHS" ,
    "ygo" => "YGO" ,
	"bfu" => "BFU" ,
	"ork" => "ORK" ,
	"sw" => "SW" ,
	"wwe" => "WWE",
	"tag" => "TAG",
	"bit" => "BIT",
	
	"m2022" => "m_op2022",
    "m2020" => "m_op2020",
    "m2019" => "m_op2019",
	"m2017" => "m_op2017",
	"m2016" => "m_op2016",
	"m2015" => "m_op2015",
	//avengers disassembled double entry
	"m2014" => "m_op2014",	
	"uxmop2" => "m_op2014",
	"uxmop" => "uxmop",
	"dc2017" =>"dc_op2017",
	"dc2016" =>"dc_op2016",
	"dc2015" =>"dc_op2015",
	"wolop" =>"dc_op2015",
	"dd2016" => "dnd_op2016",
	"dd2015" => "dnd_op2015",
	"d2016" => "dnd_op2016",
	"d2015" => "dnd_op2015",
	"bffop" => "dnd_op2015",
	"bffpr" => "dnd_promo",
	//trinity war double entry
	"dctw" => "dctw",
	"jlop" => "dctw",
	"avxop" => "avxop",
	"wko16dd" => "dnd_wkop2016",
	"wko16m" => "m_wkop2016",
	"m_wkop2015" => "m_wkop2015",
	"wko16dc" => "dc_wkop2016",
	"dc_wkop2015" => "dc_wkop2015",
    "sk2017" => "sk2017",
    "wd2018" => "wd_op2018",
	"null" => "null",
    );

    public $cardCount = array(
        "avx" => 132 ,
        "uxm" => 126 ,
        "aou" => 142 ,
        "asm" => 142 ,
        "cw" => 142 ,
        "drs" => 24 ,
        "dp" => 124 ,
        "imw" => 34 ,
        "def" => 24 ,
        "smc" => 24 ,
        "gotg" => 124 ,
        "xfc" => 124 ,
        "thor" => 136 ,
		"ai" => 58 ,
		"ki" => 24 ,
		"jll" => 24 ,
		"xmf" => 72 ,
		"xfo" => 24 ,
		"dxm" => 24 ,
		"ig" => 152,
		"dps" => 152 ,

        "jl" => 138 ,
        "wol" => 142 ,
        "wf" => 142 ,
        "gaf" => 124 ,
        "bat" => 124 ,
        "sww" => 34 ,
        "hq" => 24 ,
        "jus" => 73,
        "doom" => 24,
        "myst" => 24,

        "bff" => 138 ,
        "fus" => 142 ,
        "toa" => 137 ,
		"tiw" => 59,
		"aiw" => 24,
		"zhn" => 24,
        "tmnt" => 58 ,
        "hhs" => 58 ,
        "ygo" => 120,
		"bfu" => 58,
		"ork" => 24,
		"sw" => 24,
		"wwe" => 58,
		"tag" => 24,
		"bit" => 24
    );

    public $setBACs = array(
        "avx" => "25-34" ,
        "uxm" => "25-34" ,
        "aou" => "25-34" ,
        "asm" => "25-34" ,
        "cw" => "23-32" ,
        "imw" => "25-34" ,
        "thor" => "1-12" ,
		"ai" => "49-58" ,
		"xmf" => "63-72" ,
		"ig" => "1-16",
		"dps" => "1-16" ,

        "jl" => "25-34" ,
        "wol" => "25-34" ,
        "wf" => "25-34" ,
        "sww" => "25-34" ,
        "hq" => "22-24" ,
        "jus" => "64-73",

        "bff" => "129-138" ,
        "fus" => "25-34" ,
        "toa" => "1-12" ,
		"tiw" => "50-59" ,
        "tmnt" => "49-58" ,
        "hhs" => "49-58" ,
        "ygo" => "111-120" ,
		"bfu" => "49-58",
		"wwe" => "49-58"
    );

    public $setCommons = array(
        "avx" => "1-24,35-64" ,
        "uxm" => "1-24,35-62" ,
        "aou" => "1-24,35-74" ,
        "asm" => "1-24,35-74" ,
        "cw" => "1-22,33-72" ,
        "drs" => "1-24" ,
        "dp" => "1-40" ,
        "imw" => "1-24" ,
        "def" => "1-24" ,
        "smc" => "1-24" ,
        "gotg" => "1-40" ,
        "xfc" => "1-40" ,
        "thor" => "13-52" ,
		"ai" => "1-48",
		"ki" => "1-24",
		"jll" => "1-24",
		"xmf" => "1-62",
		"xfo" => "1-24",
		"dxm" => "1-24",
		"ig" => "17-56",
		"dps" => "17-56",

        "jl" => "1-24,35-73" ,
        "wol" => "1-24,35-74" ,
        "wf" => "1-24,35-74" ,
        "gaf" => "1-40" ,
        "bat" => "1-40" ,
        "sww" => "1-24" ,
        "hq" => "1-21",
        "jus" => "1-63",
        "doom" => "1-24",
        "myst" => "1-24",

        "bff" => "1-24,25-64" ,
        "fus" => "1-24,35-74" ,
        "toa" => "13-52" ,
		"tiw" => "1-49",
		"aiw" => "1-24",
		"zhn" => "1-24",
        "tmnt" => "1-48" ,
        "hhs" => "1-48" ,
        "ygo" => "1-40" ,
		"bfu" => "1-48" ,
		"ork" => "1-24" ,
		"sw" => "1-24",
		"wwe" => "1-48",
		"bit" => "1-24",
		"tag" => "1-24"
    );

    public $setUncommons = array(
        "avx" => "65-98" ,
        "uxm" => "63-94" ,
        "aou" => "75-106" ,
        "asm" => "75-106" ,
        "cw" => "73-104" ,
        "dp" => "41-80" ,
        "gotg" => "41-80" ,
        "xfc" => "41-80" ,
        "thor" => "53-92" ,
		"ig" => "57-96",
		"dps" => "57-96",

        "jl" => "74-106" ,
        "wol" => "75-106" ,
        "wf" => "75-106" ,
        "gaf" => "41-80" ,
        "bat" => "41-80" ,

        "bff" => "65-96" ,
        "fus" => "75-106" ,
        "toa" => "53-92" ,
        "ygo" => "41-70"
    );

    public $setRares = array(
        "avx" => "99-128" ,
        "uxm" => "95-122" ,
        "aou" => "107-134" ,
        "asm" => "107-134" ,
        "cw" => "105-134" ,
        "dp" => "81-116" ,
        "gotg" => "81-116",
        "xfc" => "81-116" ,
        "thor" => "93-128" ,
		"ig" => "97-136",
		"dps" => "97-136",

        "jl" => "107-134" ,
        "wol" => "107-134" ,
        "wf" => "107-134" ,
        "gaf" => "81-116" ,
        "bat" => "81-116" ,

        "bff" => "97-124" ,
        "fus" =>  "107-134",
        "toa" => "93-128" ,
        "ygo" => "71-106"
    );

    public $setSuperRares = array(
        "avx" => "129-132" ,
        "uxm" => "123-126" ,
        "aou" => "135-142" ,
        "asm" => "135-142" ,
        "cw" => "135-142" ,
        "dp" => "117-124" ,
        "gotg" => "117-124" ,
        "xfc" => "117-124" ,
        "thor" => "129-136" ,
		"ig" => "137-152",
		"dps" => "137-152",

        "jl" => "135-138" ,
        "wol" => "135-142" ,
        "wf" => "135-142" ,
        "gaf" => "117-124" ,
        "bat" => "117-124" ,

        "bff" => "125-128" ,
        "fus" => "135-142" ,
        "toa" => "129-136" ,
        "ygo" => "107-110"
    );
	
	public $Marvel = array("avx", "uxm", "aou", "asm", "cw", "drs", "dp", "imw", "def", "smc", "gotg", "xfc", "thor", "ai", "ki", "jll", "xmf","xfo","dxm","ig","dps");
	public $DC = array("jl", "wol", "wf", "gaf","bat", "sww", "hq", "jus", "doom", "myst");
	public $TMNT = array("tmnt", "hhs");
	public $DnD = array("bff", "fus", "toa", "tiw", "aiw", "zhn");
	public $W4K = array("bfu", "ork", "sw");
	public $WWE = array("wwe", "tag", "bit");
	public $modern = array("drs", "imw", "def", "smc", "gotg", "xfc", "thor", "bat", "sww", "hhs", "toa", "hq", "jus", "doom", "myst", "ai", "ki", "jll", "bfu", "ork", "sw", "xmf","xfo","dxm", "tiw", "aiw", "zhn", "wwe", "bit", "tag", "ig", "dps");
	public $modernMarvel = array("drs", "imw", "def", "smc", "gotg", "xfc", "thor", "ai", "ki", "jll", "xmf","xfo","dxm","ig","dps");
	public $modernDC = array("bat", "sww", "hq", "jus", "doom", "myst");
	public $modernTMNT = array("tmnt", "hhs");
	public $modernDnD = array("toa", "tiw", "aiw", "zhn");
	public $bacMarvel = array("avx", "uxm", "aou", "asm", "cw", "imw", "thor", "ai", "xmf", "ig", "dps");
	public $bacDC = array("jl", "wol", "wf", "sww", "hq");
	public $bacTMNT = array("tmnt", "hhs");
	public $bacDnD = array("bff", "fus", "toa", "tiw");
	public $bacModern = array("imw", "thor", "sww", "hhs", "toa", "ai", "hq", "bfu", "xmf", "tiw", "wwe", "ig", "dps");
	public $bacModernMarvel = array("imw", "thor", "ai", "xmf", "ig", "dps");
	public $bacModernDC = array("sww", "hq", "jus");
	public $bacModernTMNT = array("hhs");
	public $bacModernDnD = array("toa", "tiw");
    
}
