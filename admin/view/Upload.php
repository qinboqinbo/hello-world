<?php include("head.php"); ?>
<div class="page-container"><br>
<blockquote class="layui-elem-quote">为不影响你的正常使用，请上传完成后再关闭此窗口<br>上传成功后请点击更新首页，首页才会正常显示</blockquote>
<div class="layui-upload">
  <div class="layui-upload-list">
    <table class="layui-table">
      <thead>
        <tr><th>文件名</th>
        <th>大小</th>
        <th>进度</th>
        <th>状态</th>
      </tr></thead>
      <tbody id="demoList"></tbody>
    </table>
  </div>
</div> 
<br>
<input type="hidden" id="ListUrl" value="<?php echo @$_GET['dir']?>"></input>
<div id="container">
	<a id="selectfiles" href="javascript:void(0);" class="layui-btn layui-btn-normal">选择文件</a>
	<a id="postfiles" href="javascript:void(0);" class="layui-btn">开始上传</a>
	<a href="ajax.php?act=scan" target="_blank" class="layui-btn layui-btn-danger">更新首页</a>
</div>
<pre id="console"></pre>
<p></p>
<script type="text/javascript" src="upload/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="upload/js/upload.js"></script>
</div>
<?php include("foot.php"); ?>