<?php
set_time_limit(0);

$servername = "";
$username = "";
$password = "";
$dbname = "";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");
try{
	$url_sql = "SELECT * FROM rss_feed_url WHERE status = 1";
	$url_result = $connection->query($url_sql);
	
	foreach($url_result as $url_row){
		$category_id = $url_row['category_id'];
		$source = $url_row['source'];
		$url = $url_row['url'];
		
		
		$feed_url = "$url";
		echo "$source - Starting to work with feed URL '" . $feed_url . "'";
		libxml_use_internal_errors(true);
		$RSS_DOC = simpleXML_load_file($feed_url);
		if (!$RSS_DOC) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		}
		$date_checker = date("Y-m-j 00:00:00",strtotime("-1 day"));
		foreach($RSS_DOC->channel->item as $RSSitem){

			$item_id 	= md5($RSSitem->title);
			$fetch_date = date("Y-m-j G:i:s"); 
			$item_title = trim($RSSitem->title);
			$item_date  = date("Y-m-j G:i:s", strtotime($RSSitem->pubDate));
			$item_url	= $RSSitem->link;

			echo "Processing item '" , $item_id , "' on " , $fetch_date 	, "<br/>";
			echo $item_title, " - ";
			echo $item_date, "<br/>";
			echo $item_url, "<br/>";

			$sql = "SELECT item_id FROM rssingest where item_id = '" . $item_id . "'";
			$result = $connection->query($sql);

			if($result->num_rows < 1 && $item_date >= $date_checker){
				echo "<font color=green>Inserting new item..</font><br/>";
				$item_insert_sql = "INSERT INTO rssingest(category_id, item_id, feed_url, item_title, item_date, item_url, fetch_date, source)
				VALUES ('$category_id', '" . $item_id . "', '" . $feed_url . "', '" . $item_title . "', '" . $item_date . "', '" . $item_url . "', '" . $fetch_date . "', '$source ') ";
				$connection->query($item_insert_sql);
				
			}else{
				echo "<font color=blue>Not inserting existing item..</font><br/>";
			}
			echo "<br/>";
		}
	}

}catch (Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
