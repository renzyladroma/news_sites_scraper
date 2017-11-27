<?php
set_time_limit(0);

$servername = "";
$username = "";
$password = "";
$dbname = "";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");
header("Content-Type: text/html; charset=utf-8");
$stmt = "SELECT item_url FROM rssingest WHERE source = 'Hataw' AND `update` IS NULL AND DATE(fetch_date) = CURDATE()";
$url = $connection->query($stmt);
$html2 = mysqli_real_escape_string($connection, $stmt);
	
	foreach($url as $row){
		$file = $row['item_url'];
		$html = file_get_contents($file);
		
		
		$title = getTitle($html);
		$image = getImage($html);
		$content = getContent($html);
		
		
		$connection->query("INSERT INTO abaka_db.rss_content(category_id, item_url, headline,image, content, source) 
		VALUES ('1', '" . $file . "','" . html_entity_decode($title) . "', '" . $image . "', '" . html_entity_decode($content) . "', 'Hataw')");
		 
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
  $content = str_replace('nbsp', '', $content);
  $content = str_replace('<p>(adsbygoogle = windowadsbygoogle  )push()</p>', '', $content);
  $content = str_replace('<p></p><p>(adsbygoogle = windowadsbygoogle  )push()</p>', '', $content);
  $content = str_replace('(adsbygoogle = windowadsbygoogle  )push()</p><p>(adsbygoogle = windowadsbygoogle  )push()</p>', '', $content);
  return $content;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}	

function clean3($title) {
  $title = str_replace('&#8216;', '', $title); 
  $title = str_replace(',&#8217;', '', $title);
  $title = str_replace('&#8217;', '', $title);
  $title = str_replace('â€', '', $title); // Replaces all spaces with hyphens.
  $title = str_replace('â€™', '', $title);
  $title = str_replace('â€”', '', $title);
  $title = str_replace('&#039;', '', $title); 
  $title = str_replace('&#038;', '', $title); 
  $title = str_replace('â€œ', '', $title); 

  //$content = str_replace('</p>', '', $content);
  return $title;
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
		$split = explode('<h1 class="post-title entry-title" >',$html);

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
		//$title = getTitle($html);
		//echo $title . "<br />";
	
	
	function getImage($html){
		$image;
  
		$split = explode('<div class="single-post-thumb">',$html);

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
	 //$image = getImage($html);
	//echo $image . "<br />";
	
	
		function getContent($html){
		$content = "";

		$split = explode('<p>',$html);
		if(count($split) > 1)
		{
			for($i=1; $i<count($split)-1; $i++ ){
				$end = explode('</p>', $split[$i]);
				$content.= "<p>".$end[0]."</p>";
			}
		}
		else
		{
			return "";
		}

		//return trim($content);
		return strip_tags(trim($content), "<p>");
	}
	 //$content = getContent($html);
	//echo $content . "<br />";
	

?>
