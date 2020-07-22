<?php
@header('Content-Type: text/html; charset=UTF-8');
if(!file_exists('install/install.lock')){
	echo '你还没安装！<a href="/install">点此安装</a>';
	exit();
}
include("config.php");
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title><?php echo $name; ?> - <?php echo $fname; ?></title>
		<meta charset="UTF-8">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta name="description" content="<?php echo $description; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="theme-color" content="#4d545d">
		<link rel="shortcut icon" href="/favicon.ico"/>
		<link href="css/style.css" rel="stylesheet">
		<script src="/js/jquery.min.js"></script>
	</head>
	<?php if($down=='on'): ?>
			<style type="text/css">
			/* 滑块验证码 */ .captcha { width:
			100%; height: 100%; display: flex; align-items: center; justify-content:
			center; } #embed-captcha { width: 300px; margin: 0 auto; margin-top: -50px;
			} #embed-captcha:empty { display: none; } #embed-captcha::after { color:
			gray; display: block; font-size: 13px; margin-top: 5px; content: '使用你的手，缓慢且准确的滑过去！';
			} .show { display: block; } .hide { display: none; } #notice { color: red;
			}
			</style>
	<?php endif; ?>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark no-select">
			<div class="container">
				<a class="navbar-brand" href="http://<?php echo $url; ?>"><?php echo $name; ?></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="http://<?php echo $url; ?>">首页</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">赞助商</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" target="_blank" href="http://www.fcy999.com">风骋翌互联</a>
								<a class="dropdown-item" target="_blank" href="http://www.fcy99.com">凨辰隐免费资源网</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<noscript>
			<style>
				.navbar-collapse { display: block !important; }
			</style>
			<div class="container">
				<div class="alert alert-danger">
					<strong>非常抱歉：如果您的浏览器不启用 javascript，<?php echo $name; ?>页面可能无法正常使用，请在浏览器设置中启用 javascript。</strong>
				</div>
			</div>
		</noscript>
		<!--[if lt IE 9]>
			<div class="container">
				<div class="alert alert-danger">
					<strong>
						非常抱歉：使用 IE 8 或者更早版本的浏览器访问本网站可能给您带来较差的交互体验，请您将浏览器升级至最新版本。推荐使用<a href="https://www.google.cn/chrome/">Chrome 浏览器</a>访问本页面。
					</strong>
				</div>
			</div>
		<![endif]-->
		<div class="container">
			<div class="alert alert-primary alert-dismissible fade show" role="alert">
				<ul><li><?php echo $gonggao; ?></li></ul>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div id="app"></div>
		<div id="main">
			<div class="container">
				<h1 class="current-path">http://<?php echo $url; ?></h1>
			</div>
		</div>
		<div class="footer">
			<p class="copyright">
				<span>Copyright &copy; 2019 Powered by <a target="_blank" href="http://www.fcy999.com">Amoli.Co</a></span>
			</p>
		</div>
		<script>
			(function() {
				var ths = document.querySelectorAll('th');
				for (var i = 0; i < ths.length; ++i) {
					ths[i].style.width = '';
				}
				window.addEventListener('DOMContentLoaded',
				function() {
					window.AmoliCo = new AmoliCo({
						routerMode: 'hash',
						requestType: 'jsonp'
					});
				});
			})();
			function autoclick(){
                var lnk = document.getElementsByClassName("text-left");
                lnk[0].click();
            }
            onload = function(){
                setTimeout(autoclick, 1);
            }
			$(document).on('click','#wjj,#daohang',function() {
				setTimeout(autoclick, 1);
			})
		</script>
		<script src="js/home.js"></script>
		<?php if($down=='on'): ?>
		<script src="/js/layer/layer.js"></script>
		<script src="/js/gt.js"></script>
		<script>
			$(document).on('click','#down',function(e) {
				e.preventDefault();
				DownUrl = $(this).attr('url');
				layer.open({
					type: 1,
					skin: 'layui-layer-rim',
					area: ['350px', '250px'],
					title: '你需要证明你不是机器人',
					content: '<div class="captcha"><div id="embed-captcha"></div><p id="wait" class="show">正在加载验证码......</p><p id="notice" class="hide">请先完成验证</p></div>'
				});
		$.ajax({
			url: 'ajax.php?act=yz&t=' + (new Date()).getTime(),
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				initGeetest({
					gt: data.gt,
					challenge: data.challenge,
					new_captcha: data.new_captcha,
					product: 'embed',
					offline: !data.success
				},
				handlerEmbed)
			}
		})
	});
	var handlerEmbed = function(captchaObj) {
		$('#embed-submit').click(function(e) {
			var validate = captchaObj.getValidate();
			if (!validate) {
				$('#notice')[0].className = 'show';
				setTimeout(function() {
					$('#notice')[0].className = 'hide'
				},
				2000);
				e.preventDefault()
			}
		});
		captchaObj.appendTo('#embed-captcha');
		captchaObj.onReady(function() {
			$('#wait')[0].className = 'hide'
		});
		captchaObj.onSuccess(function() {
			var result = captchaObj.getValidate();
			$.ajax({
				url: 'ajax.php?act=key&url='+DownUrl+'&t=' + (new Date()).getTime(),
				type: 'POST',
				data: {
					geetest_challenge: result.geetest_challenge,
					geetest_validate: result.geetest_validate,
					geetest_seccode: result.geetest_seccode
				},
				dataType: 'json',
				success: function(data) {
					layer.closeAll('page');
					location.href = 'ajax.php?act=down&url='+DownUrl+'&key=' + data.key
				}
			})
		})
	};
</script>
<?php endif; ?>
	</body>
</html>