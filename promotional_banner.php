<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("","","","");


//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

		
$stmt = "SELECT id, title, link, image_url FROM tbl_content WHERE sub_category_id_fk = '6' AND DATE(publish_date) = CURDATE()";

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
