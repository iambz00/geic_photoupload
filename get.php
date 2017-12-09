<?php
if ($_SERVER['REQUEST METHOD'] === 'POST') die("BAD REQEUST");

$type = $_REQUEST['type'];
$name = stripslashes(strip_tags($_REQUEST['name']));
$filename = "";
$name = preg_replace("/^.*\//", "", $name);
if (preg_match("/\/|\\\\/", $name) > 0) {
    $filename = "pictures/badrequest.jpg";
} else {
    switch($type) {
        case "f":   // f for framed
            $filename = "pictures/framed/".$name;
            break;
        case "t":   // t for thumbnail
            $filename = "pictures/thumbnail/".$name;
    }
    if (!file_exists($filename)) $filename = "pictures/badrequest.jpg";
}
$imagick = new Imagick(realpath($filename));
header("Content-Type: ".$imagick->getImageMimeType());
echo $imagick->getImageBlob();

?>
