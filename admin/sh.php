<?php
$type = $_POST["type"];

$filelist = json_decode($_POST["filename"]);
switch($type) {
case "pic":
	foreach($filelist as $file) {
		// No slash allowed
		if(preg_match("/[\/\`\'\"\>\<]/", $file)) die("BAD REQUEST");

	//	echo(`ls -Z "../pictures/framed/$file"`);
	//	echo(`ls -Z "../pictures/thumbnail/$file"`);
		echo(`rm -vf "../pictures/framed/$file"`);
		echo(`rm -vf "../pictures/thumbnail/$file"`);
	}
	break;
case "frame":
	foreach($filelist as $file) {
		// No slash allowed
		if(preg_match("/\/\`\'\"\>\</", $file)) die("BAD REQUEST");
	
	//	echo(`ls -Z "../frame/$file"`);
		echo(`rm -vf "../frame/$file"`);
	}
	break;
case "rename":
	$file = $filelist[0];
	$newname = $_POST["newname"];
	// No slash allowed
	if(preg_match("/\/\`\'\"\>\</", $file)) die("BAD REQUEST");
	
	echo(`mv -v "../frame/$file" "../frame/$newname"`);
	break;
}
?>
