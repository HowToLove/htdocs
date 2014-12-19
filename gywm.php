<?php 
if(isset($_GET['kind'])){
	$kind = $_GET['kind'];
}else{
	$kind = 'yjyjj';
}
header("Content-Type: text/html; charset=utf-8");
require_once('php/config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);
mysql_query('set names "UTF8"',$con);

$sql = "SELECT NEWS_ID, NEWS_HEADLINE, NEWS_TIME, NEWS_KIND
FROM NEWS 
WHERE NEWS_KIND = 'yjyjj' OR NEWS_KIND='zzjg' OR NEWS_KIND='lsh'
OR NEWS_KIND='xswyh' OR NEWS_KIND='ywwyh' OR NEWS_KIND='yjtd' OR NEWS_KIND='gzzd'
ORDER BY ID DESC";
$result = mysql_query($sql);

$currentInfo = Array();
$i = 0;
$count = 0;
while($row = mysql_fetch_array($result)){
	$currentInfo[$count]['id'] = $row['NEWS_ID'];
	$currentInfo[$count]['headline'] = $row['NEWS_HEADLINE'];
	$currentInfo[$count]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
	$currentInfo[$count++]['kind'] = $row['NEWS_KIND'];
}

mysql_free_result($result);
$result = json_encode($currentInfo);
$count = sizeof($currentInfo);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>关于我们</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/list.css"/>
	<link rel="stylesheet" href="css/nav.css"/>
	<link rel="stylesheet" href="css/common.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	var item = <?php echo $result;?>;
	var count = <?php echo $count;?>;
	var kind = '<?php echo $kind;?>';
	$(function(){
		$('#nav-list li').click(function(){
			if(!$(this).hasClass('active')){
				$('#nav-list li').removeClass('active')
				$(this).addClass('active')
				$('.item-list tbody').empty()
				for(var i = 0; i < count; i++){
					if(item[i]['kind'] == $(this).attr('id')){
						var html = "<tr><td class='table-icon'><i class='icon-play'></i></td><td><a href='html/"+item[i]['kind']+"/"+item[i]['id']+".html'>"+item[i]['headline']+"</a></td><td class='table-date'>"+item[i]['time']+"</td></tr>"
						$('.item-list tbody').append(html)
					}
				}
			}
		})
		$('#'+kind).click()
	})
	</script>
</head>
<body>
	<?php include 'header.html';?>
	<div class='content'>
		<div class='nav-left'>
			<ul class='nav'>
				<li class='nav-li'><a href='xwdt.php'>新闻动态</a></li>
				<li class='nav-li active'>
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
				<li class='nav-li'><a href='kxyj.php'>科学研究</a></li>
				<li class='nav-li'><a href='xsjl.php'>学术交流</a></li>
				<li class='nav-li'><a href='rcpy.php'>人才培养</a></li>
				<li class='nav-li'><a href='shfw.php'>社会服务</a></li>
				<li class='nav-li'><a href='zyxz.php'>资源下载</a></li>
				<li class='nav-li'><a href='lxwm.php'>联系我们</a></li>
				<li class='nav-li'><a href='xtcx.php'>协同创新</a></li>
				<li class='nav-li'><a href='csj.php'>长三角</a></li>
				<li class='nav-li'><a href='tzgg.php'>通知公告</a></li>
				<li class='nav-li'><a href='zcwj.php'>政策文件</a></li>
			</ul>
		</div>
		<div class='item-list'>
			<table>
				<tbody>
					<?php
					for(; $i < 20 && $i < sizeof($currentInfo); $i++){
						if($currentInfo[$i]['kind']=='yjyjj'){
							echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td><a href='html/yjyjj/".$currentInfo[$i]['id'].".html'>"
							.$currentInfo[$i]['headline']."</a></td>
							<td class='table-date'>".$currentInfo[$i]['time']."</td></tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php include 'footer.html'?>
</body>
</html>