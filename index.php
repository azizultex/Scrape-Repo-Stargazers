<?php

// references: 
// 1. https://elfsight.com/blog/2016/05/how-to-get-instagram-access-token/


// $url = 'https://api.github.com/users/azizultex/events/public';
// $url = "http://www.google.com/search?q=".$strSearch."&hl=en&start=0&sa=N";
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_HEADER, 0);
//   curl_setopt($ch, CURLOPT_VERBOSE, 0);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
//   curl_setopt($ch, CURLOPT_URL, urlencode($url));
//   $response = curl_exec($ch);
//   curl_close($ch);


//   var_dump($response);


// echo '<ul>';


// foreach( $data['data'] as $data){
//     echo "<li><img src=\"{$data['images']['standard_resolution']['url']}\"></li>";
// }


// echo '</ul>';

    function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }


$allData = '';

for ($i=1; $i <= 2 ; $i++) { 
	$url = i === 1 ? 'https://github.com/ccxt/ccxt/stargazers' : 'https://github.com/ccxt/ccxt/stargazers?page=' . $i;
	$result = get_web_page($url);

	if(!$result['error']){
		$allData .= $result['content'] . 'DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD';
	}
}






?>


<div>
	<?php echo $allData; ?>
</div>

    <script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>

<script type="text/javascript">

		var userIDs = [];

        // forEach method, could be shipped as part of an Object Literal/Module
        var forEach = function (array, callback, scope) {
          for (var i = 0; i < array.length; i++) {
            callback.call(scope, i, array[i]); // passes back stuff we need
          }
        };

        var myNodeList = document.querySelectorAll('.follow-list-item');
        forEach(myNodeList, function (index, value) {
            // if( index <= 2 ){
                var username = $(value).find('a.d-inline-block').attr('href');
                userIDs.push(username);

                // var request = new XMLHttpRequest();
                // var userDataLink = `https://api.github.com/users${username}/events/public`;

                // console.log(userDataLink);

                // request.open('GET', userDataLink, true);

                // request.onload = function(){
                //     var data = JSON.parse(this.response);
                //     console.log(data);
                // }

                // request.send();

            // }
        });


        console.log(userIDs);

</script>