<?php
$myfile = fopen("video_urls.txt", "r");
$ids = fread($myfile,filesize("video_urls.txt"));
fclose($myfile);
// $a = (explode('\n',$ids));
$a = str_split($ids,11);
print_r($a);
for($i = 0; $i<20; $i++ ) {
		echo $ids[$i];
	}
// $iparr = split (" ", $ids);
// print_r($iparr); 
?>

<<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
	
</body>
</html>