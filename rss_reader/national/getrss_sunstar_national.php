<?php


//require_once("dbCon/dbcon.php");

$db_hostname="192.168.63.38:3306";
$db_username="root";
$db_password="jfr3u9t";
//$dbname = "abaka_db";

$private_access_key="1234";
$feed_url="http://www.sunstar.com.ph/rss/local-news";




try
{
	
	// $db = getCon();

	$db = mysql_connect($db_hostname,$db_username,$db_password);
	if (!$db)
	{
		die("Could not connect: " . mysql_error());
	}
	mysql_select_db("your_db", $db);

	echo "Starting to work with feed URL '" . $feed_url . "'";

	$RSS_DOC = simpleXML_load_file('http://www.sunstar.com.ph/rss/local-news');

	libxml_use_internal_errors(true);
	$RSS_DOC = simpleXML_load_file($feed_url);
	if (!$RSS_DOC) {
		echo "Failed loading XML\n";
		foreach(libxml_get_errors() as $error) {
			echo "\t", $error->message;
		}
	}


	$rss_title = $RSS_DOC->channel->title;
	$rss_link = $RSS_DOC->channel->link;
	$rss_editor = $RSS_DOC->channel->managingEditor;
	$rss_copyright = $RSS_DOC->channel->copyright;
	$rss_date = $RSS_DOC->channel->pubDate;

    

	foreach($RSS_DOC->channel->item as $RSSitem)
	{

		$item_id 	= md5($RSSitem->title);
		$fetch_date = date("Y-m-j G:i:s"); 
		$item_title = $RSSitem->title;
		$item_date  = date("Y-m-j G:i:s", strtotime($RSSitem->pubDate));
		$item_url	= $RSSitem->link;

		echo "Processing item '" , $item_id , "' on " , $fetch_date 	, "<br/>";
		echo $item_title, " - ";
		echo $item_date, "<br/>";
		echo $item_url, "<br/>";

		//Only insert if new item...
		$item_exists_sql = "SELECT item_id FROM abaka_db.rssingest where item_id = '" . $item_id . "'";
		$item_exists = mysql_query($item_exists_sql, $db);
		if(mysql_num_rows($item_exists)<1)
		{
			echo "<font color=green>Inserting new item..</font><br/>";
			$item_insert_sql = "INSERT INTO abaka_db.rssingest(category_id, item_id, feed_url, item_title, item_date, item_url, fetch_date, source)
			VALUES ('2', '" . $item_id . "', '" . $feed_url . "', '" . $item_title . "', '" . $item_date . "', '" . $item_url . "', '" . $fetch_date . "', 'SunStar') ";
			$insert_item = mysql_query($item_insert_sql, $db);
		}
		else
		{
			echo "<font color=blue>Not inserting existing item..</font><br/>";
		}

		echo "<br/>";
	}


} catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>


