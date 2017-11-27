<?php

	header('Content-type: text/json');
	error_reporting(0);
	$connection = mysqli_connect(","","","");
	
	try {
		$data_array = array();
		if (empty($_GET)) {
			$data_array = array('status'=>'FAILED', 'response_code'=>1);
		} else {
			$fb_id = $_GET['fb_id'];
		$first_name = $_GET['first_name'];
		$last_name = $_GET['last_name'];
		$gender = $_GET['gender'];
		$date_of_birth = $_GET['user_birthday'];
		$email = $_GET['email'];
		$timestamp = date('Y-m-d H:i:s');
		
			$sql = "INSERT INTO tbl_fe_user (fb_id, first_name, last_name, gender, date_of_birth, email, date_joined) 
							VALUES ('$fb_id','$first_name', '$last_name', '$gender', '$date_of_birth', '$email', '$timestamp')"; 
			if ($result = mysqli_query($connection, $sql)) {
				if (mysqli_num_rows($result) > 0) {
					$data_array = array('status'=>'SUCCESS', 'response_code'=>0);
				   
					while($row =mysqli_fetch_assoc($result))
					{
						$data_array['result'][] = $row;
					}
					
				} else {
					$data_array = array('status'=>'SUCCESS', 'response_code'=>0);
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

