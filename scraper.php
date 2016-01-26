<?
// This is a template for a PHP scraper on morph.io (https://morph.io)
// including some code snippets below that you should find helpful

// require 'scraperwiki.php';
// require 'scraperwiki/simple_html_dom.php';
//
// // Read in a page
// $html = scraperwiki::scrape("http://foo.com");
//
// // Find something on the page using css selectors
// $dom = new simple_html_dom();
// $dom->load($html);
// print_r($dom->find("table.list"));
//
// // Write out to the sqlite database using scraperwiki library
// scraperwiki::save_sqlite(array('name'), array('name' => 'susan', 'occupation' => 'software developer'));
//
// // An arbitrary query against the database
// scraperwiki::select("* from data where 'name'='peter'")

// You don't have to do things with the ScraperWiki library.
// You can use whatever libraries you want: https://morph.io/documentation/php
// All that matters is that your final data is written to an SQLite database
// called "data.sqlite" in the current working directory which has at least a table
// called "data".

require 'scraperwiki.php';
function scrapePOST($url) {
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
  curl_setopt($curl, CURLOPT_POST, 1);
  // disable SSL checking to match behaviour in Python/Ruby.
  // ideally would be fixed by configuring curl to use a proper
  // reverse SSL proxy, and making our http proxy support that.
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $res = curl_exec($curl);
  curl_close($curl);
  return $res;
}

$url = "http://motavafian.beheshtm.ir/peaplesearch.php";

$context  = stream_context_create($opts);
$content = file_get_contents($url, false, $context, -1, 40000);

preg_match_all("/<td class=\"alt2\" align=\"right\">(\d*)<\/td>.*<td class=\"alt1\" align=\"right\">(.*)<\/td>.*<td class=\"alt2\" align=\"right\">(.*)<\/td>.*<td class=\"alt1\" align=\"right\">(.*)<\/td>.*<td class=\"alt2\" align=\"right\">(.*)<\/td>.*<td class=\"alt2\" align=\"right\">(\d*)<\/td>.*<td class=\"alt1\" align=\"right\">(\d*)<\/td>.*<td class=\"alt2\" align=\"right\">(\d*)<\/td>.*<td class=\"alt1\" align=\"right\">(\d*)<\/td>.*<td class=\"alt2\" align=\"right\">(.*)<\/td>/Usmi", $content, $output_array);

$amount = count($output_array[1]);

for ($i = 0; $i <= $amount; $i++)
{
  	$record = array('id'      => $output_array[1][$i],
			'fullname' => $output_array[2][$i],
			'fathername' => $output_array[3][$i], 
			'codemelli' => $output_array[4][$i], 
			'deathdate' => $output_array[5][$i], 
			'blockno' => $output_array[6][$i], 
			'partno' => $output_array[7][$i], 
			'rowno' =>  $output_array[8][$i], 
			'graveno' =>  $output_array[9][$i], 
			'nextto' =>  $output_array[10][$i]);
  
	scraperwiki::save_sqlite(array('data'), $entry);
}
