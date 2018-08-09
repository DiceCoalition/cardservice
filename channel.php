<?php
$indexString = file_get_contents('lastIndex.txt');
$index = (int)$indexString;
$roomIDs = ['cXdiFTzPpMnd5mpl','0Uzkq9Cb7JvkeaP6', 'wCfKJzIJcslTQIlI', 'K4mUtHjgcHzUXJua', 'D7hof1MPvm9RcPtH','apJxrH05M3geivLs', 'McUJrFPAujjT8ZlB', 'gC5uKleIvLgyjkbQ','D2qkdGOq5rajFMFV', 'CUoqHu1ky08c461L'];
$returnID = $roomIDs[$index++];
if($index == 10){
	$index = 0;
}
file_put_contents('lastIndex.txt', $index);

echo $returnID;
?>