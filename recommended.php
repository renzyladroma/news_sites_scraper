<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("","","","");


//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_GET['id'];
//$id = $this->input->get('id');		
$stmt1 = "SELECT t1.id, t2.source, t1.item_url, t1.headline, t1.image, t1.content, t1.fetch_date FROM rss_content t1
		INNER JOIN rssingest t2
		ON t1.item_url = t2.item_url
		WHERE DATE(t1.fetch_date) = CURDATE()
		AND t1.image NOT LIKE 'http://120.28.24.39%' AND t1.id != $id ORDER BY RAND() LIMIT 6";


$result = mysqli_query($connection, $stmt1);


$date = date("M d, Y");

if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
   $encode[] = $row;
}

}
$news_content = array(
		'date' => ($date),
        'result' => ($encode)
		);

echo json_encode($news_content);  
?>
