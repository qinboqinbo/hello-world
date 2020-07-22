<?php
@header('Content-Type: text/html; charset=UTF-8');
if(file_exists('install.lock')){
	echo '<div class="alert alert-warning">您已经安装过，如需重新安装请删除<font color=red> install/install.lock </font>文件后再安装！</div>';
	exit();
}
?>
<html lang="zh-CN">
	<head>
		<title>安装向导 - Amoli私人云</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="theme-color" content="#4d545d">
		<link rel="shortcut icon" href="/favicon.ico"/>
		<link href="/admin/src/css/layui.css" rel="stylesheet">
	</head>
	<style type="text/css">
		body{text-align:center;}
		.header{position:fixed;left:0;top:0;width:80%;height:60px;line-height:60px;background:#000;padding:0 10%;z-index:10000;}
		.header h1{color:#fff;font-size:20px;font-weight:600;text-align:center;}
		.install-box{margin:100px auto 0;background:#fff;border-radius:10px;padding:20px;overflow:hidden;box-shadow: 5px 5px 15px #888888;display:inline-block;width:680px;min-height:500px;}
		.protocol{text-align:left;height:400px;overflow-y:auto;padding:10px;color:#333;}
		.protocol h2{text-align:center;font-size:16px;color:#000;}
		.step-btns{padding:20px 0 10px 0;}
		.copyright{padding:25px 0;}
		.copyright,.copyright a{color:#ccc;}
	</style>
<body>
  <div class="header"><h1>感谢您选择Amoli私人云系统</h1></div>
<?php 
header('Content-Type:text/html;charset=utf-8');
@$step=$_GET['step'];
if($step == '' || $step == '1'){
echo <<<EOT
  <div class="install-box">
    <fieldset class="layui-elem-field site-demo-button">
      <legend>Amoli私人云用户协议 适用于所有用户</legend>
      <div class="protocol">
        <p>
          请您在使用(Amoli私人云)前仔细阅读如下条款。包括免除或者限制作者责任的免责条款及对用户的权利限制。您的安装使用行为将视为对本《用户许可协议》的接受，并同意接受本《用户许可协议》各项条款的约束。<br><br>
          一、安装和使用：<br>
          (Amoli私人云)是免费和开源提供给您使用的，您可安装无限制数量副本。 您必须保证在不进行非法活动，不违反国家相关政策法规的前提下使用本软件。<br><br>
          二、免责声明： <br>
          本源码并无附带任何形式的明示的或暗示的保证，包括任何关于本源码的适用性, 无侵犯知识产权或适合作某一特定用途的保证。<br>
		  在任何情况下，对于因使用本软件或无法使用本软件而导致的任何损害赔偿，作者均无须承担法律责任。作者不保证本软件所包含的资料,文字、图形、链接或其它事项的准确性或完整性。作者可随时更改本软件，无须另作通知。<br>
          所有由用户自己制作、下载、使用的第三方信息数据和插件所引起的一切版权问题或纠纷，本软件概不承担任何责任。<br><br>
          三、协议规定的约束和限制：<br>
          禁止去除(Amoli私人云)源码里的版权信息，商业授权版本可去除后台界面及前台界面的相关版权信息。<br>
          禁止在(Amoli私人云)整体或任何部分基础上发展任何派生版本、修改版本或第三方版本用于重新分发。<br><br>
          <strong>版权所有 &copy; 2018-2019，Amoli私人云,保留所有权利</strong>。
        </p>
      </div>
    </fieldset>
    <div class="step-btns">
      <a href="?step=2" class="layui-btn layui-btn-big layui-btn-normal">同意协议并安装系统</a>
    </div>
  </div>
EOT
;
}
elseif($step == '2'){
	$Jc_php='ok';
	if(phpversion()<5.5){
		$Jc_php='no';
	}
echo '
<style type="text/css">
.layui-table td, .layui-table th{text-align:left;}
.layui-table tbody tr.no{background-color:#f00;color:#fff;}
</style>
<div class="install-box">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>运行环境检测</legend>
    </fieldset>
    <table class="layui-table" lay-skin="line">
        <thead>
            <tr>
                <th>环境名称</th>
                <th>当前配置</th>
                <th>所需配置</th>
            </tr> 
        </thead>
        <tbody>
            <tr class="ok">
                <td>操作系统</td>
                <td>WINNT</td>
                <td>Windows/Unix</td>
            </tr>
            <tr class="'.$Jc_php.'">
                <td>PHP版本</td>
                <td>'.phpversion().'</td>
                <td>5.5及以上</td>
            </tr>
                    </tbody>
    </table>
    <table class="layui-table" lay-skin="line">
        <thead>
            <tr>
                <th>目录/文件</th>
                <th>所需权限</th>
                <th>当前权限</th>
            </tr> 
        </thead>
        <tbody>
			<tr class="ok">
                <td>config.php</td>
                <td>读写</td>
                <td>未知</td>
            </tr>
			<tr class="ok">
                <td>/admin/view/oss.config.php</td>
                <td>读写</td>
                <td>未知</td>
            </tr>
			<tr class="ok">
                <td>/admin/view/pass.config.php</td>
                <td>读写</td>
                <td>未知</td>
            </tr>
        </tbody>
    </table>
    <div class="step-btns">
        <a href="?step=1" class="layui-btn layui-btn-primary layui-btn-big fl">返回上一步</a>
        <a href="?step=3" class="layui-btn layui-btn-big layui-btn-normal fr">进行下一步</a>
    </div>
</div>
';
}
elseif($step == '3'){
echo '
<style type="text/css">
.layui-table td, .layui-table th{text-align:left;}
.layui-table tbody tr.no{background-color:#f00;color:#fff;}
</style>
<div class="install-box">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>网站信息配置</legend>
    </fieldset>
    <form class="layui-form layui-form-pane" action="?step=4" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">网站名称</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="name" lay-verify="title" value="Amoli私人云">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">副标题</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="fname" lay-verify="title" value="帮助您快速搭建私有云盘系统">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">网站域名</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="url" lay-verify="title" value="www.amoli.co">
            </div>
            <div class="layui-form-mid layui-word-aux">不要加http:// , 如：www.amoli.co</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">关键字</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="keywords" lay-verify="title" value="Amoli私人云,Amoli私有云,Amoli,AMoliCloud">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述信息</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="description" lay-verify="title" value="Amoli私人云，一键快速搭建私有云盘系统，支持本地、阿里云OSS等对象存储在线管理">
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>管理账号设置</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员账号</label>
            <div class="layui-input-inline w200">
                <input type="text" class="layui-input" name="user" lay-verify="title">
            </div>
            <div class="layui-form-mid layui-word-aux">管理员账号最少4位</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员密码</label>
            <div class="layui-input-inline w200">
                <input type="password" class="layui-input" name="pass" lay-verify="title">
            </div>
            <div class="layui-form-mid layui-word-aux">保证密码最少6位</div>
        </div>
        <div class="step-btns">
            <a href="?step=2" class="layui-btn layui-btn-primary layui-btn-big fl">返回上一步</a>
            <button type="submit" class="layui-btn layui-btn-big layui-btn-normal fr">立即执行安装</button>
        </div>
    </form>
</div>
';
}
elseif($step == '4'){
@$name = $_POST['name'];
@$fname = $_POST['fname'];
@$keywords = $_POST['keywords'];
@$url = $_POST['url'];
@$description = $_POST['description'];
@$user = $_POST['user'];
@$pass = $_POST['pass'];
if($name == '' || $url == '' || $user == '' || $pass == ''){
	$result='标题、域名、帐号、密码不允许为空！';
}else{
	$Handle=fopen($_SERVER['DOCUMENT_ROOT']."/config.php",'w');
	$Data='<?php'."\n".'$name = "'.$name.'";'."\n".'$fname = "'.$fname.'";'."\n".'$keywords = "'.$keywords.'";'."\n".'$url = "'.$url.'";'."\n".'$description = "'.$description.'";'."\n".'$down = "on";'."\n".'$gonggao = "欢迎使用Amoli私人云，一路陪伴，感恩有你！";';
	fwrite($Handle,$Data);
	fclose($Handle);
	$pass_Handle=fopen($_SERVER['DOCUMENT_ROOT']."/admin/view/pass.config.php",'w');
	$pass=MD5($pass.'$$Www.Amoli.Co$$');
	$pass_Data='<?php'."\n".'$user = "'.$user.'";'."\n".'$pass = "'.$pass.'";';
	fwrite($pass_Handle,$pass_Data);
	fclose($pass_Handle);
	file_put_contents("install.lock",'www.amoli.co');
	$result='安装完成！';
}
echo '
<style type="text/css">
.layui-table td, .layui-table th{text-align:left;}
.layui-table tbody tr.no{background-color:#f00;color:#fff;}
</style>
<div class="install-box">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>安装提示</legend>
    </fieldset>
	<h1>'.$result.'</h1>
    <div class="step-btns">
      <a href="/" class="layui-btn layui-btn-primary layui-btn-big fl">返回首页</a>
      <a href="/admin/login.php" class="layui-btn layui-btn-big layui-btn-normal fr">前往后台</a>
    </div>
</div>
';
}
?>
  <div class="copyright">&copy; 2018-2019<a href="http://www.fcy999.com" target="_blank"> Amoli.Co</a> All Rights Reserved.</div>
</body>
</html>