<?php
require_once('config.php');
header("content-type:text/html; charset=utf-8");
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);

$id = $_POST['id'];
$newsid = $_POST['newsid'];
$headline = iconv('UTF-8','gb2312//IGNORE',$_POST['headline']);
$content = iconv('UTF-8','gb2312//IGNORE',$_POST['content']);
$kind = $_POST['kind'];
$author = iconv('UTF-8','gb2312//IGNORE',$_POST['author']);

$sql = "SELECT NEWS_ID,NEWS_KIND FROM NEWS WHERE ID='$id'";
$result1 = mysql_query($sql);
$row = mysql_fetch_array($result1);
$path1 = "../html/".$row['NEWS_KIND']."/".$row['NEWS_ID'].".html";
unlink($path1);

mysql_query("set names 'gbk'");

$sql = "UPDATE NEWS 
SET NEWS_HEADLINE='$headline',NEWS_CONTENT='$content',NEWS_KIND='$kind',NEWS_AUTHOR='$author'
WHERE ID='$id'";
$result = mysql_query($sql);
if($result){
	echo json_encode(array('status'=>'success'));
}else{
	echo json_encode(array('status'=>'failure'));
}

$sql = "SELECT NEWS_ID, NEWS_HEADLINE, NEWS_CONTENT, NEWS_TIME, NEWS_AUTHOR, NEWS_KIND
FROM NEWS 
WHERE ID='$id'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
    $headline = iconv('gbk//IGNORE','UTF-8',$row['NEWS_HEADLINE']);    //从数据库中取出新闻标题存放到变量$title中
    $content = iconv('gbk//IGNORE','UTF-8',$row['NEWS_CONTENT']);   //从数据库中取出新闻内容存放到变量$content中
    $author = iconv('gbk//IGNORE','UTF-8',$row['NEWS_AUTHOR']);
    $time = date("Y-m-d",strtotime($row['NEWS_TIME']));
    $kind = $row['NEWS_KIND'];
    $path = "../html/".$kind."/".$row['NEWS_ID'].".html";   //根据新闻id来生成新闻路径
    switch ($kind) {
        case 'xwdt':
        $kind = '新闻动态';break;
        case 'kxyj':
        $kind = '科学研究';break;
        case 'xsjl':
        $kind = '学术交流';break;
        case 'rcpy':
        $kind = '人才培养';break;
        case 'shfw':
        $kind = '社会服务';break;
        case 'xtcx':
        $kind = '协同创新';break;
        case 'csj':
        $kind = '长三角';break;
        case 'tzgg':
        $kind = '通知公告';break;
        case 'zcwj':
        $kind = '政策文件';break;
        case 'zyxz':
        $kind = '资源下载';break;
        case 'lxwm':
        $kind = '联系我们';break;
        case 'yjyjj':
        $kind = '研究院简介';break;
        case 'zzjg':
        $kind = '组织机构';break;
        case 'lsh':
        $kind = '理事会';break;
        case 'xswyh':
        $kind = '学术委员会';break;
        case 'ywwyh':
        $kind = '院务委员会';break;
        case 'yjtd':
        $kind = '研究团队';break;
        case 'gzzd':
        $kind = '规章制度';break;
    }
    $fp = fopen("tpl.html", "r");  //一只读方式打开模板文件
    $str = fread($fp, filesize("tpl.html"));   //读取模板文件中的全部内容
    $str = str_replace("{title}", $headline, $str);
    $str = str_replace("{headline}", $headline, $str);   //用存储在变量$title中的新闻标题替换模板中的标题
    $str = str_replace("{content}", $content, $str);  //用存储在变量$content中的新闻内容替换模板中的内容
    $str = str_replace("{kind}", $kind, $str); 
    $str = str_replace("{author}", $author, $str); 
    $str = str_replace("{time}", $time, $str); 
    fclose($fp);    //关闭模板文件
    $handle = fopen($path, "w");   //写入方式打开新闻路径
    fwrite($handle, $str);     //把刚才替换的内容写入生成的html文件
    fclose($handle);     //关闭文件
}
?>