<?php
//if ($_SERVER['REQUEST METHOD'] === 'POST') die("BAD REQEUST");

session_start();

function stripstr($str) {
    $str = stripslashes(strip_tags(trim($str)));
    return $str;
}

$uploaddir = 'pictures/framed/';
$filename = stripstr($_FILES['framedpicture']['name']);
$uploadfile = $uploaddir.$filename;

if (move_uploaded_file($_FILES['framedpicture']['tmp_name'], $uploadfile)) {
    echo "$filename";
} else {
    print "Failed!\n";
}

$thumbdir = 'pictures/thumbnail/';

$imagick = new \Imagick(realpath($uploadfile));
$imagick->setbackgroundcolor('rgb(255, 255, 255)');
$imagick->thumbnailImage(140, 210, true, true);
$imagick->writeImage($thumbdir.$filename);

$_SESSION['STATUS'] = 'FIN';
$_SESSION['FILENAME'] = $filename;

?>