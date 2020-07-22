<?php include("head.php"); ?>
<div class="page-container"><br>
    <blockquote class="layui-elem-quote layui-quote-nm mt10">欢迎使用Amoli私人云，一路陪伴，感恩有你！请不要修改系统文件，以免出现故障！
	<a class="layui-btn layui-btn-sm" onclick="Donate()">捐赠网站</a>
	</blockquote>
    <table class="layui-table" >
        <thead>
        <tr>
            <th colspan="4" scope="col">服务器当前日期【<?php echo date('Y-m-d'); ?>】</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="15%">操作系统</td>
            <td width="30%"><?php echo PHP_OS ?></td>
            <td width="15%">脚本解释引擎</td>
            <td width="30%"><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
        </tr>
        <tr>
            <td>安装目录</td>
            <td><?php echo $_SERVER['DOCUMENT_ROOT'] ?></td>
            <td>服务器 (IP/端口) </td>
            <td><?php echo $_SERVER['HTTP_HOST'] ?></td>
        </tr>
        <tr>
            <td>PHP版本</td>
            <td><?php echo PHP_VERSION ?></td>
            <td>允许最大上传文件</td>
            <td><?php echo get_cfg_var("file_uploads") ? get_cfg_var("upload_max_filesize") : $error;?></td>
        </tr>
        <tr>
            <td colspan="4">当前版本：<span class="layui-badge">2019.02.19.3.0</span> 授权类型：<span class="layui-badge">免费版</span></td>
        </tr>
        </tbody>
    </table>
	<blockquote class="layui-elem-quote">Amoli私人云&nbsp;交流群&nbsp;<a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=dc360e81759a992290186ffba369c90a15a694444141836df005fd2ea5bd710d">792103919</a>&nbsp;有问题请在群内反馈，版本更新也会第一时间通知</blockquote>
<script>
layui.use(['form'], function(){
});
function Donate(){
	layer.open({
	type: 1,
	title: '捐赠网站',
	shadeClose: true,
	shade: 0.8,
	area: ['80%', '90%'],
	content: '<blockquote class="layui-elem-quote">赞助网站：<br>网站目前主要的费用是域名和空间费用，目前没有任何广告收入来源<br>如果你愿意为网站的发展尽一份力，那么可以随便表示一下心意以示支持，自由捐赠数目不限。</blockquote><center><img src="https://s2.ax1x.com/2019/02/22/kWcZV0.png" style="width: 25%;height: 25%;"><img src="https://s2.ax1x.com/2019/02/22/kWceaV.png" style="width: 25%;height: 25%;"></center>' //iframe的url
	}); 
}
</script>
</div>
<?php include("foot.php"); ?>