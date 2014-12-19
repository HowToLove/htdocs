<?php
session_start ();
require_once('config.php');
$con = mysql_connect(host,username,password);
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db(dbname,$con);

$username = $_POST['username'];
$password = md5(md5(md5($_POST['password'])));

$sql = "SELECT PASSWORD,SUPER FROM USER WHERE USERNAME='$username'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if($password == $row['PASSWORD']){
	echo json_encode(array('status'=>'success','sup'=>$row['SUPER']));
	$_SESSION['super'] = $row['SUPER'];
}else{
	echo json_encode(array('status'=>'failure'));
}
?>