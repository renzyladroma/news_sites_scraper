<?php
header('Content-type: text/json; charset=utf-8');
error_reporting(0);
$connection = mysqli_connect("","","","");
mysqli_set_charset($connection,"utf8");
//mysqli_set_charset($connection,"utf8");

//$con = mysqli_connect("localhost","root","","ctifls_db");

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$stmt2 = "SELECT t1.id, t3.category, t2.source, t1.item_url, t1.headline, t1.image, t1.content, t1.fetch_date AS publishedAt FROM rss_content3 t1 
INNER JOIN rssingest2 t2 
INNER JOIN rss_category t3
ON t1.item_url = t2.item_url AND t1.category_id = t3.category_id WHERE t1.category_id = '3' AND t1.headline != '' AND t1.content != '' AND t1.image != '' AND t1.fetch_date >= CURDATE() ORDER BY t1.image DESC";

$result = mysqli_query($connection, $stmt2);
$date2 = '';
if (mysqli_num_rows($result) > 0) {
	$date2 = ''; 
}
else {
	$date2 = '-1';
}  
 
	
$stmt1 = "SELECT t1.id, t3.category, t2.source, t1.item_url, t1.headline, t1.image, t1.content, t1.fetch_date AS publishedAt FROM rss_content3 t1 
INNER JOIN rssingest2 t2 
INNER JOIN rss_category t3
ON t1.item_url = t2.item_url AND t1.category_id = t3.category_id WHERE t1.category_id = '3' AND t1.headline != '' AND t1.content != '' AND t1.image != '' AND t1.fetch_date >= CURDATE()$date2 ORDER BY t1.image DESC";

$result2 = mysqli_query($connection, $stmt1);


$date = date("M d, Y");

if (mysqli_num_rows($result2) > 0) {
while($row = mysqli_fetch_assoc($result2)) {
   //$encode[] = $row;
      $encode[] =  array('id'=>utf8_encode($row['id']),'category'=>utf8_encode($row['category']), 'source'=>utf8_encode($row['source']),
   'item_url'=>utf8_encode($row['item_url']),'headline'=>utf8_encode($row['headline']),'image'=>utf8_encode($row['image']),
	'content'=>$row['content'],'publishedAt'=>utf8_encode($row['publishedAt']));

}

}
$news_content = array(
		'date' => ($date),
        'result' => ($encode)
		);

echo json_encode($news_content);  
?>
