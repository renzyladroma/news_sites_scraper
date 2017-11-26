<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","abaka_db");
//$con = mysqli_connect("localhost","root","","ctifls_db");

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

		
$stmt = "SELECT t2.title as SubCategory_title, t1.title, t1.description, t1.url_photo, t1.url_video from tbl_ucontent t1
INNER JOIN tbl_sub_category t2 
ON t1.sub_category_id_fk = t2.id where t1.status = '1'";

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