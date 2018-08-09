var myApp = angular.module('packApp', ['ngCookies']);

myApp.controller("PackCtrl", ['$http', '$scope', '$location', '$window','$cookies', function($http, $scope, $location, $window, $cookies) {
	var pp = this;
    
	var json = $location.search();
	var packString = json.pack;
	var pickString = json.pick;
	var channel = json.channel;
	var myName = getName();
	
	pp.CLIENT_ID = 'cXdiFTzPpMnd5mpl';
	if(typeof(channel) != "undefined"){
		pp.CLIENT_ID = channel;	
		initChatRoom();
	}
	else{
		$http.get('channel.php') 
		 .success(function(result)
		{
			pp.CLIENT_ID = result;
			initChatRoom();
		})
		  .error(function(data, status)
		{
			$log.log(status);
		});		
	}

	var draftPacks = [];
	pp.players = {1 : myName, 2:"", 3:"", 4:"", 5:"", 6:"", 7:"", 8:""};
	pp.playerNumber = 0;
	pp.rainbow = "";
	pp.packArray = [];
	pp.pickArray = [];
	pp.packToSend = "";
	pp.packYouGot = [];
	pp.selection = "";
	pp.draftMessages = [];	
	pp.playerCount= 1;
	pp.donePlayers = [];
	pp.botCount = 0;
	pp.botPlayerNums = [];
	pp.botPicks = [];
	pp.botPacks = [];
	
	if(typeof(packString) != "undefined"){
		var draftPacksString = atob(packString);
		playerInit(draftPacksString);
		setPlayerNumber(1);
	}	

	pp.connectedPlayers = 1;
	
	
	function playerInit(draftPacksString){
		
		draftPacks = draftPacksString.split("#");
		pp.playerCount = draftPacks.length -1;
		
		var cardRainbowString = "";		
		for(var i = 1; i < draftPacks.length; i++){			
			var cards = draftPacks[i].substring(2).split(";");
			for(var j = 2; j < cards.length; j++)
				cardRainbowString +=cards[j]+";";
		}
		pp.rainbow = 'rainbow.php?cards='+cardRainbowString;
	}
	
	function setPlayerNumber(number) {
		if(pp.playerNumber != number){
			pp.playerNumber = number;
			
			packString = draftPacks[number].substring(2);
			pp.packArray = packString.split(";");
			if(pp.packArray.length == 14 && pp.pickArray.length == 0){
				pp.pickArray.push(pp.packArray[0]);
				pp.pickArray.push(pp.packArray[1]);
				pp.packArray.splice(0, 2);
			}
			//$scope.$digest();
		}
	}
	
    $scope.$watch('location.search()', function() {        
		pp.picks = ($location.search()).picks;
	
		pp.pack = ($location.search()).pack; 
    }, true);
	

    pp.changeCards = function(name) {
        $location.search('cards', name);
    }
	
	
	pp.setPlayerNumber = function(number) {
		if(pp.playerNumber != number){
			pp.playerNumber = number;
			
			packString = draftPacks[number].substring(2);
			pp.packArray = packString.split(";");
			if(pp.packArray.length == 14 && pp.pickArray.length == 0){
				pp.pickArray.push(pp.packArray[0]);
				pp.pickArray.push(pp.packArray[1]);
				pp.packArray.splice(0, 2);
			}
			$scope.$digest();
		}
	}
	
	pp.setPlayerCookie = function(number){
		if(typeof(number) != 'undefined')
		{
			var expireDate = new Date();
			expireDate.setHours(expireDate.getHours()+1);
			$cookies.put('playerNumber', number, {'expires': expireDate});
		}
	}
	 
	pp.getImageUrl = function(card){
		var setexp = /[A-Z]/gi;
		var numexp = /[0-9]/g;
		var set = card.match(setexp).join("");
		var num = card.match(numexp).join("");
		var url = "http://dp.dicecoalition.com/Image.php?set="+set+"&cardnum="+num+"&res=m";
		return url;
	}
	
var chatPlayerNumber = 0;
let members = [];
	
function initChatRoom(){	
	const drone = new ScaleDrone(pp.CLIENT_ID, {
	  data: { // Will be sent out as clientData via events
		name: myName,
		color: getRandomColor(),
	  },
	});
	
	pp.addBots = function(){
		pp.botCount = pp.playerCount - pp.connectedPlayers;
		for(var i =0; i < pp.botCount; i++){
			var name = getRandomBotName();
			drone.publish({
				room: 'observable-room',
				message: "#b:"+name,
			 });
		}
	}
	
	pp.onClick = function(card){
		if(pp.selection != ""){
			var index = pp.pickArray.length-1;
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
		
		if(pp.pickArray.length == 14){
			$cookies.remove('packArray');
		    $cookies.remove('incomingPacks');	
		    $cookies.remove('picks');	
			drone.publish({
			room: 'observable-room',
			message: "#d:Finished my draft: http://www.dicecoalition.com/cardservice/pack.html#?pick="+pp.pickArray.join(';'),
		  });
		}
	}
	
	pp.sendPack = function(){
		pp.selection = "";
		  if (pp.packToSend === "") {
			return;
		  }		  
		  var targetPlayer = pp.playerNumber +1;
		  if(targetPlayer > pp.playerCount)
			  targetPlayer = 1;
		  drone.publish({
			room: 'observable-room',
			message: "#"+targetPlayer+":"+pp.packToSend,
		  });
		  pp.draftMessages.push("#"+targetPlayer+":"+pp.packToSend);
		  pp.packArray= [];		  
		  if(pp.packYouGot.length > 0){
			  pp.packArray = pp.packYouGot[0].split(";");
			  pp.packYouGot.splice(0, 1);
			  //$scope.$digest();
		  }
		  var expireDate = new Date();
			expireDate.setMinutes(expireDate.getMinutes()+1);
			
		  $cookies.put('packArray', pp.packArray.join(";"), {'expires': expireDate});
		  $cookies.put('incomingPacks', pp.packYouGot.join("|"), {'expires': expireDate});	
		  $cookies.put('picks', pp.pickArray.join(";"), {'expires': expireDate});	
	}
	
	function sendMessage() {
	  const value = DOM.input.value;
	  if (value === '') {
		return;
	  }
	  DOM.input.value = '';
	  drone.publish({
		room: 'observable-room',
		message: value,
	  });
	}
	
	function addMember(member){
		members.push(member);
		updateMembersDOM();
		pp.connectedPlayers = members.length;
		if(pp.playerNumber == 1){
			var pNumToSend = 0;
			for(var i = 2; i <= draftPacks.length; i++){
				if(pp.players[i] === "")
				{
					pp.players[i] = member.clientData.name;
					pNumToSend = i;
					break;
				}
			}	
		    if(member.id != "bot"){
				drone.publish({
					room: 'observable-room',
					message: "#c:"+draftPacksString,
				  });
				drone.publish({
					room: 'observable-room',
					message: "#p:"+pNumToSend,
				});
			}
			else{
				pp.botPlayerNums.push(pNumToSend);
				var botPackString = draftPacks[pNumToSend].substring(2);
				var botPackArray = botPackString.split(";");
				var botpickArray = [];
					botpickArray.push(botPackArray[0]);
					botpickArray.push(botPackArray[1]);
					botPackArray.splice(0, 2);				
				var cards = draftPacks[pNumToSend-1];
				pp.botPacks.push(botPackArray.join(";"));
				pp.botPicks.push(botpickArray.join(";"));
			}
		  /*pp.draftMessages.forEach(function(element) {
			  drone.publish({
				room: 'observable-room',
				message: element,
			  });
			  
			});*/
		}
		$scope.$digest();
	}
	drone.on('open', error => {
	  if (error) {
		return console.error(error);
	  }
	  console.log('Successfully connected to Scaledrone');

	  const room = drone.subscribe('observable-room');
	  room.on('open', error => {
		if (error) {
		  return console.error(error);
		}
		console.log('Successfully joined room');
	  });

	  room.on('members', m => {
		members = m;
		updateMembersDOM();
		pp.connectedPlayers = members.length;
		$scope.$digest();
	  });

	  room.on('member_join', member => {
		addMember(member);
	  });

	  room.on('member_leave', ({id}) => {
		const index = members.findIndex(member => member.id === id);
		var name = members[index].clientData.name;
		if(pp.playerNumber == 1){
			for(var i = 2; i <= draftPacks.length; i++){
					if(pp.players[i] === name)
					{
						pp.players[i] = "";				
						break;
					}
				}
		}
		members.splice(index, 1);
		updateMembersDOM();		
		var doneDisconnectedPlayers = 0;
		//check how many players have finished and disconnected
		for(var i = 0; i < pp.donePlayers.length; i++){
			var pIndex = members.findIndex(member => member.clientData.name ===  pp.donePlayers[i]);
			if(pIndex == -1)
				doneDisconnectedPlayers += 1;
		}
		//count done players who left as still connected so drafting may continue
		pp.connectedPlayers = members.length + doneDisconnectedPlayers;
		$scope.$digest();
	  });

	  room.on('data', (text, member) => {
		if (member) {
			if(text.charAt(0) != '#'){
				addMessageToListDOM(text, member);
			}
			else{
			  //init message with all cards
			  if(text.charAt(1) === 'c'){
				  var cards = text.substring(3);
				  playerInit(cards);
			  }
			  //player number assignment message sent by player 1
			  else if(text.charAt(1) === 'p' && pp.playerNumber === 0){
				  var playerString = text.split(":")[1];
				  var playerNum = parseInt(playerString);			  
				  setPlayerNumber(playerNum);				  
				  var picks = $cookies.get('picks');
				  if(picks){
					  pp.pickArray = picks.split(";");
					  pp.packArray = [];
					  pp.packYouGot = [];
					  var packs = $cookies.get('packArray');
					  if(packs)
						  pp.packArray = packs.split(";");
					  var incoming = $cookies.get('incomingPacks');
					  if(incoming)
						  pp.packYouGot = $incoming.split("|");	
					  
				  }		
				  $scope.$digest();				  
			  }
			  //player done message.
			  else if(text.charAt(1) === 'd'){
				  addMessageToListDOM(text.substring(3), member);
				  //todo: player 
				  pp.donePlayers.push(member.clientData.name);
			  }
			  //bot added message
			  else if(text.charAt(1) ==='b'){
				  var botName = text.substring(3);
				  var member = {
					  "id": "bot",
					  "clientData":{ // Will be sent out as clientData via events
						"name": botName,
						"color": getRandomColor(),
					  }
				  };
				  addMember(member);
			  }
			  //passed draft pack messages
			  else{		  
				  var targetPlayer = parseInt(text.charAt(1));
				  if(pp.playerNumber == 1){
					  pp.draftMessages.push(text);
				  }
				  if(targetPlayer == pp.playerNumber){
					  pp.packYouGot.push(text.substring(3));
					  if(pp.packArray.length == 0){
						  pp.packArray = pp.packYouGot[0].split(";");
						  pp.packYouGot.splice(0, 1);
						  $scope.$digest();
					  }
				  }
				  else if(pp.botPlayerNums.indexOf(targetPlayer) >-1 ){
					  var index = pp.botPlayerNums.indexOf(targetPlayer);					  						
						var botPackArray = pp.botPacks[index].split(";");
						var botpickArray = pp.botPicks[index].split(";");
							botpickArray.push(botPackArray[0]);							
							botPackArray.splice(0, 1);
						if(botPackArray.length > 0){
							var nextPlayer = targetPlayer +1;
						  if(nextPlayer > pp.playerCount)
							  nextPlayer = 1;
						  drone.publish({
							room: 'observable-room',
							message: "#"+nextPlayer+":"+botPackArray.join(";")
						  });
						}
						if(botPackArray.length == 1){
							botpickArray.push(botPackArray[0]);
							drone.publish({
								room: 'observable-room',
								message: "Bot finished its draft: http://www.dicecoalition.com/cardservice/pack.html#?pick="+botpickArray.join(";"),
							  });
						}
						pp.botPicks[index] = botpickArray.join(";");
						pp.botPacks[index] = text.substring(3);
				  }
			  }
			}
		} else {
		  // Message is from server
		}
	  });
	});

	drone.on('close', event => {
	  console.log('Connection was closed', event);
	});

	drone.on('error', error => {
	  console.error(error);
	});

	//------------- DOM STUFF

	const DOM = {
	  membersCount: document.querySelector('.members-count'),
	  membersList: document.querySelector('.members-list'),
	  messages: document.querySelector('.messages'),
	  input: document.querySelector('.message-form__input'),
	  form: document.querySelector('.message-form'),
	};

	DOM.form.addEventListener('submit', sendMessage);





	function createMemberElement(member) {
	  const { name, color } = member.clientData;
	  const el = document.createElement('div');
	  el.appendChild(document.createTextNode(name));
	  el.className = 'member';
	  el.style.color = color;
	  return el;
	}

	function updateMembersDOM() {
	  DOM.membersCount.innerText = `${members.length} users in room:`;
	  DOM.membersList.innerHTML = '';
	  members.forEach(member =>
		DOM.membersList.appendChild(createMemberElement(member))
	  );
	}

	function createMessageElement(text, member) {
	  const el = document.createElement('div');
	  el.appendChild(createMemberElement(member));
	  el.appendChild(document.createTextNode(text));
	  el.className = 'message';
	  return el;
	}

	function addMessageToListDOM(text, member) {
	  const el = DOM.messages;
	  const wasTop = el.scrollTop === el.scrollHeight - el.clientHeight;
	  el.appendChild(createMessageElement(text, member));
	  if (wasTop) {
		el.scrollTop = el.scrollHeight - el.clientHeight;
	  }
	}

}
function getRandomName() {
  const adjs = ["autumn", "hidden", "bitter", "misty", "silent", "empty", "dry", "dark", "summer", "icy", "delicate", "quiet", "white", "cool", "spring", "winter", "patient", "twilight", "dawn", "crimson", "wispy", "weathered", "blue", "billowing", "broken", "cold", "damp", "falling", "frosty", "green", "long", "late", "lingering", "bold", "little", "morning", "muddy", "old", "red", "rough", "still", "small", "sparkling", "throbbing", "shy", "wandering", "withered", "wild", "black", "young", "holy", "solitary", "fragrant", "aged", "snowy", "proud", "floral", "restless", "divine", "polished", "ancient", "purple", "lively", "nameless"];
  const nouns = ["waterfall", "river", "breeze", "moon", "rain", "wind", "sea", "morning", "snow", "lake", "sunset", "pine", "shadow", "leaf", "dawn", "glitter", "forest", "hill", "cloud", "meadow", "sun", "glade", "bird", "brook", "butterfly", "bush", "dew", "dust", "field", "fire", "flower", "firefly", "feather", "grass", "haze", "mountain", "night", "pond", "darkness", "snowflake", "silence", "sound", "sky", "shape", "surf", "thunder", "violet", "water", "wildflower", "wave", "water", "resonance", "sun", "wood", "dream", "cherry", "tree", "fog", "frost", "voice", "paper", "frog", "smoke", "star"];
  return (
    adjs[Math.floor(Math.random() * adjs.length)] +
    "_" +
    nouns[Math.floor(Math.random() * nouns.length)]
  );
}

function getRandomBotName() {
  
  const nouns = ["Pinhead", "Chucky", "FreddyKruger", "Jason", "Leatherface", "AshySlashy", "MichaelMyers", "Candyman", "Jigsaw", "NormanBates", "HannibalLector", "Pennywise", "Pumpkinhead","Frankenstein","Dracula","CptSpalding","Babadook","DrJekyl","Imhotep","NormanBates","Lestat", "Wolfman","Nosferatu", "Sadako", "VincentPrice","TheTallMan","Leprechaun", "Predator","Xenomorph","Jaws","Godzilla","KingKong", "JoeBobBriggs"];
  return (
    "bot" +
    "_" +
    nouns[Math.floor(Math.random() * nouns.length)]
  );
}

function getName() {
	var name = $cookies.get('playerName');
  if(typeof(name) == 'undefined'){
	name = getRandomName();
  }
    var person = prompt("Please enter your name:", name);
    if (person == null || person == "") {
        txt = "User cancelled the prompt.";
    } else {
        name = person;
    }  
 $cookies.put('playerName', name);	
  return name;
}

function getPlayerNumber() {  
  return members.length;
}

function getRandomColor() {
  return '#' + Math.floor(Math.random() * 0xFFFFFF).toString(16);
}


}]);