<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("config.php");
include("admin/view/oss.config.php");
@$act=$_GET['act'];
@$url=substr($_GET['url'],1);
date_default_timezone_set("Asia/Shanghai");
//调用阿里云OSS类库
if (is_file(__DIR__ . '/admin/view/oss/autoload.php')) {
    require_once __DIR__ . '/admin/view/oss/autoload.php';
}
use OSS\OssClient;
use OSS\Core\OssException;
if($act=='yz'){
define("CAPTCHA_ID", "b43c2590fe2e70c83965180fae9be432");
define("PRIVATE_KEY", "6cfac68dfc0144ee5b712dc6650a4de7");
class GeetestLib {
    const GT_SDK_VERSION = 'php_3.0.0';
    public static $connectTimeout = 1;
    public static $socketTimeout  = 1;
    private $response;
    public function __construct($captcha_id, $private_key) {
        $this->captcha_id  = $captcha_id;
        $this->private_key = $private_key;
        $this->domain = "http://api.geetest.com";
    }
    public function pre_process($param, $new_captcha=1) {
        $data = array('gt'=>$this->captcha_id,
                     'new_captcha'=>$new_captcha
                );
        $data = array_merge($data,$param);
        $query = http_build_query($data);
        $url = $this->domain . "/register.php?" . $query;
        $challenge = $this->send_request($url);
        if (strlen($challenge) != 32) {
            $this->failback_process();
            return 0;
        }
        $this->success_process($challenge);
        return 1;
    }
    private function success_process($challenge) {
        $challenge      = md5($challenge . $this->private_key);
        $result         = array(
            'success'   => 1,
            'gt'        => $this->captcha_id,
            'challenge' => $challenge,
            'new_captcha'=>1
        );
        $this->response = $result;
    }
    private function failback_process() {
        $rnd1           = md5(rand(0, 100));
        $rnd2           = md5(rand(0, 100));
        $challenge      = $rnd1 . substr($rnd2, 0, 2);
        $result         = array(
            'success'   => 0,
            'gt'        => $this->captcha_id,
            'challenge' => $challenge,
            'new_captcha'=>1
        );
        $this->response = $result;
    }
    public function get_response_str() {
        return json_encode($this->response);
    }
    public function get_response() {
        return $this->response;
    }
    public function success_validate($challenge, $validate, $seccode,$param, $json_format=1) {
        if (!$this->check_validate($challenge, $validate)) {
            return 0;
        }
        $query = array(
            "seccode" => $seccode,
            "timestamp"=>time(),
            "challenge"=>$challenge,
            "captchaid"=>$this->captcha_id,
            "json_format"=>$json_format,
            "sdk"     => self::GT_SDK_VERSION
        );
        $query = array_merge($query,$param);
        $url          = $this->domain . "/validate.php";
        $codevalidate = $this->post_request($url, $query);
        $obj = json_decode($codevalidate,true);
        if ($obj === false){
            return 0;
        }
        if ($obj['seccode'] == md5($seccode)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function fail_validate($challenge, $validate, $seccode) {
        if(md5($challenge) == $validate){
            return 1;
        }else{
            return 0;
        }
    }
    private function check_validate($challenge, $validate) {
        if (strlen($validate) != 32) {
            return false;
        }
        if (md5($this->private_key . 'geetest' . $challenge) != $validate) {
            return false;
        }
        return true;
    }
    private function send_request($url) {
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$socketTimeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            curl_close($ch);
            if ($curl_errno >0) {
                return 0;
            }else{
                return $data;
            }
        } else {
            $opts    = array(
                'http' => array(
                    'method'  => "GET",
                    'timeout' => self::$connectTimeout + self::$socketTimeout,
                )
            );
            $context = stream_context_create($opts);
            $data    = @file_get_contents($url, false, $context);
            if($data){ 
                return $data;
            }else{ 
                return 0;
            } 
        }
    }
    private function post_request($url, $postdata = '') {
        if (!$postdata) {
            return false;
        }
        $data = http_build_query($postdata);
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$socketTimeout);
            if (!$postdata) {
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            } else {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            $data = curl_exec($ch);
            if (curl_errno($ch)) {
                $err = sprintf("curl[%s] error[%s]", $url, curl_errno($ch) . ':' . curl_error($ch));
                $this->triggerError($err);
            }
            curl_close($ch);
        } else {
            if ($postdata) {
                $opts    = array(
                    'http' => array(
                        'method'  => 'POST',
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",
                        'content' => $data,
                        'timeout' => self::$connectTimeout + self::$socketTimeout
                    )
                );
                $context = stream_context_create($opts);
                $data    = file_get_contents($url, false, $context);
            }
        }
        return $data;
    }
    private function triggerError($err) {
        trigger_error($err);
    }
}
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
session_start();
$data = array(
		"user_id" => "test",
		"client_type" => "web",
		"ip_address" => "127.0.0.1" 
	);
$status = $GtSdk->pre_process($data, 1);
$_SESSION['gtserver'] = $status;
$_SESSION['user_id'] = $data['user_id'];
echo $GtSdk->get_response_str();
}
elseif($act=='key'){
	$key_time=substr(time(),0,8).'00';
	$result=array('code'=>'0',"key"=>MD5($url.$key_time));
	echo json_encode($result);
}
elseif($act=='down'){
{
	$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
	$options = array('response-content-type' => 'application/octet-stream');
    try {
         $signedUrl = $ossClient->signUrl($bucket,$url,120,'GET',$options);
    } catch (OssException $e) {
        return;
    }
	if($down=='off'){
		header('Location: '.$signedUrl);
	}else{
		$key_time=substr(time(),0,8).'00';
		@$key=$_GET['key'];
		if(MD5($url.$key_time)==$key){
			header('Location: '.$signedUrl);
		}else{
			echo'Illegal operation';
		}
	}
}
}
else
{
	echo "No Act!";
}
?>