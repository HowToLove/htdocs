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
require_once('php/config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);
mysql_query('set names "UTF8"',$con);

//取出数据库中的所有数据
$sql = "SELECT ID, NEWS_ID, NEWS_HEADLINE, NEWS_TIME, NEWS_KIND
FROM NEWS
ORDER BY ID DESC";
$result = mysql_query($sql);

//将所有数据按类别存放
$xwdt = Array();$kxyj = Array();$xsjl = Array();$rcpy = Array();$shfw = Array();$xtcx = Array();
$csj = Array();$tzgg = Array();$zcwj = Array();$zyxz = Array();$lxwm = Array();$yjyjj = Array();
$zzjg = Array();$lsh = Array();$xswyh = Array();$ywwyh = Array();$yjtd = Array();$gzzd = Array();

//数据分类计数
$ixwdt = 0;$ikxyj = 0;$ixsjl = 0;$ircpy = 0;$ishfw = 0;$ixtcx = 0;
$icsj = 0;$itzgg = 0;$izcwj = 0;$izyxz = 0;$ilxwm = 0;$iyjyjj = 0;
$izzjg = 0;$ilsh = 0;$ixswyh = 0;$iywwyh = 0;$iyjtd = 0;$igzzd = 0;

//数据分类存放
while($row = mysql_fetch_array($result)){
	switch ($row['NEWS_KIND']) {
		case 'xwdt':
		$xwdt[$ixwdt]['id'] = $row['ID'];
		$xwdt[$ixwdt]['newsid'] = $row['NEWS_ID'];
		$xwdt[$ixwdt]['headline'] = $row['NEWS_HEADLINE'];
		$xwdt[$ixwdt++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'kxyj':
		$kxyj[$ikxyj]['id'] = $row['ID'];
		$kxyj[$ikxyj]['newsid'] = $row['NEWS_ID'];
		$kxyj[$ikxyj]['headline'] = $row['NEWS_HEADLINE'];
		$kxyj[$ikxyj++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'xsjl':
		$xsjl[$ixsjl]['id'] = $row['ID'];
		$xsjl[$ixsjl]['newsid'] = $row['NEWS_ID'];
		$xsjl[$ixsjl]['headline'] = $row['NEWS_HEADLINE'];
		$xsjl[$ixsjl++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'rcpy':
		$rcpy[$ircpy]['id'] = $row['ID'];
		$rcpy[$ircpy]['newsid'] = $row['NEWS_ID'];
		$rcpy[$ircpy]['headline'] = $row['NEWS_HEADLINE'];
		$rcpy[$ircpy++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'shfw':
		$shfw[$ishfw]['id'] = $row['ID'];
		$shfw[$ishfw]['newsid'] = $row['NEWS_ID'];
		$shfw[$ishfw]['headline'] = $row['NEWS_HEADLINE'];
		$shfw[$ishfw++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'xtcx':
		$xtcx[$ixtcx]['id'] = $row['ID'];
		$xtcx[$ixtcx]['newsid'] = $row['NEWS_ID'];
		$xtcx[$ixtcx]['headline'] = $row['NEWS_HEADLINE'];
		$xtcx[$ixtcx++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'csj':
		$csj[$icsj]['id'] = $row['ID'];
		$csj[$icsj]['newsid'] = $row['NEWS_ID'];
		$csj[$icsj]['headline'] = $row['NEWS_HEADLINE'];
		$csj[$icsj++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'tzgg':
		$tzgg[$itzgg]['id'] = $row['ID'];
		$tzgg[$itzgg]['newsid'] = $row['NEWS_ID'];
		$tzgg[$itzgg]['headline'] = $row['NEWS_HEADLINE'];
		$tzgg[$itzgg++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'zcwj':
		$zcwj[$izcwj]['id'] = $row['ID'];
		$zcwj[$izcwj]['newsid'] = $row['NEWS_ID'];
		$zcwj[$izcwj]['headline'] = $row['NEWS_HEADLINE'];
		$zcwj[$izcwj++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'zyxz':
		$zyxz[$izyxz]['id'] = $row['ID'];
		$zyxz[$izyxz]['newsid'] = $row['NEWS_ID'];
		$zyxz[$izyxz]['headline'] = $row['NEWS_HEADLINE'];
		$zyxz[$izyxz++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'lxwm':
		$lxwm[$ilxwm]['id'] = $row['ID'];
		$lxwm[$ilxwm]['newsid'] = $row['NEWS_ID'];
		$lxwm[$ilxwm]['headline'] = $row['NEWS_HEADLINE'];
		$lxwm[$ilxwm++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'yjyjj':
		$yjyjj[$iyjyjj]['id'] = $row['ID'];
		$yjyjj[$iyjyjj]['newsid'] = $row['NEWS_ID'];
		$yjyjj[$iyjyjj]['headline'] = $row['NEWS_HEADLINE'];
		$yjyjj[$iyjyjj++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'zzjg':
		$zzjg[$izzjg]['id'] = $row['ID'];
		$zzjg[$izzjg]['newsid'] = $row['NEWS_ID'];
		$zzjg[$izzjg]['headline'] = $row['NEWS_HEADLINE'];
		$zzjg[$izzjg++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'lsh':
		$lsh[$ilsh]['id'] = $row['ID'];
		$lsh[$ilsh]['newsid'] = $row['NEWS_ID'];
		$lsh[$ilsh]['headline'] = $row['NEWS_HEADLINE'];
		$lsh[$ilsh++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'xswyh':
		$xswyh[$ixswyh]['id'] = $row['ID'];
		$xswyh[$ixswyh]['newsid'] = $row['NEWS_ID'];
		$xswyh[$ixswyh]['headline'] = $row['NEWS_HEADLINE'];
		$xswyh[$ixswyh++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'ywwyh':
		$ywwyh[$iywwyh]['id'] = $row['ID'];
		$ywwyh[$iywwyh]['newsid'] = $row['NEWS_ID'];
		$ywwyh[$iywwyh]['headline'] = $row['NEWS_HEADLINE'];
		$ywwyh[$iywwyh++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'yjtd':
		$yjtd[$iyjtd]['id'] = $row['ID'];
		$yjtd[$iyjtd]['newsid'] = $row['NEWS_ID'];
		$yjtd[$iyjtd]['headline'] = $row['NEWS_HEADLINE'];
		$yjtd[$iyjtd++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
		case 'gzzd':
		$gzzd[$igzzd]['id'] = $row['ID'];
		$gzzd[$igzzd]['newsid'] = $row['NEWS_ID'];
		$gzzd[$igzzd]['headline'] = $row['NEWS_HEADLINE'];
		$gzzd[$igzzd++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
		break;
	}
}

mysql_free_result($result);

$ixwdt = sizeof($xwdt);$ikxyj = sizeof($kxyj);$ixsjl = sizeof($xsjl);
$ircpy = sizeof($rcpy);$ishfw = sizeof($shfw);$ixtcx = sizeof($xtcx);
$icsj = sizeof($csj);$itzgg = sizeof($tzgg);$izcwj = sizeof($zcwj);
$izyxz = sizeof($zyxz);$ilxwm = sizeof($lxwm);$iyjyjj = sizeof($yjyjj);
$izzjg = sizeof($zzjg);$ilsh = sizeof($lsh);$ixswyh = sizeof($xswyh);
$iywwyh = sizeof($ywwyh);$iyjtd = sizeof($yjtd);$igzzd = sizeof($gzzd);

//获取每种类别数据的页码（20条记录为1页）
$pagexwdt = $ixwdt % 20 == 0 ? $ixwdt / 20 : ($ixwdt - $ixwdt % 20) / 20 + 1;
$pagekxyj = $ikxyj % 20 == 0 ? $ikxyj / 20 : ($ikxyj - $ikxyj % 20) / 20 + 1;
$pagexsjl = $ixsjl % 20 == 0 ? $ixsjl / 20 : ($ixsjl - $ixsjl % 20) / 20 + 1;
$pagercpy = $ircpy % 20 == 0 ? $ircpy / 20 : ($ircpy - $ircpy % 20) / 20 + 1;
$pageshfw = $ishfw % 20 == 0 ? $ishfw / 20 : ($ishfw - $ishfw % 20) / 20 + 1;
$pagextcx = $ixtcx % 20 == 0 ? $ixtcx / 20 : ($ixtcx - $ixtcx % 20) / 20 + 1;
$pagecsj = $icsj % 20 == 0 ? $icsj / 20 : ($icsj - $icsj % 20) / 20 + 1;
$pagetzgg = $itzgg % 20 == 0 ? $itzgg / 20 : ($itzgg - $itzgg % 20) / 20 + 1;
$pagezcwj = $izcwj % 20 == 0 ? $izcwj / 20 : ($izcwj - $izcwj % 20) / 20 + 1;
$pagezyxz = $izyxz % 20 == 0 ? $izyxz / 20 : ($izyxz - $izyxz % 20) / 20 + 1;
$pagelxwm = $ilxwm % 20 == 0 ? $ilxwm / 20 : ($ilxwm - $ilxwm % 20) / 20 + 1;
$pageyjyjj = $iyjyjj % 20 == 0 ? $iyjyjj / 20 : ($iyjyjj - $iyjyjj % 20) / 20 + 1;
$pagezzjg = $izzjg % 20 == 0 ? $izzjg / 20 : ($izzjg - $izzjg % 20) / 20 + 1;
$pagelsh = $ilsh % 20 == 0 ? $ilsh / 20 : ($ilsh - $ilsh % 20) / 20 + 1;
$pagexswyh = $ixswyh % 20 == 0 ? $ixswyh / 20 : ($ixswyh - $ixswyh % 20) / 20 + 1;
$pageywwyh = $iywwyh % 20 == 0 ? $iywwyh / 20 : ($iywwyh - $iywwyh % 20) / 20 + 1;
$pageyjtd = $iyjtd % 20 == 0 ? $iyjtd / 20 : ($iyjtd - $iyjtd % 20) / 20 + 1;
$pagegzzd = $igzzd % 20 == 0 ? $igzzd / 20 : ($igzzd - $igzzd % 20) / 20 + 1;
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>信息管理</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/list.css"/>
	<link rel="stylesheet" href="css/common.css"/>
	<link rel="stylesheet" href="css/manage.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	//将php中的数据存放到json中
	var xwdt = <?php echo json_encode($xwdt);?>;
	var kxyj = <?php echo json_encode($kxyj);?>;
	var xsjl = <?php echo json_encode($xsjl);?>;
	var rcpy = <?php echo json_encode($rcpy);?>;
	var shfw = <?php echo json_encode($shfw);?>;
	var xtcx = <?php echo json_encode($xtcx);?>;
	var csj = <?php echo json_encode($csj);?>;
	var tzgg = <?php echo json_encode($tzgg);?>;
	var zcwj = <?php echo json_encode($zcwj);?>;
	var zyxz = <?php echo json_encode($zyxz);?>;
	var lxwm = <?php echo json_encode($lxwm);?>;
	var yjyjj = <?php echo json_encode($yjyjj);?>;
	var zzjg = <?php echo json_encode($zzjg);?>;
	var lsh = <?php echo json_encode($lsh);?>;
	var xswyh = <?php echo json_encode($xswyh);?>;
	var ywwyh = <?php echo json_encode($ywwyh);?>;
	var yjtd = <?php echo json_encode($yjtd);?>;
	var gzzd = <?php echo json_encode($gzzd);?>;

	//各类数据的页数
	var pagexwdt = <?php echo $pagexwdt;?>;
	var pagekxyj = <?php echo $pagekxyj;?>;
	var pagexsjl = <?php echo $pagexsjl;?>;
	var pagercpy = <?php echo $pagercpy;?>;
	var pageshfw = <?php echo $pageshfw;?>;
	var pagextcx = <?php echo $pagextcx;?>;
	var pagecsj = <?php echo $pagecsj;?>;
	var pagetzgg = <?php echo $pagetzgg;?>;
	var pagezcwj = <?php echo $pagezcwj;?>;
	var pagezyxz = <?php echo $pagezyxz;?>;
	var pagelxwm = <?php echo $pagelxwm;?>;
	var pageyjyjj = <?php echo $pageyjyjj;?>;
	var pagezzjg = <?php echo $pagezzjg;?>;
	var pagelsh = <?php echo $pagelsh;?>;
	var pagexswyh = <?php echo $pagexswyh;?>;
	var pageywwyh = <?php echo $pageywwyh;?>;
	var pageyjtd = <?php echo $pageyjtd;?>;
	var pagegzzd = <?php echo $pagegzzd;?>;
	var pageNow = 1;
	$(function(){
		$('.nav-li').click(function(){
			//点击tab时，首先判断当前显示是否为点击的tab，如果不是，则切换至点击的tab
			if(!$(this).hasClass('active')){
				var id
				$('.nav-li').removeClass('active')
				$(this).addClass('active')

				//判断点击的tab是否为关于我们，如果是，则分类为研究院简介
				if($(this).attr('id') == 'gywm'){
					$('#nav-list').show('normal')
					$('#nav-list li').removeClass('active')
					$('#yjyjj').addClass('active')
					id='yjyjj'
				}else{//如果不是，则分类为点击tab的对应分类
					$('#nav-list').hide('normal')
					id = $(this).attr('id')	
				}

				//获取到相应tab的首页数据，并加载到表格中
				$('.item-list tbody').empty()
				for(var i = 0;i < 20 && i < eval(id).length; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}

				//修改页码显示
				pageNow = 1
				$('#page-now').html(pageNow)
				$('#page-all').html(eval('page'+id))				
			}
		})
		$('#nav-list li').click(function(){
			//关于我们的子tab点击处理
			if(!$(this).hasClass('active')){
				$('#nav-list li').removeClass('active')
				$(this).addClass('active')
				var id = $(this).attr('id')
				$('.item-list tbody').empty()
				for(var i = 0;i < 20 && i < eval(id).length; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}
				pageNow = 1
				$('#page-now').html(pageNow)
				$('#page-all').html(eval('page'+id))
			}
		})
		$('#prev').click(function(){
			//点击上一页时，首先判断当前页面是否为第一页，如为第一页，则无处理
			if(pageNow > 1){
				//当前页面不是第一页，获取当前tab的id，方便取数据
				var id = $('.nav-li.active').attr('id')
				$('.item-list tbody').empty()
				pageNow--
				for(var i = pageNow * 20 - 20; i < pageNow * 20; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}				
				$('#page-now').html(pageNow)				
			}
		})
		$('#next').click(function(){
			//点击下一页时，先判断当前页面是否为当前tab的最后一页
			var id = $('.nav-li.active').attr('id')
			if(pageNow < eval('page'+id)){
				$('.item-list tbody').empty()
				for(var i = pageNow * 20;i < pageNow * 20 + 20 && i < eval(id).length; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}
				pageNow++
				$('#page-now').html(pageNow)
			}
		})
		$('#first').click(function(){
			//首页加载，类似首次加载
			if(pageNow != 1){
				var id = $('.nav-li.active').attr('id')
				$('.item-list tbody').empty()
				for(var i = 0;i < 20 && i < eval(id).length; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}
				pageNow = 1
				$('#page-now').html(pageNow)
			}
		})
		$('#last').click(function(){
			//末页加载，类似首页加载
			var id = $('.nav-li.active').attr('id')
			if(pageNow != eval('page'+id)){
				$('.item-list tbody').empty()
				pageNow = eval('page'+id)
				for(var i = pageNow * 20 - 20;i < pageNow * 20 && i < eval(id).length; i++){
					var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
					$('.item-list tbody').append(html)
				}				
				$('#page-now').html(pageNow)
			}
		})
		$('#any').click(function(){
			//跳转至任意页面，跳转的数字必须在1到当前分类最大页码之间
			var id = $('.nav-li.active').attr('id')
			if($('#goto').val() >= 1 && $('#goto').val() <= eval('page'+id)){
				var anyPage = $('#goto').val()
				$('#goto').val('')
				if(pageNow != anyPage){
					//如果跳转到的页面等于当前页面，则不作处理
					$('.item-list tbody').empty()
					pageNow = anyPage
					for(var i = pageNow * 20 - 20;i < pageNow * 20 && i < eval(id).length; i++){
						var html = "<tr id='"+eval(id)[i]['id']+"'><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+id+"/"+eval(id)[i]['newsid']+".html'>"+eval(id)[i]['headline']+"</a></td><td class='table-date'>"+eval(id)[i]['time']+"</td><td class='table-edit'><i class='icon-edit'></i></td><td class='table-delete'><i class='icon-trash'></i></td></tr>"
						$('.item-list tbody').append(html)
					}
					$('#page-now').html(pageNow)
				}
			}else{
				$('#goto').parent().addClass('has-error')
			}
		})
		$('#goto').blur(function(){
			if($('#goto').parent().hasClass('has-error')){
				$('#goto').parent().removeClass('has-error')
			}
		})
		$('div').delegate('.table-delete','click',function(){
			var id = $(this).parent().attr('id')
			$('.modal-body').attr('id',id)
			var headline = $(this).parent().find('a').html()
			$('#modalHeadline').html(headline)
			$('#myModal').modal('show')
		})
		$('#modal-delete').click(function(){
			$('#myModal').modal('hide')
			var id = $('.modal-body').attr('id')
			$.ajax({
				url: 'php/delete.php',
				type: 'POST',
				dataType: 'json',
				data: {
					'id' : id
				},
				success: function(data) {
					if(data.status == 'success'){
						alert('删除成功！')
						location.reload() 
					}else{
						alert('删除失败！请重试！')
					}
				},
				complete: function(XMLHttpRequest, textStatus) {},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					// alert("ajax request failed" + " " + XMLHttpRequest.readyState + 
					// 	" " + XMLHttpRequest.status + " " + textStatus)
				}
			})
		})
		$('div').delegate('.table-edit','click',function(){
			var id = $(this).parent().attr('id')
			$.ajax({
				url: 'php/ajax_edit.php',
				type: 'POST',
				dataType: 'json',
				data: {
					'id' : id
				},
				success: function(data) {
					if(data.status == 'success'){
						window.open('edit.php','_self') 
					}else{}
				},
				complete: function(XMLHttpRequest, textStatus) {},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					//alert("ajax request failed" + " " + XMLHttpRequest.readyState + 
						//" " + XMLHttpRequest.status + " " + textStatus)
				}
			})
		})
	})
	</script>
</head>
<body>
	<div id='header'>
		<h1>信息管理平台</h1>
	</div>
	<div class='content'>
		<div class='nav-left'>
			<ul class='nav'>
				<li class='nav-li active' id='xwdt'><a href='#'>新闻动态</a></li>
				<li class='nav-li' id='gywm'>
					<a href="#">关于我们 <span class="caret"></span></a>
					<ul class="nav" id='nav-list'>
						<li class='active' id='yjyjj'>研究院简介</li>
						<li id='zzjg'>组织机构</li>
						<li id='lsh'>理事会</li>
						<li id='xswyh'>学术委员会</li>
						<li id='ywwyh'>院务委员会</li>
						<li id='yjtd'>研究团队</li>
						<li id='gzzd'>规章制度</li>
					</ul>
				</li>
				<li class='nav-li' id='kxyj'><a href='#'>科学研究</a></li>
				<li class='nav-li' id='xsjl'><a href='#'>学术交流</a></li>
				<li class='nav-li' id='rcpy'><a href='#'>人才培养</a></li>
				<li class='nav-li' id='shfw'><a href='#'>社会服务</a></li>
				<li class='nav-li' id='zyxz'><a href='#'>资源下载</a></li>
				<li class='nav-li' id='lxwm'><a href='#'>联系我们</a></li>
				<li class='nav-li' id='xtcx'><a href='#'>协同创新</a></li>
				<li class='nav-li' id='csj'><a href='#'>长三角</a></li>
				<li class='nav-li' id='tzgg'><a href='#'>通知公告</a></li>
				<li class='nav-li' id='zcwj'><a href='#'>政策文件</a></li>
			</ul>
		</div>
		<div class='item-list'>
			<a class='btn btn-default' id='release' href='release.php' target='_blank'>发布新内容</a>
			<table>
				<tbody>
					<?php
					for($i = 0; $i < 20 && $i < sizeof($xwdt); $i++){
						echo "<tr id='".$xwdt[$i]['id']."'><td class='table-icon'><i class='icon-play'></i></td>
						<td><a href='html/xwdt/".$xwdt[$i]['newsid'].".html'>"
						.$xwdt[$i]['headline']."</a></td>
						<td class='table-date'>".$xwdt[$i]['time']."</td>
						<td class='table-edit'><i class='icon-edit'></i></td>
						<td class='table-delete'><i class='icon-trash'></i></td></tr>";
					}
					?>
				</tbody>
			</table>
			<div class="form-inline" id="page-control">
				<button class='btn btn-default' id='first'>首页</button>
				<button class='btn btn-default' id='prev'>上一页</button>
				<span><span id='page-now'>1</span> / <span id='page-all'><?php echo $pagexwdt;?></span></span>
				<button class='btn btn-default' id='next'>下一页</button>
				<button class='btn btn-default' id='last'>末页</button>
				<input type="text" class="form-control" id="goto">
				<button class='btn btn-default' id='any'>跳转</button>
			</div>
		</div>
	</div>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">删除操作</h3>
		</div>
		<div class="modal-body">
			<p>确定要删除"<span id='modalHeadline'></span>"吗？删除后将不可恢复！</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
			<button class="btn btn-primary" id='modal-delete'>确定</button>
		</div>
	</div>
</body>
</html>