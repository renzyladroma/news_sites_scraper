<?php
set_time_limit(0);

$servername = "120.28.24.42";
$username = "root";
$password = "jfr3u9t";
$dbname = "abaka_db";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");

header("Content-Type: text/html; charset=utf-8");

$stmt = "SELECT item_url, category_id FROM rssingest WHERE source = 'Manila Times' AND fetch_date >= CURDATE()"; //AND `update` IS NULL 
$url = $connection->query($stmt);
$html2 = mysqli_real_escape_string($connection, $stmt);
	
	foreach($url as $row){
		$file =  $row['item_url'];
		$category_id =  $row['category_id'];
		$html = file_get_contents($file);
		
		$title = html_entity_decode(getTitle($html));
		$image = "";
		$content = html_entity_decode(getContent($html));
		$content = clean($content);
		$description = getContent($html);
		
		echo $title."<br/>";
		echo $image."<br/>";
		echo $content."<br/>";


		//Check Article
		$check_article_sql = "SELECT headline FROM rss_content where headline = '".addslashes($title)."'";
		$result_article = $connection->query($check_article_sql);
		
		if($result_article->num_rows < 1){
			$connection->query("INSERT INTO rss_content(category_id, item_url, headline, image, description, content, source) 
			VALUES ('$category_id', '" . $file . "','" . addslashes($title) . "', '" . $image . "', '" .addslashes($description). "', '" .addslashes($content)."', 'Manila Times')");

			echo "$title is inserted <br>";
		}else{
			echo "$title is already existing <br>";
		}
		echo "<br/>==========================================================================================================================================<br/><br/>";
	}
	
function clean($content) {
	$content = str_replace('&#39;', "'", $content);
	
	
  return trim($content);
}

		
function getTitle($html){
    $title;

    $split = explode('<meta property="og:title" content="',$html);

    if(count($split) > 1)
    {
    
        $end = explode('"', $split[1]);

        $title = $end[0];
		$title = str_replace('&#039;', "’", $title);
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
    
        $end = explode('"', $split[1]);

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

    $split = explode('<!-- .post-header -->',$html);

    if(count($split) > 1)
    {
    
        $end = explode('<!-- .post-content -->', $split[1]);
		$end2 = $end[0];
		$tags = array("div", "img", "style", "a");
		$content = preg_replace('#<(' . implode( '|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $end2);
		$content = strip_tags($content, "<p>");
    }
    else
    {
        return "";
    }
    return trim($content);
}
	
function clean3($title){
  $title = str_replace('â€', '', $title); // Replaces all spaces with hyphens.
  $title = str_replace('â€™', '', $title);
  $title = str_replace('&#039;', '', $title);
  return $title;
}
	
?>
