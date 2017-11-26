<?php include('../../lib/config.php'); ?>
<?php
header("Content-Type: text/html; charset=utf-8");
$stmt = "SELECT item_url FROM rssingest WHERE source = 'GMA' AND category_id = '5' AND fetch_date >= CURDATE() AND `update` IS NULL"; //AND `update` IS NULL 
$url = $connection->query($stmt);
$html2 = mysqli_real_escape_string($connection, $stmt);
	
	foreach($url as $row){
		$file =  $row['item_url'];
		$html = file_get_contents($file);
		
		
		echo $title = html_entity_decode(getTitle($html));
		echo "<br>";
		echo $image = getImage($html);
		echo "<br>";
		echo $content = html_entity_decode(getContent($html));
		$content = clean($content);
		echo "<br><br>";
		$description = getContent($html);
		$connection->query("INSERT INTO rss_content(category_id, item_url, headline, image, description, content, source) 
		VALUES ('5', '" . $file . "','" . addslashes($title) . "', '" . $image . "', '" .addslashes($description). "', '" .addslashes($content)."', 'GMA')");
		
	}
	
function clean($content) {
	$content = str_replace('&#39;', "'", $content);
	
	
  return $content;
}	
		
function getTitle($html){
    $title;

    $split = explode('<meta property="og:title" content="',$html);

    if(count($split) > 1)
    {
    
        $end = explode('"/>', $split[1]);

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

    $split = explode('<meta property="og:image" content="',$html);

    if(count($split) > 1)
    {
    
        $end = explode('"/>', $split[1]);

        $image = $end[0];
    }
    else
    {
        return "";
    }

    return trim($image);
}
	
function getContent($html){
    $content;

    $split = explode('"main":"',$html);

    if(count($split) > 1)
    {
    
        $end = explode('<\/p>"', $split[1]);

        $content = $end[0];
    }
    else
    {
        return "";
    }
    return strip_tags($content, "<p>");
}
	
function clean3($title){
  $title = str_replace('â€', '', $title); // Replaces all spaces with hyphens.
  $title = str_replace('â€™', '', $title);
  $title = str_replace('&#039;', '', $title);
  return $title;
}
	
?>

<?php

?>