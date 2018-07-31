
<?php
class Tip extends WebLoginBase{
	
/**
	 *  提款成功提示
	 */
	public final function getTKTip(){
		$sql="select id from {$this->prename}member_cash where (state=0 or state=4) and isDelete=0 and flag=0 and uid=".$this->user['uid']." order by id desc";
		if($data=$this->getCol($sql)){
			
			if($cookie=$_COOKIE['cash-TKtip']){
				$cookie=explode(',',$cookie);
				if(!array_diff($data, $cookie)) {
				    $info =  array('flag'=>false);
				    $this->outputData(0,$info);
				}
			}
			$this->query("update {$this->prename}member_cash set flag=1 where id=".$data[0]);
			$gdata=$this->getRow("select amount,state,info from {$this->prename}member_cash where id=".$data[0]);
			$amount=$gdata['amount'];
			$state=$gdata['state'];
			$info=$gdata['info'];
			
			$data=implode(',', $data);
			if($data) setcookie('cash-TKtip', $data);

			if(intval($state)==4){
				$info =  array(
					'flag'=>true,
					'message'=>'提款失败！原因：'.$info
				);
			}else{
				$info = array(
					'flag'=>true,
					'message'=>'提款成功！金额：'.$amount.'元'
				);	
			}
			$this->outputData(0,$info);
		}
		$info =  array('flag'=>false);
		$this->outputData(0,$info);
	}
	
	/**
	 *  充值成功提示  //state=1 前台充值  state=9 后台充值
	 */
	public final function getCZTip(){
		$sql="select id from {$this->prename}member_recharge where (state=1 or state=9) and isDelete=0 and flag=0 and uid=".$this->user['uid']." order by id desc";
		if($data=$this->getCol($sql)){
			if($cookie=$_COOKIE['cash-CZtip']){
				$cookie=explode(',',$cookie);
			    if(!array_diff($data, $cookie)) {
				    $info =  array('flag'=>false);
				    $this->outputData(0,$info);
				}
			} 
	 
			$gRs=$this->getCol("select case when state=9 then amount else rechargeAmount end CZAmount from {$this->prename}member_recharge where id=".$data[0]);
			$CZAmount=$gRs[0];
			$this->query("update {$this->prename}member_recharge set flag=1 where id=".$data[0]);
			
			$data=implode(',', $data);
			if($data) setcookie('cash-CZtip', $data);	
			if($CZAmount>0){
				$info = array(
					'flag'=>true,
					'message'=>'充值成功！系统充值：'.$CZAmount.'元'
				);
			}else{
				$info =  array(
					'flag'=>true,
					'message'=>'扣款成功！系统扣款：'.abs($CZAmount).'元'
				);
		   }
		   $this->outputData(0,$info);
		}
		$info =  array('flag'=>false);
		$this->outputData(0,$info);
		
	}
	
    /**
	 *  盈亏提示
	 */
	public final function getYKTip($type, $ctionNo){
		 $type=intval($type);
    	 if($type && $ctionNo){
    		$this->type=$type;
    		$ykMoney=0;
    		//获取彩种
    		$czName=$this->getValue("select title from {$this->prename}type where id={$this->type}");
    		
    		$whereStr=" where type={$this->type} and uid={$this->user['uid']} and actionNo='{$ctionNo}' and isDelete=0 and flag=0 and length(lotteryNo)>0";
    		if($this->getCol("select id from {$this->prename}bets ".$whereStr)){
    			$ykMoney=$this->getValue("select IFNULL(sum(bonus-(mode*beiShu*actionNum*(fpEnable+1)*(1-fanDian/100))),'0') tMoney from {$this->prename}bets ".$whereStr."");
    			if($ykMoney>0){
    				$messager=$czName." 第".$ctionNo."期：盈亏 <font style='color:#F00;font-weight:bold;font-size:14px;'>".round($ykMoney,2)."</font> 元";
    			
    			}else{
    				$messager=$czName." 第".$ctionNo."期：盈亏 <font style='color:#060;font-weight:bold;font-size:14px;'>".round($ykMoney,2)."</font> 元";
    			
    			}
    			$this->query("update {$this->prename}bets set flag=1 ".$whereStr."");
    			$info =  array(
    				'flag'=>true,
    				'message'=>$messager
    			);
    			$this->outputData(0,$info);
    		 }else{
    		     $info =  array(
    		         'flag'=>false,
    		         
    		     );
    		    $this->outputData(0,$info);
    		 }
    	}
    	$info =  array(
    	    'flag'=>false,
    	     
    	);
    	$this->outputData(0,$info);
	}
}