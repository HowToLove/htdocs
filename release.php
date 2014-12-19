<?php 
header("Content-Type: text/html; charset=utf-8");
session_start () ;
if (!isset ($_SESSION['super'])){
	echo "<p style='text-align:center;color:red;font-size:40px;font-weight:bold;'>";
	echo "请先<a href='login.php'>登录</a>!";
	echo "</p>";
	exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>信息发布</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/release.css"/>
	<link rel="stylesheet" href="css/common.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div id='header'>
		<h1>信息发布平台</h1>
	</div>
	<form class="form-horizontal" role="form" id='form'>
		<div class="control-group" id='form-headline'>
			<label for="inputHeadline" class="control-label">标题</label>
			<div class="controls">
				<input type="text" class="input-block-level" id="inputHeadline" placeholder="请输入标题">
			</div>
		</div>
		<div class="control-group" id='form-content'>
			<label for="inputContent" class="control-label">正文</label>
			<div class="controls">
				<script id="container" name="content" type="text/plain">
				</script>				
			</div>
		</div>
		<div class="control-group" id='form-kind'>
			<label for="inputKind" class="control-label">分类</label>
			<div class="controls">
				<select class="form-control input-block-level" id='inputKind'>
					<option value='xwdt'>新闻动态</option>
					<option value='kxyj'>科学研究</option>
					<option value='xsjl'>学术交流</option>
					<option value='rcpy'>人才培养</option>
					<option value='shfw'>社会服务</option>
					<option value='xtcx'>协同创新</option>
					<option value='csj'>长三角</option>
					<option value='tzgg'>通知公告</option>
					<option value='zcwj'>政策文件</option>
					<option value='zyxz'>资源下载</option>
					<option value='lxwm'>联系我们</option>
					<option value='yjyjj'>研究院简介</option>
					<option value='zzjg'>组织机构</option>
					<option value='lsh'>理事会</option>
					<option value='xswyh'>学术委员会</option>
					<option value='ywwyh'>院务委员会</option>
					<option value='yjtd'>研究团队</option>
					<option value='gzzd'>规章制度</option>
				</select>
			</div>
		</div>
		<div class="control-group" id='form-author'>
			<label for="inputAuthor" class="control-label">发布者</label>
			<div class="controls">
				<input type="text" class="form-control input-block-level" id="inputAuthor" placeholder="请输入发布者姓名">
			</div>
		</div>
		<div class="control-group" id='form-submit'>
			<button type="button" class="btn btn-primary btn-block">发布</button>
		</div>
	</form>
	
	<!-- 配置文件 -->
	<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
	<!-- 编辑器源码文件 -->
	<script type="text/javascript" src="ueditor/ueditor.all.js"></script>
	<!-- 实例化编辑器 -->
	<script type="text/javascript">
	var ue = UE.getEditor('container',{
		initialFrameHeight: 400
	})
	$(function(){
		$('#form-submit button').click(function(){
			var headline = $('#form-headline input').val()
			if(headline == ''){
				$('#form-headline input').focus()
				$('#form-headline').addClass('has-error')
			}
			else{
				var content = ue.getContent()
				var kind = $('#inputKind').val()
				var author = $('#inputAuthor').val()
				$.ajax({
					url: 'php/release.php',
					type: 'POST',
					dataType: 'json',
					data: {
						'headline' : headline,
						'content' : content,
						'kind' : kind,
						'author' : author
					},
					success: function(data) {
						if(data.status == 'success'){
							alert('发布成功')
							location.reload() 
						}else{
							alert('发布失败')
						}
					},
					complete: function(XMLHttpRequest, textStatus) {},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						// alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus)
					}
				})
			}
		})
		$('#form-headline input').blur(function(){
			if($('#form-headline').hasClass('has-error')){
				$('#form-headline').removeClass('has-error')
			}
		})
	})
	</script>
</body>
</html>