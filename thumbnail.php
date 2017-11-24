<?php
function stripstr($str) {
    $str = stripslashes(strip_tags(trim($str)));
    return $str;
}
$filename = 'pictures/framed/'.stripstr($_REQUEST['name']);
if (file_exists($filename)) {
    $imagick = new \Imagick(realpath($filename));
    $imagick->setbackgroundcolor('rgb(255, 255, 255)');
    $imagick->thumbnailImage(120, 180, true, true);
    header("Content-Type: image/png");
    echo $imagick->getImageBlob();
}
?>
