<?php 

include "simple_html_dom.php";

function url_exists($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_NOBODY, true);
	$result = curl_exec($curl);
	if ($result !== false) 
	{
	  $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
	  if ($statusCode == 404) 
	  {
	    return false;
	  }
	  else
	  {
	    return true;
	  } 
	}
	else
	{
	  return false;
	}
}

function load_usernames($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$resp = curl_exec($ch);

	curl_close($ch);

	$html = new simple_html_dom();
	$html->load($resp);

	$outResult = [];

	// Find all usernames 
	foreach($html->find('h3.follow-list-name') as $follow_list){
		foreach ($follow_list->find('a') as $anchor) {
			$outResult[] = $anchor->href;
		}
	}

	return $outResult;

}


$allUsernames = [];
$proceed = true;
$i = 1;

do {
	$url = i === 1 ? 'https://github.com/ccxt/ccxt/stargazers' : 'https://github.com/ccxt/ccxt/stargazers?page=' . $i;

	if( url_exists($url) ) // url_exists($url)
	{
		$usernames = load_usernames($url);
		// $allUsernames[] = $usernames;
		$allUsernames = array_merge($allUsernames, $usernames);
		$i++;
	}
	else 
	{
		$proceed = false;
	}

} while( $proceed == true );


print_r($allUsernames);
