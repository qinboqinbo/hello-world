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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台管理中心 - Amoli私人云</title>
  <link rel="stylesheet" href="../src/css/layui.css">
  <link rel="stylesheet" href="../css/Amoli_style.css">
  <script type="text/javascript" src="../src/layui.js"></script>
</head>
<body>
