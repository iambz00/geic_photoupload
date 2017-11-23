<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>사진 편집</title>

<style type="text/css">
body {
	background-color:#999;
}
#c {
	border:3px solid #000;
}

#panel_frame {
	background-color:rgba(0, 0, 0, 0.5)
}
#panel_finish {
	background-color:rgba(0, 0, 0, 0.7)
}
/* 2 panels behind is not real panels */
#panel_pick {}
#panel_upload {}

.thumbnail {
	margin:10px;
	width:90px;
	height:130px;
	border-width:2px;
	border-style:solid;
	border-color: #ccc;
	vertical-align:middle;
}
.canvas-container {
	/* Fabric.js use this class to wrap canvas */
	margin:auto;
}
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

<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile.theme-1.4.5.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="lib/exif.js"></script>
<script src="lib/fabric.min.js"></script>
<script src="lib/Blob.js"></script>
<!-- Blob.js implements the W3C Blob interface in browsers that do not natively support it.
	 https://github.com/eligrey/Blob.js -->
<script src="lib/canvas-toBlob.js"></script>
<!-- canvas-toBlob.js implements the standard HTML5 canvas.toBlob() and canvas.toBlobHD() methods in browsers that do not natively support it.
	 https://github.com/eligrey/canvas-toBlob.js -->
</head>

<body>
<div data-role="page" data-theme="a" data-content-theme="a" data-position="fixed">
	<div data-role="header">
		<a class="ui-btn ui-icon-home ui-btn-icon-notext ui-corner-all"></a>
		<h1>사진 편집</h1>
		<div data-role="navbar">
			<ul id="navbarBtn">
				<li><a id="btn_pick" data-icon="camera">사진 선택</a></li>
				<li><a href="#panel_frame" data-icon="grid">액자 선택</a></li>
				<li><a id="btn_zoomin" data-icon="plus">사진 확대</a></li>
				<li><a id="btn_zoomout" data-icon="minus">사진 축소</a></li>
				<li><a href="#panel_finish" data-icon="action">편집 완료</a></li>
			</ul>
			<div id="panel_pick">
				<p class="aligncenter">사진을 선택해 주세요.</p>
				<input type="file" id="pick_picture" accept="image/*"/>
			</div>
			<div id="panel_upload">
				<p class="aligncenter">업로드 중입니다.</p>
				<progress id="progressbar" value="0" class="" style="width:100%; height:20px; display:block"></progress>
			</div>
			<div id="notice">
				<p>공지 사항</p>
			</div>
		</div>
	</div>

	<div role="main" class="ui-content">
		<div class="aligncenter">
			<pre id="res"></pre>
			<img id="result"></img>
			
			<div id="wrap">
				<canvas id="c"></canvas>
			</div>
		</div>
	</div>

	<div data-role="panel" data-display="overlay" id="panel_frame">
		<div class="ui-bar ui-bar-a">
			액자 선택
		</div>
<?php
if ($handle = opendir('frame')) {
	while(false !== ($file = readdir($handle))) {
		if ($file == '.' || $file == '..') continue;
?>
		<img src='frame/<?=$file?>' class="thumbnail" data-rel="close"/>
<?php
	}
}
?>
		<img class="thumbnail" data-rel="close"/>
	</div>
	<div data-role="panel" data-display="overlay" id="panel_finish" data-position="right">
		<div class="ui-bar ui-bar-a">
			편집 완료
		</div>
		<ul data-role="listview" data-inset="true">
			<li data-role="list-divider">사진 제목 입력</li>
			<li>
				<div class="ui-grid-a">
					<div class="ui-block">
						<input type="text" name="title" id="frm_title" value="" placeholder="사진 제목"/>
					</div>
				</div>
			</li>
			<li data-role="list-divider">개인정보의 수집&middot;이용 동의</li>
			<li>
				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p class="alignleft"><strong>수집&middot;이용 목적</strong></p>
					</div>
					<div class="ui-block-b">
						<p class="alignleft">사진 인화</p>
					</div>
				</div>

				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p class="alignleft"><strong>수집 항목</strong></p>
					</div>
					<div class="ui-block-b">
						<p class="alignleft">사진</p>
					</div>
				</div>

				<div class="ui-grid-a">
					<div class="ui-block-a">
						<p class="alignleft"><strong>보유 기간</strong></p>
					</div>
					<div class="ui-block-b">
						<p class="alignleft">1일</p>
					</div>
				</div>
				<p class="aligncenter" style="white-space:normal">
					<strong>동의를 거부</strong>하실 수 있으며, 미동의 시
					사진 <strong>출력은 불가능</strong>합니다.</p>
				<div class="aligncenter">
				<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
					<legend class="ui-hidden-accessible">개인정보 수집&middot;이용 동의</legend>
					<input type="radio" name="privacy_yn" id="privacy_y" value="Y">
					<label for="privacy_y"> 동 &nbsp; 의 </label>
					<input type="radio" name="privacy_yn" id="privacy_n" value="N" checked >
					<label for="privacy_n">미 동 의</label>
				</fieldset>
				</div>
			</li>
		</ul>
		<input type="button" id="btn_submit" data-icon="edit" value="사진 전송" data-rel="close"/>

	</div>
</div>

<script type="text/javascript">
var PIC_OBJ
var PRESET
var BG_URL = 'pictures/background.png'

// Canvas size preset
var _PRESET = {
	HORIZONTAL : {
	FRAME_WIDTH : 1800,
	FRAME_HEIGHT : 1200,
	PIC_WIDTH : 1800 * 0.8,
	PIC_HEIGHT : 1200 * 0.8,
	PIC_PADDING_LEFT : 60,
	PIC_PADDING_TOP : 120,
	SCALE : 1,
	},
	VERTICAL : {
	FRAME_WIDTH : 1200,
	FRAME_HEIGHT : 1800,
	PIC_WIDTH : 1200,
	PIC_HEIGHT : 1800,
	PIC_PADDING_LEFT : 0,
	PIC_PADDING_TOP : 500,
	SCALE : 1,
	}
}

var canvas = new fabric.Canvas('c', {
	backgroundColor: '#fff',
	selectionColor:'black',
})

// Callbacks & Handlers
$(document).ready(function() {
	PRESET = _PRESET["VERTICAL"]
	setScale()

	canvas.setZoom(PRESET["SCALE"])
	canvas.setWidth(PRESET["SCALE"] * PRESET["FRAME_WIDTH"])
	canvas.setHeight(PRESET["SCALE"] * PRESET["FRAME_HEIGHT"])

	$('#result').hide()
	$('#panel_upload').hide()
	$('#notice').hide()

	// Set first frame
	$('.thumbnail').first().css('border-color', 'blue')
	canvas.setOverlayImage($('.thumbnail').first().attr('src'), canvas.renderAll.bind(canvas))
	// Set background
	fabric.Image.fromURL(BG_URL, function(oImg) {
		oImg.scaleToWidth(PRESET["PIC_WIDTH"])
		oImg.selectable = false
		canvas.add(oImg)
		oImg.sendToBack()
	})

	$('#btn_submit').button('disable')
})

$('.thumbnail').each(function() {
	$(this).click(function() {
		// Reset border color
		$('.thumbnail').each(function() { $(this).css('border-color', '#ccc') })
		$(this).css('border-color', 'blue')
		canvas.setOverlayImage($(this).attr('src'), canvas.renderAll.bind(canvas))
	})
})

$('#pick_picture').change(function(e) {
	var file = e.target.files[0], imageType = /image.*/
	if (!file.type.match(imageType)) return
	var reader = new FileReader()
	reader.onload = function(event) {
		var exif = EXIF.readFromBinaryFile(base64ToArrayBuffer(this.result))
		var imageObj = new Image()
		imageObj.src = event.target.result
		imageObj.onload = function() {
			var oImg = new fabric.Image(imageObj)
			if (PIC_OBJ) canvas.remove(PIC_OBJ)
			oImg.scaleToWidth(PRESET["PIC_WIDTH"])
			oImg.set({
				left: canvas.width / 2 / PRESET["SCALE"],
				top: canvas.height / 2 / PRESET["SCALE"],
				originX:"center",
				originY:"center"
			})
			switch(exif.Orientation) {
				case 8:
					oImg.setAngle(270)
					break
				case 6:
					oImg.setAngle(90)
					break
				case 3:
					oImg.setAngle(180)
			}
			canvas.add(oImg)
			oImg.bringToFront()
			PIC_OBJ = oImg
		}
	}
	reader.readAsDataURL(file)
	$('#panel_pick').toggle()
	$('#btn_pick').removeClass($.mobile.activeBtnClass)

})

$('input[name=title]').change(checkSubmit)
$('input[name=title]').keyup(checkSubmit)
$('input[name=privacy_yn]').change(function() {
	$('input[name=privacy_yn]').focus()
	checkSubmit()
})

function base64ToArrayBuffer (base64) {
	base64 = base64.replace(/^data\:([^\;]+)\;base64,/gmi, '');
	var binaryString = atob(base64);
	var len = binaryString.length;
	var bytes = new Uint8Array(len);
	for (var i = 0; i < len; i++) {
		bytes[i] = binaryString.charCodeAt(i);
	}
	return bytes.buffer;
}

function checkSubmit() {
	if ($('input[name=privacy_yn]:checked').val() == "Y" && $('input[name=title]').val() != "") {
		$('#btn_submit').button('enable')
	}
	else {
		$('#btn_submit').button('disable')
	}
}

$('#btn_submit').click(function() {
	// $('canvas').hide() // After .hide() <canvas> still takes space
	$('#wrap').hide()
	$('#result').show()
	$('#navbarBtn').hide()
	$('#panel_pick').hide()
	$('#panel_upload').show()
	window.setTimeout(toBlobAndSave, 500)
})

function toBlobAndSave() {
	var picture_name = getDateTime() + "_" + $('input[name=title]').val() + ".jpg"
	// Restore canvas size
	// Take some saconds in mobile
	canvas
	.deactivateAll()
	.setZoom(1)
	.setWidth(PRESET["FRAME_WIDTH"])
	.setHeight(PRESET["FRAME_HEIGHT"])
	.renderAll()

	$('canvas')[0].toBlob(function(blob) {
		var fd = new FormData()
		fd.append("framedpicture", blob, picture_name)
		$.ajax({
			url: "save_framed.php",
			type: "POST",
			xhr: function() {	// Custom XMLHttpRequest
				var myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload){ // Check if upload property exists
					myXhr.upload.addEventListener('progress', function(e) {
						if(e.lengthComputable) $('#progressbar').attr({value:e.loaded,max:e.total})
					}, false); // For handling the progress of the upload
				}
				return myXhr;
			},
			data: fd,
			cache: false,
			processData: false,
			contentType: false,
			beforeSend: null,
			success: function(response, status, jqXHR) {
				onSaveSuccess(blob)
			},
			error: onSaveError
		})
	}, "image/jpeg", 0.9)
}

function onSaveSuccess(blobObj) {
	var urlCreator = window.URL || window.webkitURL
	$('#result')
		.width(PRESET["SCALE"] * PRESET["FRAME_WIDTH"])
		.height(PRESET["SCALE"] * PRESET["FRAME_HEIGHT"])
		.prop('src', urlCreator.createObjectURL(blobObj))
	$('#panel_upload').hide()
	alert("안 내 문 구")
}

function onSaveError(jqXHR, status, errorThrown) {
	alert("오 류 안 내")
}

$('#btn_pick').click(function () {
	$('#panel_pick').toggle()
})

$('#btn_zoomin').click(function() {
	if(PIC_OBJ) {
		PIC_OBJ.scale(PIC_OBJ.getScaleX() * 1.05)
		canvas.renderAll()
	}
	window.setTimeout(function() { $('#btn_zoomin').removeClass($.mobile.activeBtnClass) }, 150)
})
$('#btn_zoomout').click(function() {
	if(PIC_OBJ) {
		PIC_OBJ.scale(PIC_OBJ.getScaleX() / 1.05)
		canvas.renderAll()
	}
	window.setTimeout(function() { $('#btn_zoomout').removeClass($.mobile.activeBtnClass) }, 150)
})

function setScale() {
	var windowPadding = window.innerWidth - document.body.clientWidth
	var w = (window.innerWidth - windowPadding) / PRESET["FRAME_WIDTH"]
	var h = (window.innerHeight - windowPadding - 80) / PRESET["FRAME_HEIGHT"]
										// 80px reserved for navBar
	var scale = 0.9 * (w < h ? w : h)
	PRESET["SCALE"] = scale > 0.9 ? 0.9 : scale
}

function getDateTime() {
	var now = new Date()
	var result
	result = now.getFullYear() + fillZero(now.getMonth()+1) + fillZero(now.getDate()) + '_'
	result += fillZero(now.getHours()) + fillZero(now.getMinutes()) + fillZero(now.getSeconds())
	return result
	function fillZero(str) {
		str = '0' + str
		if (str.length > 2) str = str.slice(str.length - 2)
		return str
	}
}

</script>
</body>
</html>
