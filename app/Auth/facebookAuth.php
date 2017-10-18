<?php
namespace App\Auth;

class facebookAuth
{
	public function getMe($access_token)
	{
		$url = "https://graph.facebook.com/me?access_token=". $access_token ."&format=json&method=get";
		$data = $this->cUrl($url, "https://cloud.google.com");
		
		
		$data = json_decode($data, true);
		if (isset($data["id"]))
			return $data;
		else 
			return false;
	}

	public function getFriendCount($access_token)
	{
		$fql = "SELECT%20uid,%20name,%20sex%20FROM%20user%20WHERE%20uid%20IN%20(SELECT%20uid2%20FROM%20friend%20WHERE%20uid1%20=%20me())%20limit%205000";
		$url = "https://graph.facebook.com/v2.0/fql?access_token=". $access_token . "&q=". $fql;
		$data = $this->cUrl($url);
		$data = json_decode($data, true);

		if (!isset($data["error"]))
			return count($data["data"]);
		else
			return false;
	}

	public function getComfim($access_token)
	{
		$url = "https://graph.facebook.com/v1.0/me/friendrequests?access_token=". $access_token;
		$data = $this->cUrl($url);

		$data = json_decode($data, true);

		if (isset($data["summary"]["total_count"]))
			return $data["summary"]["total_count"];
		else
			return 0;
	}

	public function cUrl($url, $ref = "https://cloud.google.com")
	{
		$ch = curl_init($url);
         
        curl_setopt($ch, CURLOPT_URL, $url);
     	curl_setopt($ch, CURLOPT_HEADER, 0);
      	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      	curl_setopt($ch, CURLOPT_VERBOSE, true);
      	# sending cookies from file
      	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
      	curl_setopt($ch, CURLOPT_REFERER, $ref);

         $page = curl_exec($ch) or die(curl_error($ch));
        // Đóng CURL
       	curl_close($ch);
        return $page;
	}
}