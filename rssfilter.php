<?php
$html = "";
$url = "http://www.youtube.com/feeds/videos.xml?channel_id=UCTEgsJOd5tTtYOB2JkQyI4w";
$xml = simplexml_load_file($url);
print_r($xml);
for($j = 0; $j < $numItems; $i++){
 $entry = $xml->entry[j];
 echo $entry->link->channel->title;
 $numItems = count($entry->link->channel->item);
 echo "Items: ".$numItems;
 for($i = 0; $i < $numItems; $i++){
	$title = $entry->link->channel->item[$i]->title;
	if(strstr($title, 'Dice Masters', true)){ 
		echo $title;   		
    		//$link = $xml->channel->item[$i]->link;
    		//$description = $xml->channel->item[$i]->description;
    		//$pubDate = $xml->channel->item[$i]->pubDate;

        	//$html .= "<a href='$link'><h3>$title</h3></a>";
    		//$html .= "$description";
    		//$html .= "<br />$pubDate<hr />";
	}
 }
}
echo $xml;
?>
