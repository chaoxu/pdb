<?php
if(!isset($_SERVER['argv'][1])){
	exit();
}
$s = file_get_contents("cname_to_id.txt");
$s = explode("\n",$s);
for($i=0;$i<count($s);$i++){
	$t = explode(" ",$s[$i]);
	if($t[0] == $_SERVER['argv'][1]){
		echo $t[1],"\n";
		exit();
	}
}
