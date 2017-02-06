<?php
//if ($_SERVER['REQUEST METHOD'] === 'POST') die("BAD REQEUST");

$type = $_REQUEST['type'];
$name = stripslashes(strip_tags($_REQUEST['name']));
$filename = "";

if (preg_match("/\/|\\\\/", $name) > 0) {
    $filename = "pictures/badrequest.jpg";
} else {
    switch($type) {
        case "r":   // r for raw
        case "u":   // u for raw thumbnail
            $filename = "pictures/raw/".$name;
            break;
        case "f":   // f for framed
            $filename = "pictures/framed/".$name;
            break;
        case "t":   // t for thumbnail
            $filename = "pictures/thumbnail/".$name;
    }
    if (!file_exists($filename)) $filename = "pictures/badrequest.jpg";
}
$imagick = new Imagick(realpath($filename));
if ($type == "u") {
    $imagick->setbackgroundcolor('rgb(255, 255, 255)');
    $imagick->thumbnailImage(140, 210, true, true);
}
header("Content-Type: ".$imagick->getImageMimeType());
echo $imagick->getImageBlob();

?>