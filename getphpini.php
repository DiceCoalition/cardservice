<?php
//Utility script.  Delete from server when not needed.
//in most of the hosts, it is '/usr/local/lib/php.ini'
//here we have used the value for our localhost
$location = '/opt/users/ipg/d/i/ipg.dicecoalitioncom/php71/php.ini';
 
$default = file_get_contents($location);
echo '<pre>';
echo htmlspecialchars($default);
echo '</pre>';