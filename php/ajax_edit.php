<?php
session_start();
$id = $_POST['id'];
$_SESSION['editid'] = $id;
echo json_encode(array('status'=>'success'));
?>