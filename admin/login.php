<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("view/pass.config.php");
@$Cookie=$_COOKIE['Admin_' . $user];
if(@isset($_GET['logout'])){
	setcookie('Admin_' . $user,'',time()-1552294270);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='login.php';</script>");
}
if(isset($Cookie) && $Cookie == $pass){
	header('Location: index.php');
}
@$MD5_Pass=MD5($_POST['pass'].'$$Www.Amoli.Co$$');
if (@$_POST['user'] == $user && $MD5_Pass == $pass) {
	setcookie('Admin_' . $user, $MD5_Pass, time()+3600*24);
	header('Location: index.php');
    }
//setcookie("TestCookie",$user,time()+3600*24);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>后台登录 - Moli私有云</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('img/bg.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form action="" method="post" class="login100-form validate-form">
					<span class="login100-form-title p-b-49">后台登录</span>
					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" name="user" placeholder="请输入用户名" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" name="pass" placeholder="请输入密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					<div class="text-right p-t-8 p-b-31">
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">登 录</button>
						</div>
					</div>
					<div class="txt1 text-center p-t-54 p-b-20">
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>