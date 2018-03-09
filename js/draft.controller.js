
var app = angular.module('draftApp', ["ui.checkbox"]);

app.controller('DraftController', function() {
    var vm = this;

    vm.sets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf", "gaf", "dp","bat","gotg","xfc", "toa", "thor", "tmnt", "hhs", "ds", "def", "smc", "imw", "sww"];//, "all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.bacsets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf", "tmnt", "hhs", "imw", "sww", "toa", "thor"];//,"all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.starterSets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf"];
    vm.modernSets= ["wol", "asm", "fus", "cw", "wf", "gaf", "dp","bat", "imw", "sww", "gotg","xfc", "toa", "thor", "tmnt", "hhs", "ds", "def", "smc"];//, "all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.modernBacSets= ["wol", "asm", "fus", "cw", "wf", "tmnt", "hhs", "imw", "sww", "toa", "thor" ];//,"all","allMarvel","allDC","allTMNT", "allDnD", "modern", "modernMarvel","modernDC","modernDnD"];
    vm.marvel = ["avx", "uxm", "aou", "asm", "cw", "dp","gotg","xfc", "thor", "ds", "def", "smc", "imw"];
    vm.dc = ["jl", "wol", "wf", "gaf", "bat", "sww"];
    vm.tmnt = ["tmnt", "hhs"];
    vm.dnd = ["bff", "fus","toa"];
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


    vm.load = function()
	{
        vm.packs = "";
		var sl = "t";
		if(vm.size == "thumbnail") sl = "t";
		else if(vm.size == "small") sl = "s";
        else if(vm.size == "medium") sl = "m";
		vm.packs = 'draftPacks.php?set='+vm.selectedSet+'&res='+sl+'&bac='+vm.selectedBacSet+'&starter='+vm.starter+'&packs='+vm.packCount+'&'+ new Date().getTime();
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
    }

    vm.bacselect = function(selectType)
    {
        vm.bacselection = [];
        if(selectType === 'all')
        {
            vm.bacselection = vm.selection.concat(vm.bacsets);
        }
        else if(selectType ==='modern')
        {
            vm.bacselection = vm.selection.concat(vm.modernBacSets);
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
});
