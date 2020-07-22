<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("pass.config.php");
@$Cookie=$_COOKIE['Admin_' . $user];
if(!isset($Cookie) || $Cookie != $pass){
	header('Location: ../login.php');
}
include("oss.config.php");
@$act=$_GET['act'];
date_default_timezone_set("Asia/Shanghai");
//调用阿里云OSS类库
if (is_file(__DIR__ . '/oss/autoload.php')) {
    require_once __DIR__ . '/oss/autoload.php';
}
use OSS\OssClient;
use OSS\Core\OssException;
use OSS\Model\CorsConfig;
use OSS\Model\CorsRule;
if($act=='AdminOss'){
function getFilesize($num){
   $p = 0;
   $format='bytes';
   if($num>0 && $num<1024){
     $p = 0;
     return number_format($num).' '.$format;
   }
   if($num>=1024 && $num<pow(1024, 2)){
     $p = 1;
     $format = 'KB';
  }
  if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
    $p = 2;
    $format = 'MB';
  }
  $num /= pow(1024, $p);
  return number_format($num, 3).' '.$format;
}
	try {
	    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
		@$listUrl=$_GET['list'];
	    $options = array('prefix' => $listUrl);
	    $listObjectInfo = $ossClient->listObjects($bucket,$options);
		$prefixlist = $listObjectInfo->getPrefixList();
	    $objectList = $listObjectInfo->getObjectList();
		if (!empty($prefixlist)) {
        	foreach ($prefixlist as $prefixInfo) {
				$Wjj_Name=str_replace($listUrl,'',$prefixInfo->getPrefix());
				$list[]=[
				'type' => 'wjj',
				'name' =>$Wjj_Name,
				'size' => '',
				'time' => ''
				];
        	}
    	}
    	if (!empty($objectList)) {
	        foreach ($objectList as $objectInfo) {
				$Wj_Name=str_replace($listUrl,'',$objectInfo->getKey());
				if($Wj_Name !='' ){
				$Wj_Size=getFilesize($objectInfo->getSize());
				$Wj_Time=date("Y-m-d H:i",strtotime($objectInfo->getLastModified())) ;
				$list[]=[
				'type' => 'wj',
				'name' =>$Wj_Name,
				'size' =>$Wj_Size,
				'time' =>$Wj_Time
				];
				}
        	}
    	}
		$result=['code' =>'0','msg' =>'获取成功','data' => $list];
		echo json_encode($result);
	} catch (OssException $e) {
	    print $e->getMessage();
	}
}
elseif($act=='cors'){
$corsConfig = new CorsConfig();
$rule = new CorsRule();
$rule->addAllowedHeader("*");
$rule->addAllowedOrigin("*");
$rule->addAllowedMethod("POST");
$rule->setMaxAgeSeconds(0);
$corsConfig->addRule($rule);
try{
    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    $ossClient->putBucketCors($bucket, $corsConfig);
} catch(OssException $e) {
    printf(__FUNCTION__ . ": FAILED\n");
    printf($e->getMessage() . "\n");
    return;
}
echo 'OK';
}
elseif($act=='del'){
try{
    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    $ossClient->deleteObject($bucket, @$_GET['name']);
} catch(OssException $e) {
    printf(__FUNCTION__ . ": FAILED\n");
    printf($e->getMessage() . "\n");
    return;
}
echo 'OK';
}
elseif($act=='down'){
{
	$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
	$options = array('response-content-type' => 'application/octet-stream');
    try {
         $signedUrl = $ossClient->signUrl($bucket,@$_GET['name'],120,'GET',$options);
    } catch (OssException $e) {
        return;
    }
	header('Location: '.$signedUrl);
}
}
elseif($act=='Save'){
	@$name=$_POST['name'];
	@$fname=$_POST['fname'];
	@$url=$_POST['url'];
	@$keywords=$_POST['keywords'];
	@$description=$_POST['description'];
	@$down=$_POST['down'];
	@$gonggao=$_POST['gonggao'];
	$Handle=fopen($_SERVER['DOCUMENT_ROOT']."/config.php",'w');
	$Data='<?php'."\n".'$name = "'.$name.'";'."\n".'$fname = "'.$fname.'";'."\n".'$keywords = "'.$keywords.'";'."\n".'$url = "'.$url.'";'."\n".'$description = "'.$description.'";'."\n".'$down = "'.$down.'";'."\n".'$gonggao = "'.$gonggao.'";';
	fwrite($Handle,$Data);
	fclose($Handle);
	
}
elseif($act=='OssSave'){
	@$bucket=$_POST['bucket'];
	@$endpoint=$_POST['endpoint'];
	@$accessKeyId=$_POST['accessKeyId'];
	@$accessKeySecret=$_POST['accessKeySecret'];
	$Handle=fopen("oss.config.php",'w');
	$Data='<?php'."\n".'$bucket = "'.$bucket.'";'."\n".'$endpoint = "'.$endpoint.'";'."\n".'$accessKeyId = "'.$accessKeyId.'";'."\n".'$accessKeySecret = "'.$accessKeySecret.'";';
	fwrite($Handle,$Data);
	fclose($Handle);
	
}
elseif($act=='PassSave'){
	@$j_pass=MD5($_POST['pass'].'$$Www.Amoli.Co$$');
	@$j_user=$_POST['user'];
	@$newpass=$_POST['newpass'];
	@$confirmpass=$_POST['confirmpass'];
	if($j_pass == '' || $j_user == '' || $newpass == '' || $confirmpass== ''){
		echo'输入框不允许为空！';
	}elseif($j_pass != $pass){
		echo'旧密码错误！';
	}elseif($newpass != $confirmpass){
		echo'两次输入的密码不同！';
	}else{
		$Handle=fopen("pass.config.php",'w');
		$pass=MD5($newpass.'$$Www.Amoli.Co$$');
		$Data='<?php'."\n".'$user = "'.$j_user.'";'."\n".'$pass = "'.$pass.'";';
		fwrite($Handle,$Data);
		fclose($Handle);
		echo'操作成功';
	}
}
elseif($act=='scan'){
$list='__jsonpCallbackAmoliCo({"name": "\/","children": [';
try {
	$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
	function Digui($prefix,$ossClient,$bucket){
	global $list;
    $options = array('prefix' => $prefix);
    $listObjectInfo = $ossClient->listObjects($bucket,$options);
	$prefixlist = $listObjectInfo->getPrefixList();
    $objectList = $listObjectInfo->getObjectList();
	if (!empty($objectList)) {
        foreach ($objectList as $objectInfo) {
			$Wj_Name=str_replace($prefix,'',$objectInfo->getKey());
			if($Wj_Name!=''){
			$Wj_Size=$objectInfo->getSize();
			$Wj_Time=strtotime($objectInfo->getLastModified());
			$list=$list.'{"name": "'.$Wj_Name.'","size": '.$Wj_Size.',"time": '.$Wj_Time.'},';
			}
        }
    }
	if (!empty($prefixlist)) {
        foreach ($prefixlist as $prefixInfo) {
			$Wjj_Name=$prefixInfo->getPrefix();
			$Wjj=str_replace($prefix,'',$Wjj_Name);
			$Wjj=str_replace('/','',$Wjj);
			$list=$list.'{"name": "'.$Wjj.'","children": [';
			Digui($Wjj_Name,$ossClient,$bucket);
        }
    }
	$list=$list.']},';
	}
	Digui('',$ossClient,$bucket);
	$list=str_replace(',]}',']}',$list.');');
	$list=str_replace(',);',');',$list);
	if($list!=''){
		$myfile=fopen($_SERVER['DOCUMENT_ROOT']."/list.js", "w");
		fwrite($myfile,$list);
		fclose($myfile);
		header('Location: /');
	}
} catch (OssException $e) {
    print $e->getMessage();
}
}
else
{
	echo "No Act!";
}
?>