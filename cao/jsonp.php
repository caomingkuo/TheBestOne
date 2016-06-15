<?php
$sou=$_GET['sou'];
$callback=$_GET['callback'];
//
$mem=new Memcache;
//
$mem->connect('127.0.0.1','11211');
//$mem->flush();
$num=$mem->get($sou);
if($num){
	$num++;
	$mem->set($sou,$num,0,0);
	if($num>=10){
		$data=$mem->get('hot');
		if(!in_array($sou,$data)){
			$data[]=$sou;
			$mem->set('hot',$data,0,0);
		}
		$data=$mem->get('hot');
		$result=json_encode($data);
		echo $callback."($result)";
	}else{
		$data=$mem->get('hot');
		$result=json_encode($data);
		echo $callback."($result)";
	}
}else{
$mem->set($sou,1,0,0);
$data=$mem->get('hot');
$result=json_encode($data);
echo $callback."($result)";

}
?>