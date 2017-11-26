<?php
set_time_limit(0);
header('Content-type: text/json');
	error_reporting(0);
$connection = mysqli_connect("120.28.24.42","root","jfr3u9t");

$image_update = "UPDATE abaka_db.rss_content SET rss_content.image = 'http://pinasngayon.cdu.com.ph/uploads/pinas.png' WHERE rss_content.image NOT LIKE 'http://%'";

$result = mysqli_query($connection, $image_update);

?> 