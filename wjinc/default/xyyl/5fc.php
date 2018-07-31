<?php
$lastNo=$this->getGameLastNo(14);

header('Content-type: application/xml');
echo'<?xml version="1.0" encoding="utf-8"?>';
//echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.randKeys().'" opentime="'.$lastNo['actionTime'].'"/></xml>';
$sql = "select `data` from ssc_data where type=14 and `number`='".$lastNo['actionNo']."'";
$number = $this->getValue($sql);
if( $number ){
	echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.$number.'" opentime="'.$lastNo['actionTime'].'"/></xml>';
}else{
	$number = $this->getActionNo($lastNo['actionNo']);
	file_put_contents('t.txt','number:'.$number,FILE_APPEND);
	echo '<xml><row expect="'.$lastNo['actionNo'].'" opencode="'.$number.'" opentime="'.$lastNo['actionTime'].'"/></xml>';
}


/* ��������� */
function randKeys($len=5){
	$str='6038519724';
	$rand='';
	for($x=0;$x<$len;$x++){
		$rand.=($rand!=''?',':'').substr($str,rand(0,strlen($str)-1),1);
	}
	return $rand;
}
?>