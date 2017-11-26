<?php include('config/config.php'); ?>
<?php 
	$id = $_REQUEST['id'];
	define('UPLOAD_DIR', '../tabloid_uploads/');
	$img = $_POST['data'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = date('Ymd').uniqid(). '.png';
	$success = file_put_contents(UPLOAD_DIR.$file, $data);
	
	if (!is_dir(UPLOAD_DIR) or !is_writable(UPLOAD_DIR)) {
    // Error if directory doesn't exist or isn't writable.
	echo "directory isn't writable.";
	}else{
		$link = "http://115.85.17.57:8001/abaka/tabloid_uploads/".$file;
		
		$sql = "UPDATE rss_content SET image='$link', flag = '1' WHERE id=$id";
		if ($con->query($sql) === TRUE) {
			echo "$link";
		} else {
			echo "Error updating record: " . $con->error;
		}
		
	}
?>