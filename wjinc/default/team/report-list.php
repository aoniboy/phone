<?php
	$para=$_GET;
	$st=time();
	set_time_limit(0);
	// 时间限制
	if($para['fromTime'] && $para['toTime']){
		$fromTime=strtotime($para['fromTime']);
		$toTime=strtotime($para['toTime'])+24*3600;
		$betTimeWhere="and actionTime between $fromTime and $toTime";
		$cashTimeWhere="and c.actionTime between $fromTime and $toTime";
		$rechargeTimeWhere="and r.actionTime between $fromTime and $toTime";
		$fanDiaTimeWhere="and actionTime between $fromTime and $toTime";
		$fanDiaTimeWhere2="and l.actionTime between $fromTime and $toTime";
		$brokerageTimeWhere=$fanDiaTimeWhere2;
        $logTimeWhere=$fanDiaTimeWhere;
	}elseif($para['fromTime']){
		$fromTime=strtotime($para['fromTime']);
		$betTimeWhere="and b.actionTime >=$fromTime";
		$cashTimeWhere="and c.actionTime >=$fromTime";
		$rechargeTimeWhere="and r.actionTime >=$fromTime";
		$fanDiaTimeWhere="and actionTime >= $fromTime";
		$fanDiaTimeWhere2="and l.actionTime >= $fromTime";
		$brokerageTimeWhere=$fanDiaTimeWhere2;
        $logTimeWhere=$fanDiaTimeWhere;
	}elseif($para['toTime']){
		$toTime=strtotime($para['toTime'])+24*3600;
		$betTimeWhere="and b.actionTime < $toTime";
		$cashTimeWhere="and c.actionTime < $toTime";
		$rechargeTimeWhere="and r.actionTime < $toTime";
		$fanDiaTimeWhere="and actionTime < $toTime";
		$fanDiaTimeWhere2="and l.actionTime < $toTime";
		$brokerageTimeWhere=$fanDiaTimeWhere2;
        $logTimeWhere=$fanDiaTimeWhere;
	}else{
		$toTime=strtotime('00:00:00');
		$betTimeWhere="and b.actionTime > $toTime";
		$cashTimeWhere="and c.actionTime > $toTime";
		$rechargeTimeWhere="and r.actionTime > $toTime";
		$fanDiaTimeWhere="and actionTime > $toTime";
		$fanDiaTimeWhere2="and l.actionTime > $toTime";
		$brokerageTimeWhere=$fanDiaTimeWhere2;
        $logTimeWhere=$fanDiaTimeWhere;
	}
$sql="";
	// 用户限制
	$uid=$this->user['uid'];
	if($para['parentId']>0){
		// 用户ID限制
		$userWhere=" and u.parentId={$para['parentId']}";
		$uid=intval($para['parentId']);
        //echo 1;
//	}elseif($para['uid']=intval($para['uid'])){
//		// 用户ID限制
//		$uParentId=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['uid']);
//		//$userWhere="and u.uid=$uParentId";
//        $userWhere="and (u.parentId={$uid} )";
//		$uid=$uParentId;
       // echo 2;
	}elseif($para['username'] && $para['username']!='用户名'){
		// 用户名限制
		$para['username']=wjStrFilter($para['username']);
		if(!ctype_alnum($para['username'])) throw new Exception('用户名包含非法字符,请重新输入');
		$uid=$this->getValue("select uid from {$this->prename}members where username=? and concat(',',parents,',') like '%,{$this->user['uid']},%'",$para['username']);
		$userWhere=" and u.username='{$para['username']}' and concat(',', u.parents, ',') like '%,{$this->user['uid']},%'";
	}else{

		$userWhere=" and (u.parentId={$uid} )";

        //echo 3;
	}
	$userWhere3=" and concat(',', u.parents, ',') like '%,$uid,%'";
	
	//没有账变的不显示
	//$userWhere.=" and u.uid in(select uid from {$this->prename}coin_log where 1=1 $logTimeWhere)";
$sql.="(select u.username, u.coin, u.uid, u.parentId, u.type, ".
    "(select sum(b.mode * b.beiShu * b.actionNum) from  ssc_bets b where b.uid =u.uid and b.isDelete=0  $betTimeWhere  ) betAmount, ".
    "(select  sum(b.bonus) from  ssc_bets b where b.uid =u.uid and b.isDelete=0  $betTimeWhere  ) zjAmount, ".
    "(select sum(c.amount) from ssc_member_cash c where c.`uid` =u.uid and c.state=0 $cashTimeWhere) cashAmount,".
    "((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere))rechargeAmount, ".
    "(select sum(l.coin) from ssc_coin_log l where l.`uid` =u.uid and l.liqType in(50,51,52,53,56) $brokerageTimeWhere) brokerageAmount ".
    " from ssc_members u  where 1=1 and u.uid={$uid}) union all";
	//+ (select ifnull(sum(coin),0) from {$this->prename}coin_log where 1=1 and liqType in(1,109) and uid=u.uid  $logTimeWhere) $sql="select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 $cashTimeWhere) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid`  and r.isDelete=0 and r.state in(1,2,9) $rechargeTimeWhere) rechargeAmount, (select sum(l.coin) from ssc_coin_log l where l.`uid`=u.`uid` and l.liqType in(50,51,52,53,56) $brokerageTimeWhere) brokerageAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere where 1 $userWhere";
     $sql.="(select u.username, u.coin, u.uid, u.parentId, u.type, ".
         "(select  sum(b.mode * b.beiShu * b.actionNum) from  ssc_bets b where b.uid in (select uid from ssc_members where  parents like concat(u.parents,'%')) and b.isDelete=0  $betTimeWhere  ) betAmount, ".
         "(select  sum(b.bonus) from  ssc_bets b where b.uid in (select uid from ssc_members where  parents like concat(u.parents,'%')) and b.isDelete=0  $betTimeWhere  ) zjAmount, ".
         "(select  sum(c.amount) from ssc_member_cash c where c.`uid` in (select uid from ssc_members where parents like concat(u.parents,'%')) and c.state=0 $cashTimeWhere) cashAmount,".
         "(select  ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` in (select uid from ssc_members where parents like concat(u.parents,'%'))   and ((r.state=9 and r.isdelete=1) or r.state=1) $rechargeTimeWhere) rechargeAmount, ".
         "(select  sum(l.coin) from ssc_coin_log l where l.`uid` in (select uid from ssc_members where parents like concat(u.parents,'%')) and l.liqType in(50,51,52,53,56) $brokerageTimeWhere) brokerageAmount ".
         " from ssc_members u  where 1=1 $userWhere  order by u.uid)";
//++ (select ifnull(sum(coin),0) from {$this->prename}coin_log where 1=1 and uid in (select uid from ssc_members where parents like concat(u.parents,'%')) and liqType in(1,109)  $logTimeWhere)
//新查询优化
$sql = '(select u.username, u.coin, u.uid, u.parentId, u.type, 0 as  betAmount,0 as  zjAmount,0 as cashAmount,0 as rechargeAmount,0 as brokerageAmount,u.parents from ssc_members u where 1=1  '.$userWhere.' order by u.uid)';
//没有账变的不显示
//$userWhere.=" and u.uid in(select uid from {$this->prename}coin_log where 1=1 $logTimeWhere)";
//	echo $sql;exit;
   // echo $sql;
	$this->pageSize=1000;
	if($this->action!='searchReport') $this->action='searchReport';
	//$list=$this->getPage($sql .' group by u.uid', $this->page, $this->pageSize);
$list=$this->getPage($sql."  " , $this->page, $this->pageSize);
	if(!$list['total']) {
//		$uParentId2=$this->getValue("select parentId from {$this->prename}members where uid=?",$para['parentId']);
//		$list=array(
//			'total' => 1,
//			'data'=>array(array(
//				'parentId'=>$uParentId2,
//				'uid'=>$para['parentId'],
//				'username'=>'没有用户'
//			))
//		);
		$noChildren=true;
	}

	$params=http_build_query($_REQUEST, '', '&');
	$count=array();
	$sql="select sum(coin) from {$this->prename}coin_log where uid=? and liqType in(2,3) $fanDiaTimeWhere";
	
	$rel="/index.php/{$this->controller}/{$this->action}";

?>
<table width="100%" class='table_b'>
	<colgroup>
    	<col width="13%">
    	<col width="20%">
    	<col width="10%">
    	<col width="15%">
    	<col width="10%">
    	<col width="10%">
    	<col width="5%">
    	<col width="12%">
    	<col width="5%">
	</colgroup>
	<thead>
		<tr class="table_b_th">
			<td class="tdover">用户名</td>
            <td>充值总额</td>
            <td>提现总额</td>
			<td>投注总额</td>
			<td>中奖总额</td>
			<td>总返点</td>
			<td>佣金</td>
			<td>总盈亏</td>
			<td>查看</td>
		</tr>
	</thead>
	<tbody class="table_b_tr">
	<?php
	$member = $this->getRow("select * from {$this->prename}members where uid=?",$uid);

	$sqlbetAmount="select sum(b.mode * b.beiShu * b.actionNum) from  ssc_bets b where b.uid =? and b.isDelete=0  $betTimeWhere   ";
	$sqlzjAmount="select  sum(b.bonus) from  ssc_bets b where b.uid =? and b.isDelete=0  $betTimeWhere ";
	$sqlcashAmount="select sum(c.amount) from ssc_member_cash c where c.`uid` =u.? and c.state=0 $cashTimeWhere ";
	$sqlrechargeAmount="select sum(r.amount) from ssc_member_recharge r where r.`uid` =?  and ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere ";
	$sqlbrokerageAmount="select sum(l.coin) from ssc_coin_log l where l.`uid` =? and l.liqType in(50,51,52,53,56) $brokerageTimeWhere ";


	$sqlbetAmount2 = "select  sum(b.mode * b.beiShu * b.actionNum) from  ssc_bets b where b.uid in (select uid from ssc_members where  parents like ?) and b.isDelete=0  $betTimeWhere   ";
		$sqlzjAmount2="select  sum(b.bonus) from  ssc_bets b where b.uid in (select uid from ssc_members where  parents like ?) and b.isDelete=0  $betTimeWhere   ";
	$sqlcashAmount2="select  sum(c.amount) from ssc_member_cash c where c.`uid` in (select uid from ssc_members where parents like ?) and c.state=0 $cashTimeWhere ";
	$sqlrechargeAmount2="select  sum(r.amount) from ssc_member_recharge r where r.`uid` in (select uid from ssc_members where parents like ?)   and ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere ";
	$sqlbrokerageAmount2="select  sum(l.coin) from ssc_coin_log l where l.`uid` in (select uid from ssc_members where parents like ?) and l.liqType in(50,51,52,53,56) $brokerageTimeWhere ";

//echo $sqlrechargeAmount;
	$betAmount = $this->getValue($sqlbetAmount, $uid);
	$zjAmount = $this->getValue($sqlzjAmount, $uid);
	$cashAmount = $this->getValue($sqlcashAmount, $uid);
	$rechargeAmount = $this->getValue($sqlrechargeAmount, $uid);
	$brokerageAmount = $this->getValue($sqlbrokerageAmount, $uid);


    $fanDianAmount=$this->getValue($sql, $uid);

//    $count['betAmount']=$betAmount;
//    $count['zjAmount']=$zjAmount;
//    $count['fanDianAmount']=$fanDianAmount;
//    $count['brokerageAmount']=$brokerageAmount;
//    $count['cashAmount']=$cashAmount;
//    $count['coin']=$member['coin'];
//    $count['rechargeAmount']=$rechargeAmount;


?>

    <tr>
        <td><?=$this->ifs($member['username'], '--')?></td>
        <td><?=$this->ifs($rechargeAmount, '--')?></td>
        <td><?=$this->ifs($cashAmount,'--')?></td>
        <td><?=$this->ifs($betAmount,'--')?></td>
        <td><?=$this->ifs($zjAmount,'--')?></td>
        <td><?=$this->ifs($fanDianAmount,'--')?></td>
        <td><?=$this->ifs($brokerageAmount,'--')?></td>
        <td><?=$this->ifs($zjAmount-$betAmount+$fanDianAmount+$brokerageAmount,'--')?></td>
        <td>
			<?php if($member['type'] &&$uid!=$member['uid']){?>
                <a target="ajax" dataType="html" call="searchData" class="qzbtn" href="javascript:void(0)" data-href="<?="{$rel}/?parentId={$member['uid']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}"?>">下级</a>
			<?php }?>
			<?php if($member['uid']!=$this->user['uid'] && $member['parentId']){?>
                <a target="ajax" dataType="html" call="searchData" class="qzbtn" href="javascript:void(0)" data-href="<?="{$rel}/?uid={$member['parentId']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}"?>">上级</a>
			<?php }?>
        </td>
    </tr>

    <?php

		if($list['data']) foreach($list['data'] as $var){
			$var['uid']=intval($var['uid']);
		if($var['username']!='没有用户'){
			$var['fanDianAmount']=$this->getValue($sql, $var['uid']);
			//echo $sql.$var['uid'];
			$pId=$var['uid'];
		}




			$var['betAmount'] = $this->getValue($sqlbetAmount2, $var['parents'].'%');
			$var['zjAmount'] = $this->getValue($sqlzjAmount2, $var['parents'].'%');
			$var['cashAmount'] = $this->getValue($sqlcashAmount2, $var['parents'].'%');
			$var['rechargeAmount'] = $this->getValue($sqlrechargeAmount2, $var['parents'].'%');
			$var['brokerageAmount'] = $this->getValue($sqlbrokerageAmount2, $var['parents'].'%');


		$count['betAmount']+=$var['betAmount'];
		$count['zjAmount']+=$var['zjAmount'];
		$count['fanDianAmount']+=$var['fanDianAmount'];
		$count['brokerageAmount']+=$var['brokerageAmount'];
		$count['cashAmount']+=$var['cashAmount'];
		$count['coin']+=$var['coin'];
		$count['rechargeAmount']+=$var['rechargeAmount'];
	?>
		<tr>
			<td><?=$this->ifs($var['username'], '--')?></td>
            <td><?=$this->ifs($var['rechargeAmount'], '--')
                #echo "select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9)   and r.isDelete=0  and r.uid=u.uid $rechargeTimeWhere  and u.parents like '%".$var['uid']."%'", $var['uid'];
                ##$list_valeu=$this->getValue("select sum(r.amount) from {$this->prename}member_recharge r, {$this->prename}members u where r.state in (1,2,9)   and r.isDelete=0  and r.uid=u.uid $rechargeTimeWhere  and u.parents like '%".$var['uid']."%'", $var['uid']);

                ##echo   $this->ifs($list_valeu, '--');

                ##$this->ifs($var['rechargeAmount'], '--')

                ?></td>
			<td><?=$this->ifs($var['cashAmount'],'--')

               ## $list_valeu=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere and u.parents like '%".$var['uid']."%'", $var['uid']);
                ##echo   $this->ifs($list_valeu, '--');
                ##$this->ifs($var['cashAmount'], '--')

                ?></td>
			<td><?=$this->ifs($var['betAmount'],'--')//$this->ifs($var['betAmount']?></td>
			<td><?=$this->ifs($var['zjAmount'],'--')//$this->ifs($var['zjAmount'], '--')?></td>
			<td><?=$this->ifs($var['fanDianAmount'],'--')//$this->ifs($var['fanDianAmount'], '--')?></td>
            <td><?=$this->ifs($var['brokerageAmount'],'--')//$this->ifs($var['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount']+$var['brokerageAmount'],'--')//$this->ifs($var['zjAmount']-$var['betAmount']+$var['fanDianAmount']+$var['brokerageAmount'], '--')?></td>
            <td>
                <?php if($var['type'] &&$uid!=$var['uid']){?>
                <a target="ajax" dataType="html" call="searchData" class="qzbtn" href="javascript:void(0)" data-href="<?="{$rel}/?parentId={$var['uid']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}"?>">下级</a>
				<?php }?>
                <?php if($var['parentId'] && $var['uid']!=$this->user['uid'] && $uid != $var['parentId']){?>
                  <a target="ajax" dataType="html" call="searchData" class="qzbtn" href="javascript:void(0)" data-href="<?="{$rel}/?uid={$var['parentId']}&fromTime={$para['fromTime']}&toTime={$para['toTime']}"?>">上级</a>
				<?php }?>
            </td>
		</tr>
	<?php } ?>
		
        
        <?php
#echo "select ((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and r.state=9 and r.isdelete=1 $rechargeTimeWhere)+ (select ifnull(sum(coin),0) from {$this->prename}coin_log where 1=1 and liqType in(1,109) and uid=u.uid  $logTimeWhere)))   from ssc_members u  where 1=1 $userWhere3";
        if($member['type']==0 ){//------------------------------------------
				$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere3";
				$all=$this->getRow($sql2);
				$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(2 ,3) and l.uid=u.uid $fanDiaTimeWhere2 $userWhere3");
				$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53,56) and l.uid=u.uid $brokerageTimeWhere $userWhere3");
//				$all['rechargeAmount']=$this->getValue("select sum((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and ((r.state=9 and r.isdelete=1) or r.state=1) $rechargeTimeWhere)+ (select ifnull(sum(coin),0) from {$this->prename}coin_log where liqType in(1,109) and uid=u.uid  $logTimeWhere))   from ssc_members u  where 1=1 $userWhere3");
            $all['rechargeAmount']=$this->getValue("select sum((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere))   from ssc_members u  where 1=1 $userWhere3");
				$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere3");
				$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere3");

		?>
            
		<tr>
			<td><span class="spn9">本页总结</span></td>
            <td><?=$this->ifs($count['rechargeAmount'], '--')?></td>
			<td><?=$this->ifs($count['cashAmount'], '--')?></td>
			<td><?=$this->ifs($count['betAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount'], '--')?></td>
			<td><?=$this->ifs($count['fanDianAmount'], '--')?></td>
            <td><?=$this->ifs($count['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount']-$count['betAmount']+$count['fanDianAmount']+$count['brokerageAmount'], '--')?></td>
			<td></td>
		</tr>
		<tr>
			<td><span class="spn9">团队总结</span></td>
            <td><?=$this->ifs($count['rechargeAmount'], '--')?></td>
			<td><?=$this->ifs($count['cashAmount'], '--')?></td>
			<td><?=$this->ifs($count['betAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount'], '--')?></td>
			<td><?=$this->ifs($count['fanDianAmount'], '--')?></td>
			<td><?=$this->ifs($count['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount']-$count['betAmount']+$count['fanDianAmount']+$count['brokerageAmount'], '--')?></td>
			<td></td>
		</tr>
		<?php }else{//----------------------------------------
				$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere";
				$all=$this->getRow($sql2);
				$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(2 , 3) and l.uid=u.uid $fanDiaTimeWhere2 $userWhere");
				$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53,56) and l.uid=u.uid $brokerageTimeWhere $userWhere");
//				$all['rechargeAmount']=$this->getValue("select sum((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and ((r.state=9 and r.isdelete=1) or r.state=1) $rechargeTimeWhere)+ (select ifnull(sum(coin),0) from {$this->prename}coin_log where liqType in(1,109) and uid=u.uid  $logTimeWhere))   from ssc_members u  where 1=1 $userWhere");
            $all['rechargeAmount']=$this->getValue("select sum(r.amount) from ssc_member_recharge r where ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere and r.`uid` in (SELECT uid   from ssc_members u  where 1=1 $userWhere)");
				$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere");
				$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere");

		?>

        <tr>
			<td><span class="spn9">本页总结</span></td>
            <td><?=$this->ifs($count['rechargeAmount'], '--')?></td>
			<td><?=$this->ifs($count['cashAmount'], '--')?></td>
			<td><?=$this->ifs($count['betAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount'], '--')?></td>
			<td><?=$this->ifs($count['fanDianAmount'], '--')?></td>
            <td><?=$this->ifs($count['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($count['zjAmount']-$count['betAmount']+$count['fanDianAmount']+$count['brokerageAmount'], '--')?></td>
			<td></td>
		</tr>
		<tr>
			<td><span class="spn9"><?php if(intval($para['userType'])==2){echo '直接下级';}else if(intval($para['userType'])==3){echo '所有下级';}else{echo '直接下级';}?></span></td>
            <td><?=$this->ifs($all['rechargeAmount'], '--')?></td>
			<td><?=$this->ifs($all['cashAmount'], '--')?></td>
			<td><?=$this->ifs($all['betAmount'], '--')?></td>
			<td><?=$this->ifs($all['zjAmount'], '--')?></td>
			<td><?=$this->ifs($all['fanDianAmount'], '--')?></td>
			<td><?=$this->ifs($all['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount']+$all['brokerageAmount'], '--')?></td>
			<td></td>
		</tr>
			<?php if(intval($para['userType'])!=3){
				$sql2="select sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 $betTimeWhere $userWhere3";
				$all=$this->getRow($sql2);
				$all['fanDianAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(2,3) and l.uid=u.uid $fanDiaTimeWhere2 $userWhere3");
				$all['brokerageAmount']=$this->getValue("select sum(l.coin) from {$this->prename}coin_log l, {$this->prename}members u where l.liqType in(50,51,52,53,56) and l.uid=u.uid $brokerageTimeWhere $userWhere3");
//                $all['rechargeAmount']=$this->getValue("select sum((select ifnull(sum(r.amount),0) from ssc_member_recharge r where r.`uid` =u.uid   and ((r.state=9 and r.isdelete=1) or r.state=1) $rechargeTimeWhere)+ (select ifnull(sum(coin),0) from {$this->prename}coin_log where liqType in(1,109) and uid=u.uid  $logTimeWhere))   from ssc_members u  where 1=1    $userWhere3");
                $all['rechargeAmount']=$this->getValue("select sum(r.amount) from ssc_member_recharge r where ((r.state=9 and r.isdelete=0) or r.state=1) $rechargeTimeWhere and r.`uid` in (SELECT  uid  from ssc_members u  where 1=1 $userWhere3)");
				$all['cashAmount']=$this->getValue("select sum(c.amount) from {$this->prename}member_cash c, {$this->prename}members u  where c.state=0 and c.uid=u.uid $cashTimeWhere $userWhere3");
				$all['coin']=$this->getValue("select sum(u.coin) coin from {$this->prename}members u where 1 $userWhere3");
			?>
		<tr>
			<td><span class="spn9">所有下级</span></td>
            <td><?=$this->ifs($all['rechargeAmount'], '--')?></td>
			<td><?=$this->ifs($all['cashAmount'], '--')?></td>
			<td><?=$this->ifs($all['betAmount'], '--')?></td>
			<td><?=$this->ifs($all['zjAmount'], '--')?></td>
			<td><?=$this->ifs($all['fanDianAmount'], '--')?></td>
			<td><?=$this->ifs($all['brokerageAmount'], '--')?></td>
			<td><?=$this->ifs($all['zjAmount']-$all['betAmount']+$all['fanDianAmount']+$all['brokerageAmount'], '--')?></td>
			<td></td>
		</tr>
			<?php }?>
        <?php }?>
	</tbody>
</table>
