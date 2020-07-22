<?php 
include("head.php"); 
include($_SERVER['DOCUMENT_ROOT']."/config.php");
include("oss.config.php");
include("pass.config.php");
?>
<div class="page-container">
	<form class="layui-form layui-form-pane" action="" >
		<div class="layui-tab">
			<ul class="layui-tab-title">
				<li class="layui-this">基本设置</li>
				<li>OSS设置</li>
				<li>登录设置</li>
			</ul>
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show">
					<div class="layui-form-item">
						<label class="layui-form-label">网站名称：</label>
						<div class="layui-input-block">
							<input type="text" id="name" value="<?php echo $name; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">副标题：</label>
						<div class="layui-input-block">
							<input type="text" id="fname" value="<?php echo $fname; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">网站域名：</label>
						<div class="layui-input-block">
							<input type="text" id="url" placeholder="不要加http:// , 如：www.amoli.co" value="<?php echo $url; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">关键字：</label>
						<div class="layui-input-block">
							<input type="text" id="keywords" value="<?php echo $keywords; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">描述信息：</label>
						<div class="layui-input-block">
							<input type="text" id="description" value="<?php echo $description; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
							<label class="layui-form-label">下载验证：</label>
						<div class="layui-input-block">
						<?php if($down=='on'): ?>
							<input type="checkbox" checked="" id="down" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
						<?php else: ?>
							<input type="checkbox"  id="down" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
						<?php endif; ?>
						</div>
					</div>
					<div class="layui-form-item">
						<div class="layui-form-item">
							<label class="layui-form-label">首页公告：</label>
							<div class="layui-input-block">
								<textarea id="gonggao" class="layui-textarea" placeholder='首页公告暂不支持有带(")号的html代码'><?php echo $gonggao; ?></textarea>
							</div>
						</div>
					</div>
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<a class="layui-btn layui-btn-radius" onclick="Save()">保 存</a>
						</div>
					</div>
				</div>
				<div class="layui-tab-item">
				<div class="layui-tab-item layui-show">
					<div class="layui-form-item">
						<label class="layui-form-label">Bucket：</label>
						<div class="layui-input-inline w300">
							<input type="text" id="bucket" value="<?php echo $bucket; ?>" class="layui-input">
						</div>
							<a class="layui-btn" target="_blank" href="https://oss.console.aliyun.com/overview">获取Bucket以及Endpoint</a>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">Endpoint：</label>
						<div class="layui-input-inline w300">
							<input type="text" id="endpoint" value="<?php echo $endpoint; ?>" class="layui-input">
						</div>
						<div class="layui-form-mid" style="color: #FF5722;">格式：http(s)://+EndPoint（地域节点） 如果网站采用https协议，请用：https://+EndPoint</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">AccessKeyId：</label>
						<div class="layui-input-inline w300">
							<input type="text" id="accessKeyId" value="<?php echo $accessKeyId; ?>" class="layui-input">
						</div>
							<a class="layui-btn" target="_blank" href="https://ram.console.aliyun.com/users/new">获取AccessKeyId和AccessKeySecret</a>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">AccessKeySecret：</label>
						<div class="layui-input-block">
							<input type="text" id="accessKeySecret" value="<?php echo $accessKeySecret; ?>" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<a class="layui-btn layui-btn-radius" onclick="OssSave()">保 存</a>
						</div>
					</div>
				</div>
				</div>
				<div class="layui-tab-item">
				<div class="layui-tab-item layui-show">
					<div class="layui-form-item">
						<label class="layui-form-label">旧密码：</label>
						<div class="layui-input-block">
							<input type="password" id="pass"  placeholder="" value="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">帐号：</label>
						<div class="layui-input-block">
							<input type="text" id="user" placeholder="" value="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">新密码：</label>
						<div class="layui-input-block">
							<input type="password" id="newpass" value="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">确认新密码：</label>
						<div class="layui-input-block">
							<input type="password" id="confirmpass" value="" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item center">
						<div class="layui-input-block">
							<a class="layui-btn layui-btn-radius" onclick="PassSave()">更 改</a>
						</div>
					</div>
				</div>
				</div>
			</div>
	</form>
	</div>
</div>
<script type="text/javascript">
window.down='<?php echo $down; ?>';
layui.use(['form','element'], function(){
  var form = layui.form;
  var $ = layui.jquery
  ,element = layui.element;
	form.on('switch(switchTest)', function(data){
    this.checked ? down='on' : down='off'
  });
});
function Save(){
	var $$ = layui.jquery
	var name = document.getElementById('name').value;
	var fname = document.getElementById('fname').value;
	var url = document.getElementById('url').value;
	var keywords = document.getElementById('keywords').value;
	var description = document.getElementById('description').value;
	var gonggao = document.getElementById('gonggao').value;
	$$.ajax({
		url:"ajax.php?act=Save",
		type:'POST',
		data: {'name':name,'fname':fname,'url':url,'keywords':keywords,'description':description,'down':down,'gonggao':gonggao},
		success:function(data){
			layer.msg('操作成功',{icon:1,time:1800});
			setTimeout(function(){window.location.reload();},2000);
		},
		error:function(data){}
	});
	return false;
}
function OssSave(){
	var $$ = layui.jquery
	var bucket = document.getElementById('bucket').value;
	var endpoint = document.getElementById('endpoint').value;
	var accessKeyId = document.getElementById('accessKeyId').value;
	var accessKeySecret = document.getElementById('accessKeySecret').value;
	$$.ajax({
		url:"ajax.php?act=OssSave",
		type:'POST',
		data: {'bucket':bucket,'endpoint':endpoint,'accessKeyId':accessKeyId,'accessKeySecret':accessKeySecret},
		success:function(data){
			layer.msg('操作成功',{icon:1,time:1800});
			setTimeout(function(){window.location.reload();},2000);
		}
	});
		$$.ajax({
		url:"ajax.php?act=cors"
	});
	return false;
}
function PassSave(){
	var $$ = layui.jquery
	var pass = document.getElementById('pass').value;
	var user = document.getElementById('user').value;
	var newpass = document.getElementById('newpass').value;
	var confirmpass = document.getElementById('confirmpass').value;
	$$.ajax({
		url:"ajax.php?act=PassSave",
		type:'POST',
		data: {'pass':pass,'user':user,'newpass':newpass,'confirmpass':confirmpass},
		success:function(data){
			if(data=='操作成功'){
				layer.msg('操作成功',{icon:1,time:1800});
				setTimeout(function(){window.location.reload();},2000);
			}else{
				layer.msg(data,{icon:2,time:1800});
			}
		}
	});
	return false;
}
</script>
<?php include("foot.php"); ?>