<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>액자 편집</title>

<style type="text/css">
.thumbnail {
	width:240px;
	height:auto;
	border:2px solid #000;
}
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
a   {
    color:#000;
    font-size:10pt;
    text-decoration:none;
}

</style>
</head>
<body>
<form enctype="multipart/form-data" method="POST" action="s.php">
	<input type="file" name="userfile" id="frm_file" accept="image/png"/>
	<input type="submit" value="Submit"/>
</form>

<ul>
<?php
foreach(glob("../frame/*.png") as $filepath) {
?>
	<li>
		<a href="<?=$filepath?>">
			<img src="<?=$filepath?>" class="thumbnail"/><br>
			<?=preg_replace("/^.*\//", "", $filepath)?><br>
	</li>
<?php
}
?>
</ul>
</body>
</html>

