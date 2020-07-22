<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("../pass.config.php");
@$Cookie=$_COOKIE['Admin_' . $user];
if(!isset($Cookie) || $Cookie != $pass){
	header('Location: ../login.php');
}
include("../oss.config.php");
@$ListUrl=$_GET['ListUrl'];
    function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
	if(strstr($endpoint,"https://")==false){
		$Bucket = str_replace('http://','http://'.$bucket.'.',$endpoint);
	}else{
		$Bucket = str_replace('https://','https://'.$bucket.'.',$endpoint);
	}
    $callbackUrl = 'http://www.fcy999.com/?GET';
    $dir = $ListUrl;
	
    $callback_param = array('callbackUrl'=>$callbackUrl, 
                 'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}', 
                 'callbackBodyType'=>"application/x-www-form-urlencoded");
    $callback_string = json_encode($callback_param);

    $base64_callback_body = base64_encode($callback_string);
    $now = time();
    $expire = 300;
    $end = $now + $expire;
    $expiration = gmt_iso8601($end);
    $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
    $conditions[] = $condition; 
    $start = array(0=>'starts-with', 1=>'$Key', 2=>$dir);
    $conditions[] = $start; 
    $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
    $policy = json_encode($arr);
    $base64_policy = base64_encode($policy);
    $string_to_sign = $base64_policy;
    $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $accessKeySecret, true));
    $response = array();
    $response['accessid'] = $accessKeyId;
    $response['host'] = $Bucket;
    $response['policy'] = $base64_policy;
    $response['signature'] = $signature;
    $response['expire'] = $end;
    $response['callback'] = $base64_callback_body;
    $response['dir'] = $dir;
    echo json_encode($response);