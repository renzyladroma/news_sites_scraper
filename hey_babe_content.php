<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","cms_db");
//$con = mysqli_connect("localhost","root","","ctifls_db");

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

		
$stmt1 = "SELECT content FROM content WHERE category_id = '386' AND DATE(publish_date) = CURDATE()";


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