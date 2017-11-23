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
		<h1>사진 출력 서비스</h1>
	</div>
	<div role="main" class="ui-content aligncenter">

		<ul data-role="listview" data-inset="true">
			<li data-role="list-divider">안내</li>
			<li>
				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p>
						안내 내용 1<br>
						안내 내용 2<br>
						안내 내용 3<br>
						안내 내용 4<br>
						</p>
					</div>
				</div>
			</li>
<?php
$status = $_SESSION['STATUS'];
if($status == "FIN") {
		$filename = $_SESSION['FILENAME'];
		$filetime = substr($filename,9,2) . ":" . substr($filename,11,2) . ":" . substr($filename,13,2);
		$filetitle = substr($filename,16);
?>
			<li data-role="list-divider">업로드한 사진</li>
			<li>
				<div class="ui-grid-a aligncenter">
					<img src="get.php?type=t&name=<?=$filename?>"></img>
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p class="alignright"><strong>사진 제목</strong></p>
					</div>
					<div class="ui-block-b">
						<p class="alignleft"><?=$filetitle?></p>
					</div>
				</div>

				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p class="alignright"><strong>업로드 시간</strong></p>
					</div>
					<div class="ui-block-b">
						<p class="alignleft"><?=$filetime?></p>
					</div>
				</div>
			</li>
<?php
}
?>
		</ul>

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
