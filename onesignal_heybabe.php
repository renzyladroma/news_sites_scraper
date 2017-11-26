<?php //include('functions/config.php'); ?>
<?php
header('Content-Type: application/json');

?>
<?php

$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","cms_db");


if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$stmt1 = "SELECT content FROM content WHERE category_id = '386' AND DATE(publish_date) = CURDATE()";
//$stmt2 = "SELECT image FROM rss_content WHERE category_id = '1' AND fetch_date = '2017-04-04 06:39:37' LIMIT 1";
$result1 = mysqli_query($connection, $stmt1);


$content = "";
if (mysqli_num_rows($result1) > 0) {
	while($row = mysqli_fetch_assoc($result1)) {
		//$headline = $row['headline'];
		$content = $row['content'];
	}
}


$response = sendMessage($content);
$return["allresponses"] = $response;
$return = json_encode( $return);

print("\n\nJSON received:\n");
print($return);
print("\n");
 

function sendMessage($content){


	$heading = array(
				"en" => "Message from Babe:"
				);
				
	$content = array(
				"en" => "$content"
				);
	 
	$fields = array(
	'app_id' => "8bee4513-e55e-4be1-937f-849761d03aeb",
	//'big_picture' => $image,
	'included_segments' => array('All'),
	'data' => array("foo" => "bar"),
	'headings' => $heading,
	'large_icon' => "http://115.85.17.57:8001/abaka/uploads/logo.png",
	'contents' => $content
	);

	$fields = json_encode($fields);
	print("\nJSON sent:\n");
	print($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
	'Authorization: Basic YjM4ODYyMjAtZGNmOS00ZWQ1LWI1MmMtYWY0NzhjOTIxMThm'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);

	return $response;
}

?>