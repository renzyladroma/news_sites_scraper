<?php
header('Content-type: text/json');
	error_reporting(0);
$connection = mysqli_connect("120.28.24.42","root","jfr3u9t", "abaka_db");
	
	

$sql = "UPDATE rssingest SET `update` = '1' WHERE `update` IS NULL";
$result = mysqli_query($connection, $sql);

$update_philstar = "UPDATE rss_content
SET image='http://pinasngayon.cdu.com.ph/uploads/pinas.png'
WHERE source='Philippine Star' AND (image='http://www.philstar.com/sites/all/themes/philstar_default/images/fb-share-default.jpg' OR image='http://www.philstar.com/sites/all/themes/psn_default/images/psn-new-logo-square-blue-border.jpg');";
$result_update = mysqli_query($connection, $update_philstar);

?>