<?php 

include "simple_html_dom.php";

class ScrapeGithubStargazers {

	private $url;
	private $pages;
	private $allUsernames = [];
	private $process 	= true;
	private $i 			= 1;

	public function __construct($url, $pages)
	{
		$this->url 		= $url;
		$this->pages 	= $pages;
		$this->allUsernames();
	}

	private function urlExists()
	{
		$curl = curl_init($this->url);
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

	private function loadUsernames()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$resp = curl_exec($ch);

		curl_close($ch);

		$html = new simple_html_dom();
		$html->load($resp);

		$outputResult = [];

		// Find all usernames 
		foreach($html->find('h3.follow-list-name') as $follow_list){
			foreach ($follow_list->find('a') as $anchor) {
				$outputResult[] = $anchor->href;
			}
		}

		return $outputResult;
	}


	private function allUsernames()
	{

		do {

			$this->url = $this->i === 1 ? $this->url : $this->url . '?page=' . $this->i;

			// if( $this->urlExists())
			// {
				$usernames = $this->loadUsernames();
				$this->allUsernames = array_merge($this->allUsernames, $usernames);
				$this->i++;
			// }
			// else 
			// {
			// 	$this->proceed = false;
			// }

		} while( $this->i <= $this->pages );

	}

	public function getAllUsernames(){
		return $this->allUsernames;
	}

}

$stargazers = new ScrapeGithubStargazers('https://github.com/ccxt/ccxt/stargazers', 3);

print_r($stargazers->getAllUsernames());