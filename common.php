<?php
$str = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
$kind = substr($str, 0, strrpos($str,'.'));

header("Content-Type: text/html; charset=utf-8");
require_once('php/config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);
mysql_query('set names "UTF8"',$con);

$sql = "SELECT NEWS_ID, NEWS_HEADLINE, NEWS_TIME
FROM NEWS 
WHERE NEWS_KIND = '$kind'
ORDER BY ID DESC";
$result = mysql_query($sql);

$currentInfo = Array();
$i = 0;
$count = 0;
while($row = mysql_fetch_array($result)){
	$currentInfo[$count]['id'] = $row['NEWS_ID'];
	$currentInfo[$count]['headline'] = $row['NEWS_HEADLINE'];
	$currentInfo[$count++]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
}

mysql_free_result($result);
$result = json_encode($currentInfo);

$count = sizeof($currentInfo);
if($count % 20==0)
	$page = $count/20;
else
	$page = ($count-$count%20)/20+1;

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/list.css"/>
	<link rel="stylesheet" href="css/nav.css"/>
	<link rel="stylesheet" href="css/common.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	var item = <?php echo $result;?>;
	var page = <?php echo $page;?>;
	var kind = '<?php echo $kind;?>';
	var pageNow = 1
	var i = 20
	var len = item.length
	switch(kind){
		case 'xwdt':
		document.title = '新闻动态';
		break;
		case 'kxyj':
		document.title = '科学研究';
		break;
		case 'xsjl':
		document.title = '学术交流';
		break;
		case 'rcpy':
		document.title = '人才培养';
		break;
		case 'shfw':
		document.title = '社会服务';
		break;
		case 'zyxz':
		document.title = '资源下载';
		break;
		case 'lxwm':
		document.title = '联系我们';
		break;
		case 'xtcx':
		document.title = '协同创新';
		break;
		case 'csj':
		document.title = '长三角';
		break;
		case 'tzgg':
		document.title = '通知公告';
		break;
		case 'zcwj':
		document.title = '政策文件';
		break;
	}
	$(function(){
		$('#'+kind).addClass('active');
		$('#'+kind+' a').attr('href','#');
		$('#prev').click(function(){
			if(pageNow > 1){
				$('.item-list tbody').empty()
				pageNow--
				for(var i = pageNow * 20 - 20; i < pageNow * 20; i++){
					var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+kind+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
					$('.item-list tbody').append(html)
				}				
				$('#page-now').html(pageNow)				
			}
		})
		$('#next').click(function(){
			if(pageNow < page){
				$('.item-list tbody').empty()
				for(var i = pageNow * 20;i < pageNow * 20 + 20 && i < item.length; i++){
					var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+kind+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
					$('.item-list tbody').append(html)
				}
				pageNow++
				$('#page-now').html(pageNow)
			}
		})
		$('#first').click(function(){
			if(pageNow != 1){
				$('.item-list tbody').empty()
				for(var i = 0;i < 20 && i < item.length; i++){
					var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+kind+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
					$('.item-list tbody').append(html)
				}
				pageNow = 1
				$('#page-now').html(pageNow)
			}
		})
		$('#last').click(function(){
			if(pageNow != page){
				$('.item-list tbody').empty()
				pageNow = page
				for(var i = pageNow * 20 - 20;i < pageNow * 20 && i < item.length; i++){
					var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+kind+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
					$('.item-list tbody').append(html)
				}

				$('#page-now').html(pageNow)
			}
		})
		$('#any').click(function(){
			if($('#goto').val() >= 1 && $('#goto').val() <= page){
				var anyPage = $('#goto').val()
				$('#goto').val('')
				if(pageNow != anyPage){
					$('.item-list tbody').empty()
					pageNow = anyPage
					for(var i = pageNow * 20 - 20;i < pageNow * 20 && i < item.length; i++){
						var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+kind+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
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
	})
</script>
</head>
<body>
	<?php include 'header.html';?>
	<div class='content'>
		<div class='item-list'>
			<table>
				<tbody>
					<?php
					for(; $i < 20 && $i < $count; $i++){
						echo "<tr><td class='table-icon'>
						<i class='icon-play'></i></td>
						<td><a href='html/".$kind."/".$currentInfo[$i]['id'].".html'>"
						.$currentInfo[$i]['headline']."</a></td>
						<td class='table-date'>".$currentInfo[$i]['time']."</td></tr>";
					}
					?>
				</tbody>
			</table>
			<div class="form-inline" id="page-control">
				<button class='btn btn-default' id='first'>首页</button>
				<button class='btn btn-default' id='prev'>上一页</button>
				<span><span id='page-now'>1</span> / <?php echo $page;?></span>
				<button class='btn btn-default' id='next'>下一页</button>
				<button class='btn btn-default' id='last'>末页</button>
				<input type="text" class="form-control" id="goto">
				<button class='btn btn-default' id='any'>跳转</button>
			</div>
		</div>
		<div class='nav-left'>
			<ul class='nav'>
				<li class='nav-li' id='xwdt'><a href='xwdt.php'>新闻动态</a></li>
				<li class='nav-li' id='gywm'><a href='gywm.php'>关于我们</a></li>
				<li class='nav-li' id='kxyj'><a href='kxyj.php'>科学研究</a></li>
				<li class='nav-li' id='xsjl'><a href='xsjl.php'>学术交流</a></li>
				<li class='nav-li' id='rcpy'><a href='rcpy.php'>人才培养</a></li>
				<li class='nav-li' id='shfw'><a href='shfw.php'>社会服务</a></li>
				<li class='nav-li' id='zyxz'><a href='zyxz.php'>资源下载</a></li>
				<li class='nav-li' id='lxwm'><a href='lxwm.php'>联系我们</a></li>
				<li class='nav-li' id='xtcx'><a href='xtcx.php'>协同创新</a></li>
				<li class='nav-li' id='csj'><a href='csj.php'>长三角</a></li>
				<li class='nav-li' id='tzgg'><a href='tzgg.php'>通知公告</a></li>
				<li class='nav-li' id='zcwj'><a href='zcwj.php'>政策文件</a></li>
			</ul>
		</div>
	</div>
	<?php include 'footer.html';?>
</body>
</html>