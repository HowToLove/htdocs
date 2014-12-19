<?php
header("Content-Type: text/html; charset=utf-8");
require_once('php/config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);
mysql_query('set names "UTF8"',$con);
$sql = "SELECT N1.NEWS_ID, N1.NEWS_HEADLINE, N1.NEWS_TIME, N1.NEWS_KIND, N1.NEWS_CONTENT
FROM NEWS AS N1  
INNER JOIN (SELECT N.NEWS_KIND,N.ID 
	FROM NEWS AS N  
	LEFT JOIN NEWS AS B  
	ON N.NEWS_KIND = B.NEWS_KIND  
	AND N.ID <= B.ID  
	GROUP BY N.NEWS_KIND,N.ID 
	HAVING COUNT(B.ID) <= 5
	) AS B1  
ON N1.NEWS_KIND = B1.NEWS_KIND  
AND N1.ID = B1.ID 
ORDER BY N1.NEWS_KIND,N1.ID DESC";
$result = mysql_query($sql);

$currentInfo = Array();
$i = 0;

while($row = mysql_fetch_array($result)){
	$currentInfo[$i]['id'] = $row['NEWS_ID'];
	$currentInfo[$i]['headline'] = $row['NEWS_HEADLINE'];
	$currentInfo[$i]['time'] = date("Y-m-d",strtotime($row['NEWS_TIME']));
	$currentInfo[$i]['kind'] = $row['NEWS_KIND'];
	$currentInfo[$i++]['content'] = $row['NEWS_CONTENT'];
}

mysql_free_result($result);
// $result = json_encode($currentInfo);

$sql = "SELECT NEWS_ID, NEWS_HEADLINE, NEWS_CONTENT
FROM NEWS
WHERE NEWS_KIND='xwdt'
ORDER BY ID DESC";
$result = mysql_query($sql);

$currentNews = Array();
$i = 0;
while($row = mysql_fetch_array($result)){
	if(preg_match('#<img(?![^<>]*?/ueditor/[^<>]*?>).*?>#iUs', $row['NEWS_CONTENT'], $out1)){
		preg_match('/src=\".*\"/iUs', $out1[0], $out2);
		$img=$out2[0];
		$currentNews[$i]['id'] = $row['NEWS_ID'];
		$currentNews[$i]['headline'] = $row['NEWS_HEADLINE'];
		$currentNews[$i++]['img'] = $img;
	}
}
mysql_free_result($result);
$time = strtotime(date('Y-m-d H:i:s',time()));
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>合肥区域经济与城市发展研究院&nbsp&nbsp安徽大学区域经济与城市发展协同创新中心</title>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="css/index.css"/>
	<link rel="stylesheet" href="css/nav.css"/>
	<link rel="stylesheet" href="css/common.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
		$('.carousel').carousel({
			interval: 5000
		});

		$('.carousel').carousel('cycle');
	});
	</script>
</head>
<body>
	<?php include 'header.html';?>
	<div id="carousel-img" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carousel-img" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-img" data-slide-to="1"></li>
			<li data-target="#carousel-img" data-slide-to="2"></li>
			<li data-target="#carousel-img" data-slide-to="3"></li>
			<li data-target="#carousel-img" data-slide-to="4"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="item active"><img src="img/1.jpg"></div>
			<div class="item"><img src="img/2.jpg"></div>
			<div class="item"><img src="img/3.jpg"></div>
			<div class="item"><img src="img/4.jpg"></div>
			<div class="item"><img src="img/5.jpg"></div>
		</div>
	</div>
	<div id='news'>
		<div id='news-left'>
			<div id="carousel-news" class="carousel slide" data-ride="carousel">
				<!-- <div class='news-mask'></div> -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-news" data-slide-to="0" class="active">1</li>
					<li data-target="#carousel-news" data-slide-to="1">2</li>
					<li data-target="#carousel-news" data-slide-to="2">3</li>
					<li data-target="#carousel-news" data-slide-to="3">4</li>
					<li data-target="#carousel-news" data-slide-to="4">5</li>					
				</ol>
				<div class="carousel-inner" role="listbox">
					<?php
					if(sizeof($currentNews) != 0){
						echo "<div class='item active'><a href='html/xwdt/".$currentNews[0]['id'].".html' title=".$currentNews[0]['headline']."><img ".$currentNews[0]['img']."></a><div class='carousel-caption'><p>".$currentNews[0]['headline']."</p></div></div>";			
						for($i = 1; $i < 5 && $i < sizeof($currentNews); $i++){
							echo "<div class='item'><a href='html/xwdt/".$currentNews[$i]['id'].".html' title=".$currentNews[$i]['headline']."><img ".$currentNews[$i]['img']."></a><div class='carousel-caption'><p>".$currentNews[$i]['headline']."</p></div></div>";			
						}
					}
					?>
				</div>
			</div>
		</div>
		<div id='news-right' class="item-list">
			<h4>新闻动态<span><a href="xwdt.php">More...</a></span></h4>
			<table id='table-xwdt'>
				<tbody>
					<?php
					for($i = 0; $i < sizeof($currentInfo); $i++){
						if($currentInfo[$i]['kind'] == 'xwdt'){
							if(($time - strtotime($currentInfo[$i]['time'])) < 86400){
								echo "<tr><td class='table-icon'>
									<i class='icon-play'></i></td>
									<td class='table-title'><a href='html/xwdt/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
									.$currentInfo[$i]['headline']."</a></td>
									<td class='table-date'><img src='img/new.gif'/>".$currentInfo[$i]['time']."</td></tr>";
							}else{
								echo "<tr><td class='table-icon'>
									<i class='icon-play'></i></td>
									<td class='table-title'><a href='html/xwdt/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
									.$currentInfo[$i]['headline']."</a></td>
									<td class='table-date'>".$currentInfo[$i]['time']."</td></tr>";
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div id='sub'>
		<div id='sub-left'>
			<div class="item-list" id='kxyj'>
				<h4>科学研究<span><a href="kxyj.php">More...</a></span></h4>
				<table id='table-kxyj'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'kxyj')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/kxyj/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="item-list" id='xsjl'>
				<h4>学术交流<span><a href="xsjl.php">More...</a></span></h4>
				<table id='table-xsjl'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'xsjl')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/xsjl/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="item-list" id='rcpy'>
				<h4>人才培养<span><a href="rcpy.php">More...</a></span></h4>
				<table id='table-rcpy'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'rcpy')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/rcpy/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="item-list" id='shfw'>
				<h4>社会服务<span><a href="shfw.php">More...</a></span></h4>
				<table id='table-shfw'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'shfw')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/shfw/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="item-list" id='xtcx'>
				<h4>协同创新<span><a href="xtcx.php">More...</a></span></h4>
				<table id='table-xtcx'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'xtcx')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/xtcx/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="item-list" id='csj'>
				<h4>长三角<span><a href="csj.php">More...</a></span></h4>
				<table id='table-csj'>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'csj')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/csj/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div id='sub-right'>
			<div class='sub-right-block item-list'>
				<h4>通知公告<span><a href="tzgg.php">More...</a></span></h4>
				<table>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'tzgg'){
								if(($time - strtotime($currentInfo[$i]['time'])) < 86400){
									echo "<tr><td class='table-icon'>
										<i class='icon-play'></i></td>
										<td class='table-title'><a href='html/tzgg/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
										.$currentInfo[$i]['headline']."</a></td><td class='table-new'><img src='img/new.gif'/></td></tr>";
								}else{
									echo "<tr><td class='table-icon'>
										<i class='icon-play'></i></td>
										<td class='table-title'><a href='html/tzgg/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
										.$currentInfo[$i]['headline']."</a></td><td class='table-new'></td></tr>";
								}
							}
								
						}
						?>
					</tbody>
				</table>
			</div>
			<div class='sub-right-block'>
				<h4>研究团队<span><a href="gywm.php">More...</a></span></h4>
				<ul>
					<?php
					for($i = 0; $i < sizeof($currentInfo); $i++){
						if($currentInfo[$i]['kind'] == 'yjtd')
							echo "<li><a href='html/yjtd/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
						.$currentInfo[$i]['headline']."</a></li>";
					}
					?>
				</ul>
			</div>
			<div class='sub-right-block item-list'>
				<h4>政策文件<span><a href="zcwj.php">More...</a></span></h4>
				<table>
					<tbody>
						<?php
						for($i = 0; $i < sizeof($currentInfo); $i++){
							if($currentInfo[$i]['kind'] == 'zcwj')
								echo "<tr><td class='table-icon'>
							<i class='icon-play'></i></td>
							<td class='table-title'><a href='html/zcwj/".$currentInfo[$i]['id'].".html' title=".$currentInfo[$i]['headline'].">"
							.$currentInfo[$i]['headline']."</a></td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
			<script>
			function g(formname){
				var url = "http://www.baidu.com/baidu";
				if (formname.s[0].checked) {
					formname.ct.value = "2097152";
				}
				else {
					formname.ct.value = "0";
				}
				formname.action = url;
				return true;
			}
			</script>
			<form name="f1" onsubmit="return g(this)" id='search' class="form-inline" role="form">
				<input name=word type='text' class='form-control' placeholder='请输入关键字'>
				<input type="submit" value="搜索" class='btn btn-default' style='font-family:微软雅黑'>
				<input name=tn type=hidden value="bds">
				<input name=cl type=hidden value="3">
				<input name=ct type=hidden>
				<input name=si type=hidden value="reud.ahu.edu.cn">
				<input name=ie type=hidden value="utf-8">
				<label class="radio-inline">
					<input name=s type=radio checked>搜本站
				</label>
				<label class="radio-inline">
					<input name=s type=radio>搜全网
				</label>
			</form>

			<select name="select" id="friend-link" onchange="window.open(this.options[this.selectedIndex].value)">
				<option value="#">——————友情链接——————</option>
				<option value="http://www.gov.cn">中国政府网</option>
				<option value="http://www.sdpc.gov.cn">国家发展和改革委员会</option>
				<option value="http://www.ah.gov.cn">安徽省人民政府</option>
				<option value="http://www.ahpc.gov.cn">安徽省发展和改革委员会</option>
				<option value="http://www.aheic.gov.cn">安徽省经济和信息化委员会</option>
				<option value="http://www.ahjh.gov.cn">安徽合作交流网</option>
				<option value="http://www.hefei.gov.cn">合肥市人民政府</option>
				<option value="http://swzys.hefei.gov.cn">中共合肥市委政策研究室</option>
				<option value="http://www.hfdpc.gov.cn">合肥市发展和改革委员会</option>
				<option value="http://www.hfcz.gov.cn">合肥市财政局</option>
				<option value="http://www.hfst.gov.cn">合肥市科技局</option>
				<option value="http://sskl.hefei.gov.cn">合肥市社科联</option>
			</select>
		</div>
	</div>
	<?php include 'footer.html'?>
</body>
</html>