<?php
header("Content-Type: text/html; charset=utf-8");
session_start();//初始化session
if(isset($_SESSION['super']) && $_SESSION['super'] == '0'){
	header("Location:release.php");
	exit();
}else if(isset($_SESSION['super']) && $_SESSION['super'] == '1'){
	header("Location:manage.php");
	exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>管理员入口</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<style>
	body{
		width:500px;
		margin:0 auto;
		font-family: 微软雅黑;
	}
	#header{
		padding:20px;
		text-align: center;
	}
	#form-submit{
		text-align: center;
	}
	</style>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$('#close').click(function(){
			var url=' '
			open(url, '_self').close();
		})
		$('input').blur(function(){
			if($(this).parent().hasClass('has-error'))
				$(this).parent().removeClass('has-error')
		})

		$('#password').keydown(function(e){
			if(e.which == 13){
				$('#login').click()
			}
		})
		$('#login').click(function(){
			var username = $('#username').val()
			var password = $('#password').val()
			if(username == ''){
				$('#username').parent().addClass('has-error')
			}else if(password == ''){
				$('#password').parent().addClass('has-error')
			}else{
				$.ajax({
					url: 'php/check_login.php',
					type: 'POST',
					dataType: 'json',
					data: {
						'username' : username,
						'password' : password
					},
					success: function(data) {
						if(data.status == 'success'){
							alert('登录成功！')
							if(data.sup == '1'){
								window.location.href = 'manage.php'
							}else{
								window.location.href = 'release.php'
							}
						}else{
							alert('登录失败！用户名或密码错误！')
							$('#password').focus()
							$('#password').parent().addClass('has-error')
						}
					},
					complete: function(XMLHttpRequest, textStatus) {},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						// alert("ajax request failed" + " " + XMLHttpRequest.readyState + 
						// 	" " + XMLHttpRequest.status + " " + textStatus)
					}
				})
			}
		})
})
</script>
</head>
<body>
	<div id='header'>
		<h1>管理员入口</h1>
	</div>
	<form role="form">
		<div class="form-group">
			<label for="username">账号</label>
			<input type="text" class="input-block-level" id="username" placeholder="请输入账号">
		</div>
		<div class="form-group">
			<label for="password">密码</label>
			<input type="password" class="input-block-level" id="password" placeholder="请输入密码">
		</div>
		<div class="form-group" id='form-submit'>
			<button type="button" class="btn btn-default" id='close'>关闭</button>
			<button type="button" class="btn btn-primary" id='login'>登录</button>
		</div>
	</form>
</body>
</html>