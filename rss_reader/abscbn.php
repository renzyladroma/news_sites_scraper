<?php
set_time_limit(0);

$servername = "";
$username = "";
$password = "";
$dbname = "";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");
header("Content-Type: text/html; charset=utf-8");
try{
	
		$category_id = 4;
		$source = "RAPPLER";
		$url = "http://feeds.feedburner.com/rappler/sports";
		
		
		$feed_url = "$url";
		echo "Starting to work with feed URL '" . $feed_url . "' <br><br>";
		libxml_use_internal_errors(true);
		$RSS_DOC = simpleXML_load_file($feed_url);
		if (!$RSS_DOC) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		}
		 echo $date_checker = date('Y-m-j')." 00:00:00";
		foreach($RSS_DOC->channel->item as $RSSitem){

			$item_id 	= md5($RSSitem->title);
			$fetch_date = date("Y-m-j G:i:s"); 
			$item_title = trim($RSSitem->title);
			$item_desc = trim(strip_tags($RSSitem->description, "<p>"));
			$item_date  = date("Y-m-j G:i:s", strtotime($RSSitem->pubDate));
			$item_url	= $RSSitem->link;

			echo "Processing item '" , $item_id , "' on " , $fetch_date 	, "<br/>";
			echo $item_title, " - ";
			echo $item_date, "<br/>";
			echo $item_url, "<br/>";
			echo $item_desc, "<br/>";
			echo "=============================================================================================================<br/>";
			$sql = "SELECT item_id FROM rssingest2 where item_id = '" . $item_id . "'";
			$result = $connection->query($sql);

			if($result->num_rows < 1 && $item_date >= $date_checker){
				echo "<font color=green>Inserting new item..</font><br/>";
				$item_insert_sql = "INSERT INTO rssingest2(category_id, item_id, feed_url, item_title, item_desc, item_date, item_url, fetch_date, source)
				VALUES ('$category_id', '" . $item_id . "', '" . $feed_url . "', '" . addslashes($item_title) . "', '" . addslashes($item_desc) . "', '" . $item_date . "', '" . $item_url . "', '" . $fetch_date . "', '$source') ";
				$connection->query($item_insert_sql);
				
			}else{
				echo "<font color=blue>Not inserting existing item..</font><br/>";
			}
			echo "<br/>";
		}

}catch (Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
