<?php

error_reporting(0);
$connection = mysqli_connect("192.168.63.38","root","jfr3u9t","abaka_db");
$base_url = $_SERVER['DOCUMENT_ROOT'];
session_start();
$sub_category_id_fk = $_REQUEST['sub_category_id_fk'];
$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
$content = $_REQUEST['content'];
$url_photo = $_REQUEST['url_photo'];
//$url_video = $_REQUEST['url_video'];
$created_by	= $_SESSION['fb_id'];
$date_created = date('Y-m-d H:i:s');

$file_name = "";
$file_size = "";
$file_tmp = "";
$file_type = "";
$url = "http://115.85.17.57:8001/abaka/uploads/";
$rename = date('Ymdhis');
   if(isset($_FILES['image_url'])){
      $errors= array();
      $file_name = $_FILES['image_url']['name'];
      $file_size = $_FILES['image_url']['size'];
      $file_tmp = $_FILES['image_url']['tmp_name'];
      $file_type = $_FILES['image_url']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image_url']['name'])));
      $expensions= array("jpeg","jpg","png");
      
	 $tmp=$_FILES["image_url"]["tmp_name"];
     $extension = explode("/", $_FILES["image_url"]["type"]);
     $name = $rename.".".$extension[1];
	  
	  
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
		
		 $filename = $url.$name;
         move_uploaded_file($file_tmp, "../../uploads/".$name);
         $sql = "INSERT INTO tbl_ucontent (sub_category_id_dk, title, description, content, url_photo,created_by, date_created)
							VALUES ('$sub_category_id_fk','$title','$description','$content','$image_url', '$created_by', '$date_created')";
		 if ($connection->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $connection->error;
		}
		
		header("Location: ../../index.php?status=1");
      }else{
        header("Location: ../../index.php?status_error=1");
      }
   }	
	
	
	

?>