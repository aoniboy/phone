<?php
	//echo $this->userType;
	$para=$_GET;

	$para['state']=intval($para['state']);
	if($para['state']==5){
		$whereStr = " and b.isDelete=1 ";
	}else{
		$whereStr = " and  b.isDelete=0 ";	
	}
	// 彩种限制
	$para['type']=intval($para['type']);
	if($para['type']){
		$whereStr .= " and b.type={$para['type']}";
	}
	
	// 时间限制
	if($para['fromTime'] && $para['toTime']){
		$whereStr .= ' and b.actionTime between '.strtotime($para['fromTime']).' and '.strtotime($para['toTime']);
	}elseif($para['fromTime']){
		$whereStr .= ' and b.actionTime>='.strtotime($para['fromTime']);
	}elseif($para['toTime']){
		$whereStr .= ' and b.actionTime<'.strtotime($para['toTime']);
	}else{
		if($GLOBALS['fromTime'] && $GLOBALS['toTime']){
			$whereStr .= ' and b.actionTime between '.$GLOBALS['fromTime'].' and '.$GLOBALS['toTime'].' ';
		}
	}
	
	// 投注状态限制
	if($para['state']){
	switch($para['state']){
		case 1:
			// 已派奖
			$whereStr .= ' and b.zjCount>0';
		break;
		case 2:
			// 未中奖
			$whereStr .= " and b.zjCount=0 and b.lotteryNo!='' and b.isDelete=0";
		break;
		case 3:
			// 未开奖
			$whereStr .= " and b.lotteryNo=''";
		break;
		case 4:
			// 追号
			$whereStr .= ' and b.zhuiHao=1';
		break;
		case 5:
			// 撤单
			$whereStr .= ' and b.isDelete=1';
		break;
		}
	}
	
	// 模式限制
	$para['mode']=floatval($para['mode']);
	if($para['mode']) $whereStr .= " and b.mode={$para['mode']}";
	
   //单号
   $para['betId']=wjStrFilter($para['betId']);
   if($para['betId'] && $para['betId']!='输入单号'){
	   if(!ctype_alnum($para['betId'])) throw new Exception('单号包含非法字符,请重新输入');
       $whereStr .= " and b.wjorderId='{$para['betId']}'";}
   
   //用户限制
   $whereStr .= " and b.uid={$this->user['uid']}";
	$sql="select b.*, u.username from {$this->prename}bets b, {$this->prename}members u where b.uid=u.uid";
	$sql.=$whereStr;
	$sql.=' order by id desc, actionTime desc';
	
	$data=$this->getPage($sql, $this->page, $this->pageSize);
	//print_r($data);
	$params=http_build_query($para, '', '&');
	
	$modeName=array('2.00'=>'元', '0.20'=>'角', '0.02'=>'分');
?>
<?php if($this->page==1) {?>
<table width="100%" class='f24 tc'>
	<thead>
		<tr class="table_b_th">
			<td>编号</td>
			<td>期号</td>
			<td>玩法</td>
			<td>总额(元)</td>
			<td>奖金(元)</td>
			<td>状态</td>
            <td>操作</td>
		</tr>
	</thead>
	<tbody class="table_b_tr">
	<?php }?>
	<?php if($data['data']){ 
	foreach($data['data'] as $var){ ?>
		<tr>
			<td data-id="<?=$var['id']?>" class="orderdetail">
				<?=$var['wjorderId']?>
			</td>
			<td><?=$var['actionNo']?></td>
			<td><?=$this->playeds[$var['playedId']]['name']?></td>
			<td><?=$var['mode']*$var['beiShu']*$var['actionNum']*($var['fpEnable']+1)?></td>
			<td><?=$this->iff($var['lotteryNo'], number_format($var['bonus'], 2), '0.00')?></td>
			<td>
			<?php
				if($var['isDelete']==1){
					echo '<font color="#999999">已撤单</font>';
				}elseif(!$var['lotteryNo']){
					echo '<font color="#009900">未开奖</font>';
				}elseif($var['zjCount']){
					echo '<font color="red">已派奖</font>';
				}else{
					echo '未中奖';
				}
			?>
			</td>
            <td>
            <?php if($var['lotteryNo'] || $var['isDelete']==1 || $var['kjTime']<$this->time || $var['qz_uid']){ ?>
				--
			<?php }else{ ?>
				<a class="chedan" id="<?=$var['id']?>" href="javascript:void(0)" data-href="/index.php/game/deleteCode/<?=$var['id']?>" dataType="json" call="deleteBet" title="是否确定撤单" target="ajax">撤单</a>
			<?php } ?>
            </td>
		</tr>
	<?php } }else{ ?>
    <?php if($this->page==1) {?><tr><td colspan="12">暂无投注信息</td></tr><?php } ?>
    <?php } ?>
    <?php if($this->page==1) {?>
	</tbody>
</table>
<?php } ?>