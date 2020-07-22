<?php include("head.php"); ?>
<br>
<link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
<blockquote class="layui-elem-quote">
上传文件后请点击刷新，刷新一次目录，方可正常显示<br>
如果文件夹内没有文件就会返回：（数据接口请求异常：parsererror）
</blockquote>
<input type="hidden" id="ListUrl" value="<?php echo @$_GET['ListUrl']; ?>"></input>
<table class="layui-hide" id="list" lay-filter="list"></table>
 
<script type="text/html" id="toolbar">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="Upload">上传文件</button>&nbsp;
	<button class="layui-btn layui-btn-sm" style="background-color: #ffffff; color: #000;" lay-event="home">主页</button>&nbsp;
	<button class="layui-btn layui-btn-sm" style="background-color: #ffffff; color: #000;" lay-event="history">返回</button>&nbsp;
	<button class="layui-btn layui-btn-sm" style="background-color: #ffffff; color: #000;" lay-event="drefresh">刷新</button>
  </div>
</script>
<script type="text/html" id="icon">
{{#  if(d.type == 'wjj' ){ }}
    <i style="font-size:18px;color:#FFB800" class="fa fa-folder"></i>
{{# }else{ }}
    <i style="font-size:18px" class="fa fa-file" aria-hidden="true"></i>
{{#  } }}
</script>
<script type="text/html" id="bar">
{{#  if(d.size != '' ){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs layui-bg-blue" lay-event="down">下载</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
{{#  } }}
</script>

<script>
layui.use('table', function(){
  ListUrl = document.getElementById('ListUrl').value;
  var table = layui.table;
  
  table.render({
    elem: '#list'
    ,url:'ajax.php?act=AdminOss&list='+ListUrl
    ,toolbar: '#toolbar'
    ,title: 'OSS文件列表'
    ,cols: [[
	   {field: 'icon', templet:'#icon', width:47,align:'center',unresize:true}
	  ,{field: 'type', title: '类型',hide:true}
      ,{field: 'name', title: '文件名',event: 'setSign',style:'cursor: pointer;',width:'60%',unresize:true}
      ,{field: 'size', title: '文件大小',width:'10%',align:'center',unresize:true}
      ,{field: 'time', title: '更新时间',width:'15%',align:'center',unresize:true}
      ,{field: 'city', title: '操作',templet:'#bar',width:'10%',align:'center',unresize:true}
    ]]
	,skin: 'nob'
  });
  
    //头工具栏事件
  table.on('toolbar', function(obj){
    var checkStatus = table.checkStatus(obj.config.id);
    switch(obj.event){
      case 'Upload':
        layer.open({
        type: 2,
        title: '上传文件',
        shadeClose: true,
        shade: 0.8,
        area: ['70%', '80%'],
        content: 'Upload.php?dir='+ListUrl
        }); 
      break;
	  case 'home':
        window.location="AdminOss.php";
      break;
	  case 'history':
        window.history.back();
      break;
	  case 'drefresh':
        location.reload()
      break;
    };
  });
  
  //监听行工具事件
    table.on('tool(list)', function(obj){
	var $$ = layui.jquery
    var data = obj.data;
    if(obj.event === 'del'){
      layer.confirm('删除后无法恢复，确定删除吗？',{icon: 0}, function(index){
		 $$.ajax({
            url:"ajax.php?act=del&name="+ListUrl+data.name,
            success:function(data){
				obj.del();
				layer.msg('操作成功',{icon:1,time:1800});
            },
            error:function(data){
				layer.msg('操作错误，请刷新重试',{icon: 2,time:1800});
            }
        });
		return false;
      });
    } else if(obj.event === 'down'){
	     layer.msg('开始下载',{icon:1,time:1800});
		 window.location="ajax.php?act=down&name="+ListUrl+data.name
		 return false;
    }else if(obj.event === 'setSign'){
		if(data.type == 'wjj' ){
		 window.location="AdminOss.php?ListUrl="+ListUrl+data.name
	  }
    }
  });
});
</script>


<?php include("foot.php"); ?>