<?php
namespace Engine\libraries;

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

class Social {
	public $facebook_token;
	public function __construct(){

		# GET TOKEN FACEBOOK
		if (empty($this->facebook_token)) {
			$fbapp 	= '176421082414983';
			$fbsec	= '2315869887459c2fcbfc3d99c3f134a6';
			$url 	= "https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=$fbapp&client_secret=$fbsec";
		   	$token = file_get_contents($url);
		   	$token = explode('=',$token);
		   	$this->facebook_token = $token[1];
		}
	}

	public function getUrlCurl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		var_dump($data);
		curl_close($ch);

		if($data === false)
		{
		    echo 'Curl error: ' . curl_error($ch);
		}

		return $data;
	}

	public function get_twitter($twitter) {
		if (empty ( $twitter )) {
			$status = 'Twitter Profile';
		}
		
		if (! empty ( $twitter )) {
			
			# twitter api xml url, http://php.net/manual/en/function.fopen.php
			$url = "http://twitter.com/users/show/$twitter.xml";
			
			# twitter is down or us connection is not good
			$fp = @fopen ( $url, 'r' );
			if (! $fp) {
				$status = 'maaf, untuk saat ini koneksi jaringan kami sedang bermasalah, silahkan hubungi api@networks.co.id';
			}
			
			if ($fp) {
				
				# get xml from url http://php.net/manual/en/function.stream-get-contents.php
				# http://www.php.net/manual/en/function.simplexml-load-string.php
				$xml = simplexml_load_string ( stream_get_contents ( $fp ) );
				fclose ( $fp );
				
				# get the status text from xml
				$status = $xml->status->text . ' - ' . strftime ( "%A, %d %B %Y at %X ", strtotime ( $xml->status->created_at ) );
			}
		}
		
		return $status;
	}
	
	public function get_yahoo($yahoo_id) {
		# get the yahoo id
		if (preg_match ( "/([a-zA-Z0-9_\s]{6,30})@yahoo.com/", $yahoo_id, $matches )) {
			$yahoo_id = $matches [1];
		}
		
		if (empty ( $yahoo_id )) {
			$status = 'Yahoo Messenger';
		}
		
		if (! empty ( $yahoo_id )) {
			$url = "http://opi.yahoo.com/online?u=" . $yahoo_id . "&m=t";
			$fp = @fopen ( $url, 'r' );
			
			if (! $fp) {
				$status = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
			}
			
			if ($fp) {
				$content = stream_get_contents ( $fp );
				$online = "$yahoo_id is ONLINE";
				if ($content == $online) {
					$status = $yahoo_id . 'Sedang online.';
				} else {
					$status = 'Sedang tidak online.';
				}
			}
		}
		return $status;
	}
	
	public function getFacebookPageEdit($pageID, $limit = 1) {
		
		if (empty ( $pageID )) {
			$message = 'Facebook Pages';
		}

		if (! empty ( $pageID )) {
			$url = "https://graph.facebook.com/" . $pageID . "/feed?access_token=$this->facebook_token&limit=$limit";
			$fp = @fopen ( $url, 'r' );
			
			if (! $fp) {
				$message = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
			}
			
			if ($fp) {
				$json = stream_get_contents ( $fp );
				$jsonData = json_decode ( $json );
				
				if (! empty ( $jsonData->data ['0']->message )) {
					$message = $jsonData->data ['0']->message;
				
				}
				if (! empty ( $jsonData->error->message )) {
					$message = $jsonData->error->message;
				}
				
				# a link
				if (! empty ( $jsonData->data ['0']->description )) {
					$count = strlen ( $jsonData->data ['0']->description );
					if ($count >= 100) {
						$message = substr ( $jsonData->data ['0']->description, 0, 100 ) . ' <a href="' . $jsonData->data ['0']->link . '">' . l ( 'more...' ) . '</a>';
					}
					if ($count <= 100) {
						$message = $jsonData->data ['0']->description;
					}
				} 

				# empty
				if (empty ( $jsonData->data ['0']->description ) && empty ( $jsonData->data ['0']->message )) {
					$message = 'Status, Ok. but there is no content to fetch.';
				}
			}
		}
		return $message;
	}
	
	public function getYahooProfile($yahoo_id) {

		if (preg_match ( "/([a-zA-Z0-9_\s]{6,30})@yahoo.com/", $yahoo_id, $matches )) {
			$yahoo_id = $matches [1];
		}

		$url = "http://opi.yahoo.com/online?u=" . $yahoo_id . "&m=t";
		$fp = @fopen ( $url, 'r' );
		if (! $fp) {
			$status = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {
			$content = stream_get_contents ( $fp );
			$online = "$yahoo_id is ONLINE";
			if ($content == $online) {
				$status = "Yahoo! Messenger $yahoo_id Sedang online.";
			} else {
				$status = 'Sedang tidak online.';
			}
		}
		
		return $status;
	}
	
	public function getTwitterProfile($twitter = NULL) {
		# twitter api xml url, http://php.net/manual/en/function.fopen.php
		$url = "http://twitter.com/users/show/$twitter.xml";
		
		# twitter is down or us connection is not good
		$fp = @fopen ( $url, 'r' );
		if (!$fp) {
			$status = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {
			# get xml from url http://php.net/manual/en/function.stream-get-contents.php
			# http://www.php.net/manual/en/function.simplexml-load-string.php
			$xml = simplexml_load_string ( stream_get_contents ( $fp ) );
			fclose ( $fp );
			
			# get the status text from xml
			$status = $xml->status->text . ' - ' . strftime ( "%A, %d %B %Y at %X ", strtotime ( $xml->status->created_at ) );
		}
		return $status;
	}
	
	public function getFacebookPageStatus($pageID = NULL, $limit = 1) {
		$url = "https://graph.facebook.com/" . $pageID . "/feed?access_token=$this->facebook_token&limit=$limit";
		$fp = @fopen ( $url, 'r' );
		
		if (!$fp) {
			$message = 'maaf, untuk saat ini koneksi jaringan kami dengan Facebook sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {
			$json = stream_get_contents ( $fp );
			$jsonData = json_decode ( $json );
			if (! empty ( $jsonData->data ['0']->message )) {
				$message = $jsonData->data ['0']->message;
			
			}
			if (! empty ( $jsonData->error->message )) {
				$message = $jsonData->error->message;
			}

			# a link
			if (! empty ( $jsonData->data ['0']->description )) {
				$count = strlen ( $jsonData->data ['0']->description );
				if ($count >= 100) {
					$message = substr ( $jsonData->data ['0']->description, 0, 100 ) . 
					' <a href="' . $jsonData->data ['0']->link . '">' . l ( 'more...' ) . '</a>';
				}
				if ($count <= 100) {
					$message = $jsonData->data ['0']->description;
				}
			}
			if (empty ( $jsonData->data ['0']->description ) && empty ( $jsonData->data ['0']->message )) {
				$message = 'Sorry, no news right now. meanwhile, please follow our facebook.';
			}
		}
		return $message;
	}
	
	# hanya untuk developer ( blm pake auth juga bisa )
	public function getFacebookPageData($pageID = NULL) {
		$url = "http://graph.facebook.com/" . $pageID;
		$fp = @fopen ( $url, 'r' );
		
		if (! $fp) {
			$data = 'maaf, untuk saat ini koneksi jaringan kami dengan Facebook sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {
			$json = stream_get_contents ( $fp );
			$jsonData = json_decode ( $json );
			if ($jsonData) {
				foreach ( $jsonData as $key => $value ) {
					$data [$key] = $value;
				}
			}
		}
		#var_dump($data);die();
		return $data;
	}

	public function getTwitterData($username = NULL){
		$url = "http://api.twitter.com/1/users/show.json?screen_name=". $username;
		$fp = @fopen($url, 'r');

		if (!$fp) {
			$data = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
		}

		if ($fp) {
			$json = stream_get_contents($fp);
			$jsonData = json_decode($json);
			if ($jsonData) {	
				foreach ($jsonData as $key => $value) {
					$data[$key] = $value;
				}
			}
		}
	return $data;
	}

	function twitterSearch($search){
		$url = "http://search.twitter.com/search.json?rpp=100&
		callback=netcoid-".md5($search)."&q=".$search;
		
		$fp = @fopen ( $url, 'r' );

		if (!$fp) {
			$data = 'maaf, untuk saat ini koneksi jaringan kami dengan Twitter sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {

			$json = stream_get_contents($fp);

			# PAKE ARRAY LEBIH HEMAT MEMORY TAPI OBJECT LEBIH CEPAT (DALAM MICRO) SO DOESNT REALLY MATTERS
			$data = json_decode($json,TRUE);

			# GET RECENT TWITTER - 1 HOUR
			# http://stackoverflow.com/questions/6247674/return-all-the-array-between-one-hour-via-php
			$data['results'] = array_filter($data['results'], array($this,"filterWithinHourTW"));

			# COMPARE DATA
			# http://stackoverflow.com/questions/6138023/time-minus-time-time-seconds-in-php/6138184#6138184
			if (!empty($data['results'])) {

				# JIKA LEBIH DARI SATU RESULTSNYA ( BANDINGIN HARUS 2 ) 
				if (count($data['results']) != 1) {
					$lastarray = count($data['results'])-1;
					$time = strtotime($data['results']['0']['created_at']) - strtotime($data['results'][$lastarray]['created_at']);

					# TWITTER / HOUR
					$data['tweetperhour'] =  ceil(( $lastarray / $time ) * 60 * 60);
				}

				if (count($data['results']) == 1) {
					$data['tweetperhour'] = 1;
				}

			}

			# IF DATA EMPTY
			if (empty($data['results'])) {
				$data['tweetperhour'] = 0;
			}
		}
	
	# RETURNS THE DATA
	return $data;
	}

	function facebookSearch($search){
		
		# no call back karena sebenrnya untuk js tp twitter dipake biar bisa banyak fetchnya?
		# @todo check ulang
		$url = 'http://graph.facebook.com/search/?&limit=30&q='.$search;
		
		$fp = @fopen ( $url, 'r' );

		if (!$fp) {
			$data = 'maaf, untuk saat ini koneksi jaringan kami dengan Facebook sedang bermasalah, silahkan hubungi api@networks.co.id';
		}
		
		if ($fp) {

			$json = stream_get_contents($fp);
			$data = json_decode($json,TRUE);
			
			# FILTER DATA
			$data['data'] = array_filter($data['data'], array($this,"filterWithinHourFB"));
			
			# COMPARE DATA
			if (!empty($data['data'])) {

				# JIKA LEBIH DARI SATU RESULTSNYA ( BANDINGIN HARUS 2 ) 
				if (count($data['data']) != 1) {							
					$lastarray = count($data['data'])-1;
					$time = strtotime($data['data']['0']['created_time']) - strtotime($data['data'][$lastarray]['created_time']);

					# FACEBOOK / HOUR
					$data['postperhour'] =  ceil(( $lastarray / $time ) * 60 * 60);
				}

				if (count($data['data']) == 1) {			
					$data['postperhour'] = 1;
				}
			}

			# IF EMPTY
			if (empty($data['data'])) {
				$data['postperhour'] = 0;
			}
		}
	return $data;
	}

	function filterWithinHourTW($array){
		return (strtotime($array['created_at']) > strtotime('-1 hour'));
	}
	function filterWithinHourFB($array){
		return (strtotime($array['created_time']) > strtotime('-1 hour'));
	}
}

?>