var myApp = angular.module('packApp', []);

myApp.controller("PackCtrl", function($scope, $location, $window) {
	var pp = this;
    
	var json = $location.search();
	var packString = json.pack;
	var pickString = json.pick;
	
	pp.packArray = [];
	pp.pickArray = [];
	pp.packToSend = "";
	pp.packYouGot = "";
	pp.selection = "";
	
	if(typeof(packString) != "undefined")
		pp.packArray = packString.split(";");
	if(typeof(pickString) != "undefined")
		pp.pickArray = pickString.split(";");
	
	if(pp.packArray.length == 14 && pp.pickArray.length == 0){
		pp.pickArray.push(pp.packArray[0]);
		pp.pickArray.push(pp.packArray[1]);
		pp.packArray.splice(0, 2);
	}
	
    $scope.$watch('location.search()', function() {        
		pp.picks = ($location.search()).picks;
	
		pp.pack = ($location.search()).pack; 
    }, true);

    pp.changeCards = function(name) {
        $location.search('cards', name);
    }
	
	pp.getImageUrl = function(card){
		var setexp = /[A-Z]/gi;
		var numexp = /[0-9]/g;
		var set = card.match(setexp).join("");
		var num = card.match(numexp).join("");
		var url = "http://dp.dicecoalition.com/Image.php?set="+set+"&cardnum="+num+"&res=s";
		return url;
	}
	
	pp.onClick = function(card){
		if(pp.selection != ""){
			var index = pp.pickArray.indexOf(card);
			pp.pickArray.splice(index, 1);
		}
		pp.selection = card;
		pp.pickArray.push(card);
		pp.packToSend = "";
		for(var i =0; i < pp.packArray.length; i++){
			if(pp.packArray[i] != pp.selection)
				pp.packToSend+= pp.packArray[i] +";";
		}
		if(pp.packToSend.endsWith(";"))
			pp.packToSend = pp.packToSend.substr(0, pp.packToSend.length -1);
	}
	
	pp.goToNextPage = function(){
		var url = "http://dp.dicecoalition.com/pack.html#?pack="+pp.packYouGot+"&pick="+pp.pickArray.join(";");
		$window.open(url, '');
	}
});