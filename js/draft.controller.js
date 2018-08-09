
var app = angular.module('draftApp', ["ui.checkbox"]);

app.controller('DraftController', function() {
    var vm = this;

    vm.sets= ["avx", "uxm",  "aou", "asm", "cw", "drs", "dp", "imw", "def","smc", "gotg", "xfc", "thor", "jll", "ki", "ai", "jl", "wol", "wf", "gaf", "bat", "sww", "hq", "bff", "fus", "toa", "tmnt", "hhs", "ygo", "bou", "orks", "sw"];//, "all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.bacsets= ["avx", "uxm", "aou", "asm", "cw", "imw", "thor", "ai", "jl", "wol", "wf", "sww", "hq", "bff", "fus",  "toa", "tmnt", "hhs", "ygo", "bou"];//,"all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.starterSets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf"];
    vm.modernSets= ["bat", "imw", "sww", "gotg","xfc", "toa", "thor", "ai", "hhs", "drs", "def", "smc", "jll", "ki", "hq", "bou", "orks", "sw"];//, "all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.modernBacSets= ["imw", "sww", "toa", "thor", "ai", "hq", "bou"];//,"all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.marvel = ["avx", "uxm", "aou", "asm", "cw", "dp","gotg","xfc", "thor", "drs", "def", "smc", "imw", "ai", "jll", "ki"];
    vm.dc = ["jl", "wol", "wf", "gaf", "bat", "sww", "hq"];
    vm.tmnt = ["tmnt", "hhs"];
    vm.dnd = ["bff", "fus","toa"];
	vm.w4k = ["bou", "orks", "sw"];
    vm.sizes= ["thumbnail","small","medium"];
    vm.selectedSet = "avx";
    vm.selectedBacSet = "avx";
    vm.size = "small";
    vm.starter = false;
    vm.packs="";
    vm.loading = false;
    vm.packCount = "8";
    vm.selection = ['avx'];
    vm.bacselection = ['avx'];
    //set at bottom of file because it's ugly
    vm.setNameDictionary = [];
	vm.charCap = "6";
	vm.hidePacks = false;
	
	vm.disabledSets = ["bou", "orks", "sw"];

    vm.load = function()
    {
        vm.packs = "";
        var sl = "t";
        if(vm.size == "thumbnail") sl = "t";
        else if(vm.size == "small") sl = "s";
        else if(vm.size == "medium") sl = "m";
        vm.packs = 'draftPacks.php?set='+vm.selection.join()+'&res='+sl+'&bac='+vm.bacselection.join()+'&starter='+vm.starter+'&packs='+vm.packCount+'&cap='+vm.charCap+'&hide='+vm.hidePacks+'&'+ new Date().getTime();
        //vm.packs = 'draftPacks.php?set='+vm.selectedSet+'&res='+sl+'&bac='+vm.selectedBacSet+'&starter='+vm.starter+'&packs='+vm.packCount+'&'+ new Date().getTime();
    }

    vm.showStarterCheck = function()
    {
        var show = false;
        if(vm.starterSets.indexOf(vm.selectedSet)!=-1) {
            show = true;
        }
        return show;
    }

    vm.select = function(selectType)
    {
        vm.selection = [];
        if(selectType === 'all')
        {
            vm.selection = vm.selection.concat(vm.sets);
        }
        else if(selectType ==='modern')
        {
            vm.selection = vm.selection.concat(vm.modernSets);
        }
		for( var i = vm.disabledSets.length; i--;){
			var index = vm.selection.indexOf(vm.disabledSets[i])
			if(index >-1)
				vm.selection.splice(index, 1);
		}
    }

    vm.bacselect = function(selectType)
    {
        vm.bacselection = [];
        if(selectType === 'all')
        {
            vm.bacselection = vm.bacselection.concat(vm.bacsets);
        }
        else if(selectType ==='modern')
        {
            vm.bacselection = vm.bacselection.concat(vm.modernBacSets);
        }
		for( var i = vm.disabledSets.length; i--;){
			var index = vm.bacselection.indexOf(vm.disabledSets[i])
			if(index >-1)
				vm.bacselection.splice(index, 1);
		}
    }

    vm.toggleSelection = function (set) {
        var idx = vm.selection.indexOf(set);

        // Is currently selected
        if (idx > -1) {
            vm.selection.splice(idx, 1);
        }

        // Is newly selected
        else {
            vm.selection.push(set);
        }
    }

    vm.toggleBacSelection = function (set) {
        var idx = vm.bacselection.indexOf(set);

        // Is currently selected
        if (idx > -1) {
            vm.bacselection.splice(idx, 1);
        }

        // Is newly selected
        else {
            vm.bacselection.push(set);
        }
    }

    vm.getClass = function(set)
    {
        var className = "other";
        if(vm.marvel.indexOf(set)!=-1) {
            className = "marvel";
        }
        else if(vm.dc.indexOf(set)!=-1) {
            className = "dc";
        }
        else if(vm.dnd.indexOf(set)!=-1) {
            className = "dnd";
        }
        else if(vm.tmnt.indexOf(set)!=-1) {
            className = "tmnt";
        }
        return className;
    }

    vm.getSetName = function(set)
    {
        return vm.setNameDictionary[set];
    }

    vm.setNameDictionary['avx'] = "Avengers vs X-Men";
    vm.setNameDictionary['uxm'] = "Uncanny X-men";
    vm.setNameDictionary['jl'] = "Justice League";
    vm.setNameDictionary['ygo'] = "Yu-Gi-Oh";
    vm.setNameDictionary['bff'] =  "Battle For Faerun";
    vm.setNameDictionary['aou'] = "Age of Ultron";
    vm.setNameDictionary['wol'] =  "War of Light";
    vm.setNameDictionary['asm'] = "Amazing Spider-man";
    vm.setNameDictionary['fus'] = "Faerun Under Siege";
    vm.setNameDictionary['cw']="Civil War";
    vm.setNameDictionary['wf'] = "World's Finest";
    vm.setNameDictionary['gaf'] = "Green Arrow and The Flash";
    vm.setNameDictionary['dp'] = "Dead Pool";
    vm.setNameDictionary['bat'] = "Batman";
    vm.setNameDictionary['gotg'] = "Guardians of the Galaxy";
    vm.setNameDictionary['xfc'] = "X-Men First Class";
    vm.setNameDictionary['toa'] = "Tomb of Annihilation";
    vm.setNameDictionary['thor'] = "The Mighty Thor";
    vm.setNameDictionary['tmnt'] = "Teenage Mutant Ninja Turtles";
    vm.setNameDictionary['hhs'] = "Heroes in a Half Shell";
    vm.setNameDictionary['drs'] = "Doctor Strange";
    vm.setNameDictionary['def'] = "Defenders";
    vm.setNameDictionary['smc'] = "Spider-man: Maximum Carnage";
    vm.setNameDictionary['imw'] = "Iron Man and War Machine";
    vm.setNameDictionary['sww'] = "Superman and Wonder Woman";
	vm.setNameDictionary['hq'] = "Harley Quinn - Coming Soon!";
	vm.setNameDictionary['ki'] = "Kree Invasion - Coming Soon!";
	vm.setNameDictionary['jll'] = "Justice Like Lightning - Coming Soon!";
	vm.setNameDictionary['ai'] = "Avengers Infinity - Coming Soon!";
	vm.setNameDictionary['bou'] = "Warhammer 40K: Battle of Ultramar - Coming Soon!";
	vm.setNameDictionary['orks'] = "Orks - WAAGH! Team Pack - Coming Soon!";
	vm.setNameDictionary['sw'] = "Space Wolves - Sons of Russ Team Pack - Coming Soon!";
});
