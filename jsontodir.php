<?php
$a = json_decode(file_get_contents("dump_json.js"),true);
//print_r($a);
function ext($format){
	if($format=="latex"){
		return ".tex";
	}
	return ".txt";
}
function only_oneline($a){
	for($i=0;$i<count($a);$i++){
		$t = strpos($a[$i],"\n");
		//var_dump($t);
		//echo "\n";
		if($t!== false && $t != strlen($a[$i])-1){
			return false;
		}
	}
	return true;
}
//$cname_to_id;
for($i=0;$i<count($a);$i++){
	unset($meta);
	@mkdir($a[$i]["_id"]);
	if(strlen($a[$i]["cname"])>0){
		$meta["cname"] = $a[$i]["cname"];
		$cname_to_id[] = array($meta["cname"],$a[$i]["_id"]);
	}
	for($j=0;$j<count($a[$i]["output"]);$j++){
		$d = $a[$i]["_id"]."/".$a[$i]["output"][$j]["format"];
		$p = $a[$i]["output"][$j];
		if($p["format"]=="plain"&&only_oneline($p["out"])){
			$meta[$p["type"]] = $p["out"];
		}else{
			if(!is_dir($d)){
				mkdir($d);
			}
			for($k=0;$k<count($p["out"][$k]);$k++){
				file_put_contents($d."/".$p["type"]."_".$k.ext($p["format"]),$p["out"][$k]);
			}
		}
	}
	if($meta!== null){
		file_put_contents($a[$i]["_id"]."/meta.js",json_encode($meta));
	}
}
$s = "";
for($i=0;$i<count($cname_to_id);$i++){
	$s.=$cname_to_id[$i][0];
	$s.=" ";
	$s.=$cname_to_id[$i][1];
	$s.="\n";
}
file_put_contents("cname_to_id_helper.txt",$s);
system("sort cname_to_id_helper.txt > cname_to_id.txt");
unlink("cname_to_id_helper.txt");
