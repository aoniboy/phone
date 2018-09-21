<?php
require 'lib/core/DBAccess.class';
require 'config.php';
$db = new DBAccess($conf['db']['dsn'], $conf['db']['user'], $conf['db']['password']);
$type = 55;

//$result = $db->getRow("SELECT * FROM ssc_data_time WHERE type =$type order by id desc LIMIT 1 ");
//print_r($result);
//for($i = 27;$i<28;$i++) {
//    $sql = "INSERT INTO ssc_played(name,enable,type,bonusProp,bonusPropBase,selectNum,groupId,numinfo,ruleFun,betCountFun,zjMax)";
//    $sql .= "values($i,1,8,14,14,1,102,$i,'calc28num','calc28num','calc28nummax')";
//    $db->insert($sql);
//}
//$time = 1535461230;
//for($i =1;$i<53;$i++){
//    $date =  date("H:i:s",$time);
//    if($time){
//        $sql = "INSERT INTO ssc_data_time(type, actionNo, actionTime, stopTime) VALUES('".$type."', '".$i."', '".$date."', '".$date."')";
//        $db->insert($sql);
//        $time = $time +210;
//    }
//}
$sql = "select * from ssc_data_time where type = 55 order by actionTime asc";
$result = $db->getRows($sql);
foreach ($result as $key=>$value) {
    $sql = "update ssc_data_time set actionNo =".($key+1)." where id = ".$value['id']." LIMIT 1";
    $db->update($sql);
}
exit;
$sql = "select * from ssc_played where id > 315";
$result = $db->getRows($sql);
foreach($result as $k=>$v) {
    $info = sprintf("%.5f",$v['bonusProp']/1950);
    $sql = "UPDATE ssc_played set bonusPropProportion = '{$info}' where id ={$v['id']}";
    $db->update($sql);
}
exit;




$sql = "DELETE FROM ssc_data_time WHERE type = $type";
mysqli_query($conn,$sql);
//

$time = 1535418300;
for($i =1;$i<180;$i++){
    $date =  date("H:i:s",$time);
    $sql = "INSERT INTO ssc_data_time(type, actionNo, actionTime, stopTime) VALUES('".$type."', '".$i."', '".$date."', '".$date."')";
    mysqli_query($conn,$sql);
    $time +=300;

}
mysqli_close($conn);
exit;

$type = 55;
$time = 1535385600;
$c = 1;
$t1 = 1535454000;//19点
$t2 = 1535457600;//20点
//$t3 = 1535461200;//21点
for($i =1;$i<400;$i++){
    $date =  date("H:i:s",$time);
    if($time>=$t1 && $time<$t2){
        echo date("Y-m-d H:i:s",$time).'---111----'."+--".$c."<br>";
        $sql = "INSERT INTO ssc_data_time(type, actionNo, actionTime, stopTime) VALUES('".$type."', '".$i."', '".$date."', '".$date."')";
        mysqli_query($conn,$sql);
        $time =1535457690; //20:01:30
        $c++;
        continue;
    }else if($time>=$t2 && $time <$t3){
        echo date("Y-m-d H:i:s",$time).'---111----'."+--".$c."<br>";
        $sql = "INSERT INTO ssc_data_time(type, actionNo, actionTime, stopTime) VALUES('".$type."', '".$i."', '".$date."', '".$date."')";
        mysqli_query($conn,$sql);
        $time =1535461481; //21:04:41
        $c++;
        continue;
    }
    echo date("Y-m-d H:i:s",$time)."+--".$c."<br>";
    $sql = "INSERT INTO ssc_data_time(type, actionNo, actionTime, stopTime) VALUES('".$type."', '".$i."', '".$date."', '".$date."')";
    $c++;
    mysqli_query($conn,$sql);
    $time +=210;

}
mysqli_close($conn);
