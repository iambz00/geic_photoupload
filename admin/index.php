<!DOCTYPE html>
<html lang="ko">

<head>
<meta charset="utf-8">
<title>관리자 페이지</title>
<style type="text/css">
li {
	float:left;
	list-style-type:none;
	margin:5px;
	padding:0;
	padding-bottom:10px;
	background-color:#ccc;
	border: 1px solid #000;
	text-align:center;
}
img {
	margin:0;
}
.frame {
	width:180px;
	height:auto;
	border:2px solid #000;
}
a	{
	color:#000;
	font-size:10pt;
	text-decoration:none;
}
.aligncenter {
	text-align:center;
}
.picinfo {
	font-size:10pt
}
#popup_result {
	min-width:200px;
	min-height:300px;
	background-color:#000;
}
#bg_popup {
	position:absolute;
	width:100%;
	height:100%;
	left:0; top:0;
	background-color:rgba(0,0,0,0.5);
	display:none;
}
</style>
<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>

<body>
<div data-role="header">
<h1>관리자 페이지</h1>
</div>
<div data-role="tabs" id="tab_header">
	<div data-role="navbar">
		<ul>
			<li><a id="btn_list">업로드 사진 관리</a></li>
			<li><a id="btn_frame">액자 관리</a></li>
		</ul>
	</div>

	<div id="tab_list" class="hidden">
		<div class="ui-field-contain">
			<fieldset data-role="controlgroup" data-type="horizontal">
				<legend class="aligncenter">관리 기능</legend>
				<button id="btn_selectall" class="ui-btn ui-icon-check ui-btn-icon-left">모두 선택</button>
				<button id="btn_deselect" class="ui-btn ui-icon-forbidden ui-btn-icon-left">모두 해제</button>
				<button id="btn_rmpic" class="ui-btn ui-icon-delete ui-btn-icon-left">선택 삭제</button>
			</fieldset>
		</div>
		<form class="ui-filterable">
		<div class="ui-field-contain">
			<label for="input_filter" class="aligncenter">사진 검색</label>
			<input id="input_filter" name="input_filter" data-type="search">
		</div>
		</form>
		<ul data-filter="true" data-input="#input_filter">
<?php
foreach(glob("../pictures/thumbnail/*.jpg") as $filepath) {
	$filename = preg_replace("/^.*\//", "", $filepath);	// strip out directory tree
	preg_match("/([\d_]{15})_(.*)\.jpg/", $filename, $matches);
	$date = date_create_from_format('Ymd_His', $matches[1]);
?>			<li>
				<a href="../get.php?type=f&name=<?=urlencode($filename)?>" target="_blank">
					<img src="../get.php?type=t&name=<?=urlencode($filename)?>"></a>
				<div class="picinfo">
					<input type="checkbox" name="chk_pic" value="<?=$filename?>"><br>
					<?=$date->format('m-d H:i:s');?><br>
					<?=$matches[2]?>
				</div>
			</li>
<?php
}
?>		</ul>
	</div>
	<div id="tab_frame" class="hidden">
		<div class="ui-field-contain">
			<fieldset data-role="controlgroup" data-type="horizontal">
				<legend class="aligncenter">관리 기능</legend>
				<button id="btn_mvframe" class="ui-btn ui-icon-edit ui-btn-icon-left">이름 변경</button>
				<button id="btn_rmframe" class="ui-btn ui-icon-delete ui-btn-icon-left">선택 삭제</button>
			</fieldset>
		</div>
		<form enctype="multipart/form-data" method="POST" onsubmit="return false">
			<input type="file" name="userfile" id="frm_file" accept="image/png"/>
			<button id="btn_uploadframe" class="ui-btn ui-icon-action ui-btn-icon-left">액자 업로드</button>
		</form>

		<ul>
<?php
foreach(glob("../frame/*.png") as $filepath) {
	$filename = preg_replace("/^.*\//", "", $filepath); // strip out directory tree
?>			<li>
				<a href="<?=$filepath?>" target="_blank">
					<img src="<?=$filepath?>" class="frame"/></a>
				<div class="picinfo">
					<input type="radio" name="chk_frame" value="<?=$filename?>"><br>
					<?=$filename?>
				</div>
			</li>
<?php
}
?>		</ul>
	</div>
</div>
<div data-role="popup" id="popup_result">
	<div data-role="header" >
	<h1>실행 결과</h1>
	</div>
	<pre id="result" style="color:#eee; background-color:#000; text-shadow:0 0 0;">
	</pre>
</div>
<div id="bg_popup"></div>

<script type="text/javascript">
$(function() {
	$('div.hidden').hide()
	var page = '<?=$_REQUEST["p"]?>'
	if (page != "2") {
		$('#tab_list').show()
		$('#btn_list').addClass('ui-btn-active')
	} else {
		$('#tab_frame').show()
		$('#btn_frame').addClass('ui-btn-active')
	}
})
$('#btn_list').click(function() { location.href='./' })
$('#btn_frame').click(function() { location.href='./?p=2' })

$('#btn_rmpic').click(function() {
	if(confirm("선택한 사진을 정말로 삭제할까요?")) {
		var arr_filename = []
		$('input[name=chk_pic]:checked').each(function(){arr_filename.push($(this).val())})
		var fd = new FormData()
		fd.append('type', 'pic')
		fd.append('filename', JSON.stringify(arr_filename))
		$.ajax({
			url: "sh.php",
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data: fd,
			success: function(response, status, jqXHR) {
				report(response)
			},
		})
	}
})
$('#btn_selectall').click(function() {
	$('input[name=chk_pic]').each(function(){$(this).prop('checked', true)})
})
$('#btn_deselect').click(function() {
	$('input[name=chk_pic]').each(function(){$(this).prop('checked', false)})
})

$('#btn_rmframe').click(function() {
	if(confirm("선택한 액자를 정말로 삭제할까요?")) {
		var arr_filename = []
		$('input[name=chk_frame]:checked').each(function(){arr_filename.push($(this).val())})
		var fd = new FormData()
		fd.append('type', 'frame')
		fd.append('filename', JSON.stringify(arr_filename))
		$.ajax({
			url: "sh.php",
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data: fd,
			success: function(response, status, jqXHR) {
				report(response)
			},
		})
	}
})
$('#btn_mvframe').click(function() {
	var selected = $('input[name=chk_frame]:checked').val()
	if(!selected) return
	var newname = prompt("액자의 이름을 변경합니다.", selected)
	if(newname) {
		console.log(newname)
		var arr_filename = []
		arr_filename.push($('input[name=chk_frame]:checked').val())
		var fd = new FormData()
		fd.append('type', 'rename')
		fd.append('filename', JSON.stringify(arr_filename))
		fd.append('newname', newname)
		$.ajax({
			url: "sh.php",
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data: fd,
			success: function(response, status, jqXHR) {
				report(response)
			},
		})
	}
})
$('#btn_uploadframe').click(function() {
	var file = $('#frm_file')[0].files[0]
	if(!file) return
	var fd = new FormData()
	fd.append('userfile', file)
	$.ajax({
		url: "saveframe.php",
		type: "POST",
		cache: false,
		processData: false,
		contentType: false,
		data: fd,
		success: function(response, status, jqXHR) {
			report(response)
		}
	})
})
function report(text) {
	$('#result').html(text)
	$('#popup_result').popup("open")
}
$('#popup_result').on('popupafterclose', function() {
	$('#bg_popup').hide()
	location.reload()
}).on('popupbeforeposition', function() {
	$('#bg_popup').show()
})
</script>
</body>
</html>
