<?php
header('Content-type: text/json');
error_reporting(0);
$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","abaka_db");
//$con = mysqli_connect("localhost","root","","ctifls_db");

//Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql_11 = "SELECT content FROM tbl_content WHERE sub_category_id_fk IN ('2', '3', '4') AND publish_time = 11 AND publish_date = DATE(NOW())";
$sql_4 = "SELECT content FROM tbl_content WHERE sub_category_id_fk IN ('2', '3', '4') AND publish_time = 4 AND publish_date = DATE(NOW())";
$sql_9 = "SELECT content FROM tbl_content WHERE sub_category_id_fk IN ('2', '3', '4') AND publish_time = 9 AND publish_date = DATE(NOW())";

$result_11 = mysqli_query($connection, $sql_11);
$result_4 = mysqli_query($connection, $sql_4);
$result_9 = mysqli_query($connection, $sql_9);

if (mysqli_num_rows($result_11) > 0) {
		
		while($row10 = mysqli_fetch_assoc($result_11)){
			$explode = count(explode(",", $row10['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row10['content']);
				$Digit6_11 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row10['content']);
				$Digit3_11 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row10['content']);
				$Digit2_11 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
		}
		$am_11 = array('6-digit'=>$Digit6_11, '3-digit'=>$Digit3_11, '2-digit'=>$Digit2_11);	

		while($row4 = mysqli_fetch_assoc($result_4)){
			$explode = count(explode(",", $row4['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row4['content']);
				$Digit6_4 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row4['content']);
				$Digit3_4 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row4['content']);
				$Digit2_4 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
		
		}
		$pm_4 = array('6-digit'=>$Digit6_4, '3-digit'=>$Digit3_4, '2-digit'=>$Digit2_4);
	
		
		while($row6 = mysqli_fetch_assoc($result_9)){
			$explode = count(explode(",", $row6['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row6['content']);
				$Digit6_9 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row6['content']);
				$Digit3_9 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row6['content']);
				$Digit2_9 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
}

		$pm_9 = array('6-digit'=>$Digit6_9, '3-digit'=>$Digit3_9, '2-digit'=>$Digit2_9);
		//$date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
		$date = date("M d, Y");
		$result = array(
		'date' => ($date),
        'result' => array($am_11,$pm_4,$pm_9)
		);
		
	     echo json_encode($result);	
		

/* if ($result_11 || result_4) {     
	if (mysqli_num_rows($result_11) > 0) {
		
		while($row10 = mysqli_fetch_assoc($result_11)){
			$explode = count(explode(",", $row10['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row10['content']);
				$Digit6_11 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row10['content']);
				$Digit3_11 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row10['content']);
				$Digit2_11 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
		}
		
		while($row4 = mysqli_fetch_assoc($result_4)){
			$explode = count(explode(",", $row4['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row4['content']);
				$Digit6_4 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row4['content']);
				$Digit3_4 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row4['content']);
				$Digit2_4 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
		}
		
		while($row6 = mysqli_fetch_assoc($result_9)){
			$explode = count(explode(",", $row6['content']));
			if($explode == 6){
				$explode_01 = explode(",", $row6['content']);
				$Digit6_9 = array('Digit1'=>$explode_01[0],'Digit2'=>$explode_01[1],'Digit3'=>$explode_01[2],'Digit4'=>$explode_01[3],'Digit5'=>$explode_01[4],'Digit6'=>$explode_01[5]);
				
			}elseif($explode == 3){
				$explode_02 = explode(",", $row6['content']);
				$Digit3_9 = array('Digit1'=>$explode_02[0],'Digit2'=>$explode_02[1],'Digit3'=>$explode_02[2]);
			}else{
				$explode_03 = explode(",", $row6['content']);
				$Digit2_9 = array('Digit1'=>$explode_03[0],'Digit2'=>$explode_03[1]);
				
			}
		}
		
		
		$Digit6_11 = array($Digit6_11);
		$Digit3_11 = array($Digit3_11);
		$Digit2_11 = array($Digit2_11);
		
		$Digit6_4 = array($Digit6_4);
		$Digit3_4 = array($Digit3_4);
		$Digit2_4 = array($Digit2_4);
		
		$Digit6_9 = array($Digit6_9);
		$Digit3_9 = array($Digit3_9);
		$Digit2_9 = array($Digit2_9);
	
		$data_array1['result6_11am'] = $Digit6_11;
		$data_array2['result3_11am'] = $Digit3_11;	
		$data_array3['result2_11am'] = $Digit2_11;
		
		$data_array4['result6_4pm'] = $Digit6_4;
		$data_array5['result3_4pm'] = $Digit3_4;	
		$data_array6['result2_4pm'] = $Digit2_4;
		
		$data_array7['result6_9pm'] = $Digit6_9;
		$data_array8['result3_9pm'] = $Digit3_9;	
		$data_array9['result2_9pm'] = $Digit2_9;
		
		echo json_encode($data_array1);	
		echo ("\n");
		echo json_encode($data_array2);	
		echo ("\n");
		echo json_encode($data_array3);	
		echo ("\n");
		echo json_encode($data_array4);	
		echo ("\n");
		echo json_encode($data_array5);
		echo ("\n");
		echo json_encode($data_array6);	
		echo ("\n");
		echo json_encode($data_array7);
		echo ("\n");
		echo json_encode($data_array8);	
		echo ("\n");
		echo json_encode($data_array9);	
	}else{
		$result= array('status_code' => '404' , 'message' => 'No data found' );
		echo $final_result = json_encode($result);
	}    
	
	 */
}    

?>