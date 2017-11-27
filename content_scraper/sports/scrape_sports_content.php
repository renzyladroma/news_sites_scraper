<?php
set_time_limit(0);

$servername = "";
$username = "";
$password = "";
$dbname = "";

$connection = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($connection,"utf8");
header("Content-Type: text/html; charset=utf-8");
$stmt = "SELECT item_url FROM rssingest WHERE category_id = '4' AND source = 'Philippine Star' AND `update` IS NULL AND fetch_date >= CURDATE()"; //AND update IS NULL
$url = $connection->query($stmt);
$html2 = mysqli_real_escape_string($connection, $stmt);
	
	foreach($url as $row){
		
		$file =  $row['item_url'];
		$html = file_get_contents($file);
		//Title
		$title = getTitle($html);
		$title = clean3($title);
		//Image
		$image = getImage($html);
		$image = imageSrc($image);
		$content = getContent($html);
		$content = clean($content);
		$description = getContent($html);
		$description = clean2($description);
		
		$connection->query("INSERT INTO rss_content(category_id, item_url, headline,image, description, content, source) 
		VALUES ('4', '" . $file . "','". $title ."', '" . $image . "', '" .$description. "', '" .$content. "', 'Philippine Star')");
	}
	
function clean($content) {
  $content = str_replace('<div>', '', $content); // Replaces all spaces with hyphens.
  $content = str_replace('<div "content">', '', $content);
  $content = str_replace('("ca-pub-1876439796539993");', '', $content);
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
  $content = str_replace('<span class="element-invisible">', '', $content);
  $content = str_replace('pagematch: 1,', '', $content);
  $content = str_replace('GA_googleFetchAds();', '', $content);
  $content = str_replace('<script type="text/javascript">', '', $content);
  $content = str_replace('<script type="text/javascript"', '', $content);
  $content = str_replace('src="http://partner.googleadservices.com/gampad/google_service.js">', '', $content);
  $content = str_replace('GS_googleAddAdSenseService', '', $content);
  $content = str_replace('<div id=', '', $content);
  $content = str_replace('"block-philstar-ad-template-article-bottom"', '', $content);
  $content = str_replace('class=', '', $content);
  $content = str_replace('"block block-philstar-ad">', '', $content);
  $content = str_replace('<div class="content">', '', $content);
  $content = str_replace('GA_googleFillSlot', '', $content);
  $content = str_replace('("PStar_Sports_Medallion_300x250");', '', $content);
  $content = str_replace('"PStar_Sports_Medallion_300x250");', '', $content);
  $content = str_replace('("ca-pub-1876439796539993");', '', $content);
  $content = str_replace('GA_googleAddSlot', '', $content);
  $content = str_replace('sectionmatch: 1', '', $content);
  $content = str_replace('</span>', '', $content);
  $content = str_replace('GS_googleEnableAllServices();', '', $content);
  $content = str_replace('Sportshub ( Article MRec ),', '', $content);
  $content = str_replace('("ca-pub-1876439796539993",', '', $content);
  $content = str_replace('<div "content">', '', $content);
  return $content;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}	
	function clean2($description) {
  $description = str_replace('<div>', '', $description); // Replaces all spaces with hyphens.
  $description = str_replace('<div "content">', '', $description);
  $description = str_replace('<p>', '', $description);
 $description = str_replace('</p>', '', $description);
 $description = str_replace('<h2>', '', $description);
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
  $description = str_replace('pagematch: 1,', '', $description);
  $description = str_replace('GA_googleFetchAds();', '', $description);
  $description = str_replace('<script type="text/javascript">', '', $description);
  $description = str_replace('<script type="text/javascript"', '', $description);
  $description = str_replace('src="http://partner.googleadservices.com/gampad/google_service.js">', '', $description);
  $description = str_replace('GS_googleAddAdSenseService', '', $description);
  $description = str_replace('<div id=', '', $description);
  $description = str_replace('"block-philstar-ad-template-article-bottom"', '', $description);
  $description = str_replace('class=', '', $description);
  $description = str_replace('"block block-philstar-ad">', '', $description);
  $description = str_replace('<div class="content">', '', $description);
  $description = str_replace('GA_googleFillSlot', '', $description);
  $description = str_replace('("PStar_Sports_Medallion_300x250");', '', $description);
  $description = str_replace('"PStar_Sports_Medallion_300x250");', '', $description);
  $description = str_replace('GA_googleAddSlot', '', $description);
  $description = str_replace('sectionmatch: 1', '', $description);
  $description = str_replace('</span>', '', $description);
  $description = str_replace('GS_googleEnableAllServices();', '', $description);
  $description = str_replace('Sportshub ( Article MRec ),', '', $description);
  $description = str_replace('("ca-pub-1876439796539993");', '', $description);
  $description = str_replace('("ca-pub-1876439796539993",', '', $description);
  return $description;
   //return preg_replace('/[^A-Za-z0-9\-]/', '', $content); // Removes special chars.
}
	
function imageSrc($image){
	preg_match('%<img.*?src=["\'](.*?)["\'].*?/>%i', $image , $result);
	$foo = $result[1];
	return $foo;
}

function getTitle($html)
{
    $title;

    $split = explode('<h1 class="title" id="page-title">',$html);

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
	// $title = getTitle($html);
	// echo $title . "<br />";
	
	
	function getImage($html)
{
    $image;

    $split = explode('<div class="field-item even">',$html);

    if(count($split) > 1)
    {
    
        $end = explode('</div>', $split[1]);

        $image = $end[0];
    }
    else
    {
        return "";
    }

    return trim($image);
}
	// $image = getImage($html);
	// echo $image . "<br />";
	
	
	function getContent($html)
{
    $content;

    $split = explode('<div class="field-item even" property="content:encoded">',$html);

    if(count($split) > 1)
    {
    
        $end = explode('</div>', $split[1]);

        $content = $end[0];
    }
    else
    {
        return "";
    }
	return strip_tags($content, "<p>");
    //return trim($content);
}
	// $content = getContent($html);
	// echo $content . "<br />";
	
		function clean3($title) {
  $title = str_replace('â€', '', $title); // Replaces all spaces with hyphens.
  $title = str_replace('â€™', '', $title);
  $title = str_replace('&#039;', '', $title);  return $title;
		}
?>
