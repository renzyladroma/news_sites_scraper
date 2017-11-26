<?php
set_time_limit(0);
	$con = mysqli_connect("192.168.63.38","root","jfr3u9t","abaka_db");
	$stmt = "SELECT rss_reader_test.item_url FROM rss_reader_test WHERE rss_reader_test.source = 'Bandera' AND DATE(fetch_date) = CURDATE()";
	$url = $con->query($stmt);
	$html2 = mysqli_real_escape_string($con, $stmt); 
	//$handle = fopen($file,"r"); 
	
	foreach($url as $row){
		//$handle = fopen($file,"r"); 
		$file = $row['item_url'];
		$html = file_get_contents($file);
		
		
		$title = getTitle($html);
		$image = getImage($html);
		$content = getContent($html);
		
		// $image = getImage($html);
		//$image = imageSrc($image);
		// $content = getContent($html);
		// $content = clean($content);
		// $description = getContent($html);
		// $description = clean2($description);
		$con->query("INSERT INTO abaka_db.rss_content2(category_id, item_url, headline,image, description, content) 
		VALUES ('1', '" . $file . "','" . $title . "', '" . $image . "', '" . $description . "', '" . $content . "')");
		
	}
function clean($content) {
  $content = str_replace('<div>', '', $content); // Replaces all spaces with hyphens.
  $content = str_replace('<div "content">', '', $content);
  //$content = str_replace('</p>', '', $content);
  $content = str_replace('<em>', '', $content);
  $content = str_replace('</div>', '', $content);
  $content = str_replace('</em>', '', $content);
  //$content = str_replace('</p>', '', $content);
  $content = str_replace('<a>', '', $content);
  $content = str_replace('</a>', '', $content);
  $content = str_replace('<br />', '', $content);
  $content = str_replace('<br>', '', $content);
  $content = str_replace('<script>', '', $content);
  $content = str_replace('</script>', '', $content);
  return $content;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}	
function clean2($description) {
  $description = str_replace('<div>', '', $description); // Replaces all spaces with hyphens.
  $description = str_replace('<div "content">', '', $description);
  $description = str_replace('<p>', '', $description);
 $description = str_replace('</p>', '', $description);
  $description = str_replace('<em>', '', $description);
  $description = str_replace('</div>', '', $description);
  $description = str_replace('</em>', '', $description);
  $description = str_replace('<a>', '', $description);
  $description = str_replace('</a>', '', $description);
  $description = str_replace('<br />', '', $description);
  $description = str_replace('<br>', '', $description);
  $description = str_replace('<script>', '', $description);
  $description = str_replace('</script>', '', $description);
  $description = str_replace('<span class="element-invisible">', '', $description);
  
  return $description;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}
	
//function imageSrc($image){
//	preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $image , $result);
//	$foo = $result[1];
//	return $foo;
//}

	function getTitle($html){
		$title;
		$split = explode('<h1>',$html);

		if(count($split) > 1)
		{
		
			$end = explode('</h1>', $split[1]);

			$title = $end[0];
		}
		else
		{
			return "";
		}

		return trim($title);
	}
	
	
	function getImage($html){
		$image;
  
		$split = explode('<div id="pp_entry">',$html);

		if(count($split) > 1)
		{
			$end = explode('</div>', $split[1]);
			$split_img = explode('src="',$end[0]);
			$end2 = explode('"', $split_img[1]);
			$image = $end2[0];
			
		}
		else
		{
			return "";
		}
		return trim($image);
	}
	
	
	function getContent($html){
		$content;

		$split = explode('<div id="pp_entry">',$html);

		if(count($split) > 1)
		{
		
			$end = explode('</div>', $split[1]);

			$content = $end[0];
		}
		else
		{
			return "";
		}

		return strip_tags(trim($content), "<p>");
	}
?>