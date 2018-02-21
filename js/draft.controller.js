
var app = angular.module('draftApp', []);

app.controller('DraftController', function() {
    var vm = this;

    vm.sets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf", "gaf", "dp","bat","gotg","xfc", "toa", "thor"];
    vm.bacsets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf", "tmnt", "hhs", "imw", "sww", "toa", "thor"];
    vm.starterSets= ["avx", "uxm", "jl", "ygo", "bff", "aou", "wol", "asm", "fus", "cw", "wf"];
    vm.sizes= ["thumbnail","small","medium"];
    vm.selectedSet = "avx";
    vm.selectedBacSet = "avx";
    vm.size = "small";
    vm.starter = false;
	vm.packs="";
	vm.loading = false;

    vm.load = function()
	{
        vm.packs = "";
		var sl = "t";
		if(vm.size == "thumbnail") sl = "t";
		else if(vm.size == "small") sl = "s";
        else if(vm.size == "medium") sl = "m";
		vm.packs = 'http://dicecoalition.com/cardservice/draftPacks.php?set='+vm.selectedSet+'&res='+sl+'&bac='+vm.selectedBacSet+'&starter='+vm.starter;
	}

    vm.showStarterCheck = function()
    {
    	var show = false;
        if(vm.starterSets.indexOf(vm.selectedSet)!=-1) {
            show = true;
        }
        return show;
    }

});
