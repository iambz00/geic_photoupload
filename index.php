<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>사진 인화 서비스</title>

<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.css">
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
</style>
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
session_start();

if(isset($_SESSION['EXPIRE'])) {
	if($_SESSION['EXPIRE'] < time()) {
		session_unset();
		session_destroy();
	}
	elseif(isset($_SESSION['FILENAME'])) {
		$filename = $_SESSION['FILENAME'];
		$filetime = substr($filename,9,2) . ":" . substr($filename,11,2) . ":" . substr($filename,13,2);
		$filetitle = substr($filename,16);
?>
			<li data-role="list-divider">업로드한 사진</li>
			<li>
				<div class="ui-grid-a">
					<div class="ui-block-a alignright">
						<img src="get.php?type=t&name=<?=$filename?>" style="width:120px;height:180px"></img>
					</div>
					<div class="ui-block-b">
						<p class="alignleft">
							<strong>사진 제목</strong><br><?=$filetitle?>
						</p>
						<p class="alignleft">
							<strong>업로드 시간</strong><br><?=$filetime?>
						</p>
					</div>
				</div>
			</li>
<?php
	}
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
</body>
</html>
