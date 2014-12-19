<?php 
header("Content-Type: text/html; charset=utf-8");
//判断用户是否登录且是否为超级管理员（super == 1）
session_start();
if (!isset ($_SESSION['super'])){
	echo "<p style='text-align:center;color:red;font-size:40px;font-weight:bold;'>";
	echo "请先<a href='login.php'>登录</a>!";
	echo "</p>";
	exit();
}
if($_SESSION['super'] == '0'){
	echo "<p style='text-align:center;color:red;font-size:40px;font-weight:bold;'>";
	echo "对不起！您没有此操作权限！";
	echo "</p><p style='text-align:center;font-size:20px;'>";
	echo "如有问题，请联系超级管理员。";
	echo "</p>";
	exit();
}
?>
<?php
//session_start();
require_once('php/config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);
mysql_query('set names "UTF8"',$con);

$id = $_SESSION['editid'];

$sql = "SELECT NEWS_ID,NEWS_HEADLINE,NEWS_CONTENT,NEWS_KIND,NEWS_AUTHOR 
FROM NEWS WHERE ID='$id'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
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
	<script type="text/javascript">
	var kind = "<?php echo $row['NEWS_KIND'];?>"
	$(function(){
		$('#inputKind').val(kind)
	})
	</script>
</head>
<body>
	<div id='header'>
		<h1>信息发布平台</h1>
	</div>
	<form class="form-horizontal" role="form" id='form'>
		<div class="control-group" id='form-headline'>
			<label for="inputHeadline" class="control-label">标题</label>
			<div class="controls">
				<input type="text" class="input-block-level" id="inputHeadline" placeholder="请输入标题" value=<?php echo $row['NEWS_HEADLINE']?>>
			</div>
		</div>
		<div class="control-group" id='form-content'>
			<label for="inputContent" class="control-label">正文</label>
			<div class="controls">
				<script id="container" name="content" type="text/plain">
				<?php echo $row['NEWS_CONTENT']?>
				</script>				
			</div>
		</div>
		<div class="control-group" id='form-kind'>
			<label for="inputKind" class="control-label">分类</label>
			<div class="controls">
				<select class="form-control input-block-level" id='inputKind'>
					<option value='xwdt' id='xwdt'>新闻动态</option>
					<option value='kxyj' id='kxyj'>科学研究</option>
					<option value='xsjl' id='xsjl'>学术交流</option>
					<option value='rcpy' id='rcpy'>人才培养</option>
					<option value='shfw' id='shfw'>社会服务</option>
					<option value='xtcx' id='xtcx'>协同创新</option>
					<option value='csj' id='csj'>长三角</option>
					<option value='tzgg' id='tzgg'>通知公告</option>
					<option value='zcwj' id='zcwj'>政策文件</option>
					<option value='zyxz' id='zyxz'>资源下载</option>
					<option value='lxwm' id='lxwm'>联系我们</option>
					<option value='yjyjj' id='yjyjj'>研究院简介</option>
					<option value='zzjg' id='zzjg'>组织机构</option>
					<option value='lsh' id='lsh'>理事会</option>
					<option value='xswyh' id='xswyh'>学术委员会</option>
					<option value='ywwyh' id='ywwyh'>院务委员会</option>
					<option value='yjtd' id='yjtd'>研究团队</option>
					<option value='gzzd' id='gzzd'>规章制度</option>
				</select>
			</div>
		</div>
		<div class="control-group" id='form-author'>
			<label for="inputAuthor" class="control-label">发布者</label>
			<div class="controls">
				<input type="text" class="form-control input-block-level" id="inputAuthor" placeholder="请输入发布者姓名" value=<?php echo $row['NEWS_AUTHOR']?>>
			</div>
		</div>
		<div class="control-group" id='form-submit'>
			<button type="button" class="btn btn-primary btn-block">保存修改</button>
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
					url: 'php/edit.php',
					type: 'POST',
					dataType: 'json',
					data: {
						'id' : <?php echo $id;?>,
						'newsid' : <?php echo $row['NEWS_ID'];?>,
						'headline' : headline,
						'content' : content,
						'kind' : kind,
						'author' : author
					},
					success: function(data) {
						if(data.status == 'success'){
							alert('保存成功')
							window.open('manage.php','_self') 
						}else{
							alert('保存失败')
						}
					},
					complete: function(XMLHttpRequest, textStatus) {},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						//alert("ajax request failed" + " " + XMLHttpRequest.readyState + " " + XMLHttpRequest.status + " " + textStatus)
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