<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","cms_db");
//$con = mysqli_connect("localhost","root","","ctifls_db");

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

		
$stmt = "SELECT title, content FROM content WHERE category_id IN ('147', '151', '155', '162', '166', '170', '174', '178', '182') AND DATE(publish_date) = CURDATE()";

$result = $connection->query($stmt);

$encode = array();
$date = date("M d, Y");

while($row = mysqli_fetch_assoc($result)) {
   $encode[] = $row;
}


$result2 = array(
		'date' => ($date),
        'result' => ($encode)
		);
		

echo json_encode($result2);  
?>