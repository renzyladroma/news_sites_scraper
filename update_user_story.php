<?php

	header('Content-type: text/json');
	error_reporting(0);
	require_once("lib/config.php");
	
	
		try {
			$data_array = array();
			if (empty($_GET)) {
				$data_array = array('status'=>'FAILED', 'response_code'=>1);
			} else {
				
			$id						= trim($_GET['id']);	
			$sub_category_id_fk		= trim($_GET['sub_category_id_fk']);
			$title  				= trim($_GET['title']);
			$description 			= trim($_GET['description']);
			$content   				= trim($_GET['content']);
			$url_photo  			= trim($_GET['url_photo']);
			$url_video  			= trim($_GET['url_video']);
			$created_by  			= trim($_GET['created_by']);
			$date_updated  			= date('Y-m-d H:i:s');
				
				if ($title == "" || $description == "" || $content == "" || $url_photo == "") {
					$data_array = array('status'=>'FAILED', 'response_code'=>1);
				} else {
					$sql = "UPDATE tbl_ucontent
					SET sub_category_id_fk = '$sub_category_id_fk', title = '$title', description = '$description', content = '$content', url_photo = '$url_photo', url_video = '$url_video', date_updated = '$date_updated' 
					WHERE id = '$id' AND status = '0';";

					if ($result_check = mysqli_query($connection, $sql)) {
						$data_array = array('status'=>'SUCCESS', 'response_code'=>0);
					} else  {
						$data_array = array('status'=>'FAILED', 'response_code'=>8);
					}
					
					mysqli_close($connection);
				}
			}
		} catch (Exception $e) {
			$data_array = array('status'=>'FAILED', 'response_code'=>8);
		}
		
		echo json_encode($data_array);
	
	

?>