<!DOCTYPE html>
<html lang="ko">

<head>
<meta charset="utf-8">
<title>사진 목록</title>
<style type="text/css">
li {
    float:left;
    list-style-type:none;
    margin:3px;
    padding:3px;
    background-color:#ccc;
    text-align:center;
}
img {
    border:2px solid black;
    margin:5px;
}
</style>
</head>

<body>

</body>

</html><ul>
<?php

if ($handle = opendir('./pictures/thumbnail')) {
    while (false !== ($entry = readdir($handle))) {
        if (substr($entry,-4) == ".jpg") { // .jpg only
            preg_match("/([\d_]{15})_(.*)\.jpg/", $entry, $matches);
            $date = date_create_from_format('Ymd_His', $matches[1]);
    ?>
    <li>
        <a href="get.php?type=f&name=<?=$entry?>">
            <img src="get.php?type=t&name=<?=$entry?>" alt=""><br>
            <?=$date->format('m-d H:i:s');?><br>
            <?=$matches[2]?>
        </a>
    </li>
    <?php
        }
    }
    closedir($handle);
}
?>
</ul>
