<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("view/pass.config.php");
@$Cookie=$_COOKIE['Admin_' . $user];
if(!isset($Cookie) || $Cookie != $pass){
	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台管理中心 - Amoli私人云</title>
  <link rel="stylesheet" href="src/css/layui.css">
  <link rel="stylesheet" href="css/Amoli_style.css">
  <script type="text/javascript" src="src/layui.js"></script>
</head>
<body class="layui-layout-body">
<style type="text/css">
    .hs-iframe{width:100%;height:100%;}
    .layui-tab{position:absolute;left:0;top:0;height:100%;width:100%;z-index:10;margin:0;border:none;overflow:hidden;}
    .layui-tab-title li:first-child > i {
        display: none;
    }
    .layui-tab-content{padding:0 0 0 10px;height:100%;}
    .layui-tab-item{height:100%;}
    .layui-nav-tree .layui-nav-child a{height:38px;line-height: 38px;}
    .footer{position:fixed;left:0;bottom:0;z-index:998;}
</style>
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="fl header-logo">Amoli私人云控制台</div>
    <ul class="layui-nav fl nobg main-nav">
      <li class="layui-nav-item layui-this"><a href="javascript:;">首页</a></li>
      <li class="layui-nav-item"><a href="javascript:;">系统</a></li>
	  <li class="layui-nav-item"><a href="javascript:;">OSS管理</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/EVH4JaB" class="layui-nav-img">Amoli</a>
        <dl class="layui-nav-child">
          <dd><a href="/"  target="_blank">前台</a></dd>
          <dd><a href="login.php?logout">退出登录</a></dd>
        </dl>
      </li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item layui-nav-itemed">
		  <a href="javascript:;">首页<span class="layui-nav-more"></span></a>
          <dl class="layui-nav-child">
            <dd><a class="admin-nav-item" data-id="11" href="view/index.php">欢迎页面</a></dd>
			<dd><a class="admin-nav-item" data-id="21" href="view/config.php">网站设置</a></dd>
			<dd><a class="admin-nav-item" data-id="31" href="view/AdminOss.php">管理OSS</a></dd>
			<dd><a class="admin-nav-item" data-id="33" href="view/ajax.php?act=scan">更新首页</a></dd>
          </dl>
        </li>
      </ul>
      <ul class="layui-nav layui-nav-tree" style="display:none;">
        <li class="layui-nav-item layui-nav-itemed">
		  <a href="javascript:;">系统<span class="layui-nav-more"></span></a>
          <dl class="layui-nav-child">
            <dd><a class="admin-nav-item" data-id="21" href="view/config.php">网站设置</a></dd>
          </dl>
        </li>
      </ul>
	  
      <ul class="layui-nav layui-nav-tree" style="display:none;">
        <li class="layui-nav-item layui-nav-itemed">
		  <a href="javascript:;">OSS管理<span class="layui-nav-more"></span></a>
          <dl class="layui-nav-child">
            <dd><a class="admin-nav-item" data-id="31" href="view/AdminOss.php">管理OSS</a></dd>
          </dl>
          <dl class="layui-nav-child">
            <dd><a class="admin-nav-item" data-id="32" href="view/Upload.php">上传文件</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
  <div class="layui-body">
    <div class="layui-tab layui-tab-card" lay-filter="macTab" lay-allowClose="true">
        <ul class="layui-tab-title">
            <li lay-id="11" class="layui-this">欢迎页面</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
			<iframe lay-id="11" src="view/index.php" width="100%" height="100%" frameborder="0" scrolling="yes" class="hs-iframe"></iframe>
            </div>
        </div>
    </div>
  </div>
  <div class="layui-footer">
  <div class="fr"> © 2018-2019 <a href="http://www.fcy999.com/" target="_blank">Amoli.Co</a> All Rights Reserved.</div>
  </div>
</div>
<script type="text/javascript" src="js/admin_common.js"></script>
<script type="text/javascript">
    layui.use(['element', 'layer'], function() {
        var $ = layui.jquery, element = layui.element, layer = layui.layer;
        $('.layui-tab-content').height($(window).height() - 145);
        var tab = {
            add: function(title, url, id) {
                element.tabAdd('macTab', {
                        title: title,
                        content: '<iframe width="100%" height="100%" lay-id="'+id+'" frameborder="0" src="'+url+'" scrolling="yes" class="x-iframe"></iframe>',
                        id: id
            });
            }, change: function(id) {
                element.tabChange('macTab', id);
            }
        };
        $('.admin-nav-item').click(function(event) {
            var that = $(this);
            var id = that.attr('data-id');
            if ($('iframe[lay-id="'+id+'"]')[0]) {
                tab.change(id);
                event.stopPropagation();
                $("iframe[lay-id='"+id+"']")[0].contentWindow.location.reload(true);//切换后刷新框架
                return false;
            }
            if ($('iframe').length == 10) {
                layer.msg('最多可打开10个标签页');
                return false;
            }
            that.css({color:'#fff'});
            tab.add(that.text(), that.attr('href'), that.attr('data-id'));
            tab.change(that.attr('data-id'));
            event.stopPropagation();
            return false;
        });
        $(document).on('click', '.layui-tab-close', function() {
            $('.layui-nav-child a[data-id="'+$(this).parent('li').attr('lay-id')+'"]').css({color:'rgba(255,255,255,.7)'});
        });
    });
</script>
</body>
</html>