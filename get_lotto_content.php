<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("","","","");


//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$stmt2 = "SELECT TRIM(TRAILING 'Ds s unofficial, also see outlets.' FROM content) as lotto_content from content WHERE category_id = '121' AND DATE(publish_date) = CURDATE()";

$result = mysqli_query($connection, $stmt2);
$date2 = '';
if (mysqli_num_rows($result) > 0) {
	$date2 = ''; 
}
else {
	$date2 = '-1';
}  

	
$stmt1 = " SELECT TRIM(TRAILING 'Ds s unofficial, also see outlets.' FROM content) as lotto_content from content WHERE category_id = '121' AND DATE(publish_date) = CURDATE()$date2";

$result2 = mysqli_query($connection, $stmt1);


$date = date("M d, Y");

if (mysqli_num_rows($result2) > 0) {
while($row = mysqli_fetch_assoc($result2)) {
   $encode[] = $row;

}

}
$news_content = array(
		'date' => ($date),
        'result' => ($encode)
		);

echo json_encode($news_content);  
?>
