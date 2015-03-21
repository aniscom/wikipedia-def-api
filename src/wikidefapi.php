
<?php 	
 header('Content-Type: application/json');
ini_set('display_errors', false);

require_once("simplehtmldom_1_5/simple_html_dom.php");
$title=strtolower ($_GET["title"]);
$lang=strtolower($_GET["lang"]);
$url="http://$lang.wikipedia.org/wiki/$title";
//$html = file_get_html($url);
//$content        = file_get_contents($url);


  $html=file_get_html($url);
foreach($html->find('sup') as $element) {
$element->innertext = '';
$element->id = null;
$element->class = null;
$element->style = null;
}

foreach($html->find('a') as $element) {
$element->href = null;
$element->title = null;

}



// Find all images 
/*foreach($html->find('img') as $element) {
	   
	   $img="<img src='".$element->src ."'/>";
	}
*/


  $doc = new DOMDocument();
  @$doc->loadHTML($html);


  $xpath = new DOMXPath($doc);
  $query = $xpath->query("//div[@id='mw-content-text']/p");
 
 
 
//echo $html;
  $i=0;
  foreach($query as $node)
  {
	  $i++;
	  if ($i==1){
      $out = new DOMDocument();
 
      foreach($node->childNodes as $child)
      {
		  
          $inner = $out->importNode($child, true);
          $out->appendChild($inner);
      }
 
     //echo $out->saveHTML();
	  	  }else break;


$arr = array(
	'ApiName' => 'WikiDef_ver_1',
	'title' => $title,
	'lang' => $lang,
  	'content' => $out->saveHTML(), 
	
	);

   echo json_encode($arr);


  }

  
?>