<?php

	header('Content-type: text/json');
	error_reporting(0);
	require_once("lib/config.php");

	
	try {
		$data_array = array();
		if (empty($_GET)) {
			$data_array = array('status'=>'FAILED', 'response_code'=>1);
		} else {
			$id = trim($_GET['id']);
			$sql = "SELECT t2.title as sub_category, t1.title, t1.description, t1.content, t1.url_photo, , t1.date_created, t1.created_by FROM tbl_ucontent t1
					INNER JOIN tbl_sub_category t2
					ON t1.sub_category_id_fk = t2.id
					WHERE t1.id = '$id'"; 
			if ($result = mysqli_query($connection, $sql)) {
				if (mysqli_num_rows($result) > 0) {
					//	$data_array = array('status'=>'SUCCESS', 'response_code'=>0);
				   
					while($row =mysqli_fetch_assoc($result))
					{
						$data_array['result'][] = $row;
					}
					
				} else {
					$data_array = array('status'=>'FAILED', 'response_code'=>7);
				}
			} else  {
				$data_array = array('status'=>'FAILED', 'response_code'=>8);
			}
			
			mysqli_close($connection);
		}
	} catch (Exception $e) {
		$data_array = array('status'=>'FAILED', 'response_code'=>8);
	}
	
	echo json_encode($data_array);
	

?>

