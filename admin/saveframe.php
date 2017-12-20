<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('upload_max_filesize', '500M');
ini_set('post_max_size','500M');

function stripstr($str) {
    $str = stripslashes(strip_tags(trim($str)));
    return $str;
}
$uploaddir = '../frame/';
$filename = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$filename;

$isuploaded = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
if($isuploaded) {
	echo("Upload success: " . $_FILES['userfile']['name']);
}
?>
