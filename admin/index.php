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
	padding-bottom:10px;
    background-color:#ddd;
    text-align:center;
}
img {
    margin:5px;
}
a	{
	color:#000;
	font-size:10pt;
	text-decoration:none;
}
</style>
</head>

<body>

<ul>
<?php
foreach(glob("../pictures/thumbnail/*.jpg") as $entry) {
	$entry = preg_replace("/^.*\//", "", $entry);	// strip out directory tree
	preg_match("/([\d_]{15})_(.*)\.jpg/", $entry, $matches);
	$date = date_create_from_format('Ymd_His', $matches[1]);
    ?>
    <li>
        <a href="../get.php?type=f&name=<?=urlencode($entry)?>">
            <img src="../get.php?type=t&name=<?=urlencode($entry)?>" alt=""><br>
            <?=$date->format('m-d H:i:s');?><br>
            <?=$matches[2]?>
        </a>
    </li>
    <?php
}
?>
</ul>
</body>
</html>
