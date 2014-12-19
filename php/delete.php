<?php
require_once('config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);

$id = $_POST['id'];

$sql = "SELECT NEWS_ID,NEWS_KIND FROM NEWS WHERE ID='$id'";
$result1 = mysql_query($sql);
$row = mysql_fetch_array($result1);
$path = "../html/".$row['NEWS_KIND']."/".$row['NEWS_ID'].".html";

$sql = "DELETE FROM NEWS WHERE ID='$id'";
$result2 = mysql_query($sql);

if($result2 && unlink($path)){
	echo json_encode(array('status'=>'success'));
}else{
	echo json_encode(array('status'=>'failure'));
}
?>