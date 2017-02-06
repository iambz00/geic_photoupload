<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>사진 인화 서비스</title>

<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<!--<link rel="stylesheet" href="lib/jqm-theme/flatui/jquery.mobile.flatui.css">-->
<!--<link rel="stylesheet" href="lib/jqm-theme/nativeDroid/css/nativedroid2.css">-->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
.alignright {
	text-align:right;
	padding-right:10px;
}
.alignleft {
	text-align:left;
	padding-left:10px;
}
.aligncenter {
	text-align:center;
}
progress {
	 width:96%; height:30px; margin-top:15px; vertical-align:middle;
}
.ui-block-6 {
	width:60%;
	clear:left;
	float:left;
}
.ui-block-4 {
	width:40%;
	float:left;
}
</style>
<?php
session_start();
?>
</head>

<body>
<div data-role="page" data-theme="a" data-content-theme="a" data-position="fixed">
	<div data-role="header">
		<a class="ui-btn ui-icon-home ui-btn-icon-notext ui-corner-all"></a>
		<h1>사진 인화 서비스</h1>
	</div>
	<div role="main" class="ui-content">
		<div>
			안 내 내 용
		</div>
<?php
$status = $_SESSION['STATUS'];
switch($status) {
	case "FIN":

?>
		FIN
		<img src="get.php?type=t&name=<?=$_SESSION['FILENAME']?>"></img>
<?php
		break;
	case "RAW":
?>
		RAW
		<img src="get.php?type=r&name=<?=$_SESSION['FILENAME']?>" style="width:140px;"></img>
<?php
}
?>
		<div>
			<a data-ajax="false" href="edit.php" class="ui-btn">사진 편집하러 가기</a>
		</div>
	</div>
	<div data-role="footer" data-position="fixed">
		<h4>경상북도교육정보센터</h4>
	</div>
</div>
<div class="ui-hidden">
	<form data-ajax="false" id="frm2_body" method="POST" action="geic_edit.php">
		<input type="text" name="filename" readOnly />
		<input type="text" name="rotation" readOnly />
	</form>
</div>

<script type="text/javascript">
var $ = $
$(document).ready(function() {
	//$('#btn_submit').button('disable')
})
</script>
</body>

</html>
