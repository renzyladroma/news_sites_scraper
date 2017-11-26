<?php
set_time_limit(0);

$servername = "120.28.24.42";
$username = "root";
$password = "jfr3u9t";
$dbname = "abaka_db";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");
header("Content-Type: text/html; charset=utf-8");
$stmt = "SELECT item_url FROM rssingest WHERE source = 'Bandera' AND `update` IS NULL AND DATE(fetch_date) = CURDATE()";
$url = $connection->query($stmt);
$html2 = mysqli_real_escape_string($connection, $stmt);
	
	foreach($url as $row){
		$file = $row['item_url'];
		$html = file_get_contents($file);
		
		$title = getTitle($html);
		$image = getImage($html);
		$content = getContent($html);
		
		$connection->query("INSERT INTO rss_content(category_id, item_url, headline,image, content, source) 
		VALUES ('1', '" . $file . "','" . html_entity_decode($title) . "', '" . $image . "','" . html_entity_decode($content) . "', 'Bandera')");
		
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
   $content = str_replace('8220', '', $content);
     $content = str_replace('8221', '', $content);
  return $content;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}	

function clean3($title) {
  $title = str_replace('&#8216;', '', $title); 
  $title = str_replace(',&#8217;', '', $title);
  $title = str_replace('&#8217;', '', $title);
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