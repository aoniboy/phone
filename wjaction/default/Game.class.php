<?php
include_once 'Bet.class.php';
class Game extends WebLoginBase{
    
    //验证是否可以投注
	public final function checkBuy(){
		$actionNo="";
		if($this->settings['switchBuy']==0){
			$actionNo['flag']=1;
		}
		$this->outputData(0,$actionNo);
	}
	
	public final function postCode(){
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/postcode/'.date('Ymd'),date('Y-m-d H:i:s').$_SERVER['HTTP_REFERER'].'=='. $_SERVER['HTTP_X_REAL_HOST']."\n",FILE_APPEND);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/postcode/'.date('Ymd'),json_encode($_POST)."\n\n",FILE_APPEND);
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck!=$urldan)  $this->outputData(1,array(),'请勿站外投注，谢谢合作');

		$codes=$_POST['code'];
		$para=$_POST['para'];
		$amount=0;
		$fpcount=1;  //飞盘 默认为1
                if(!ctype_digit($codes[0]['actionNum'])) $this->outputData(1,array(),'注数只能为整数');
		if(!ctype_digit($codes[0]['beiShu'])) $this->outputData(1,array(),'倍数只能为整数');
		if(!ctype_digit($codes[0]['weiShu'])) $this->outputData(1,array(),'位数只能为整数');
		$this->getSystemSettings();
		if($this->settings['switchBuy']==0) $this->outputData(1,array(),'本平台已经停止购买！');
		if($this->settings['switchDLBuy']==0 && $this->user['type'])  $this->outputData(1,array(),'代理不能买单！');
		if(count($codes)==0) $this->outputData(1,array(),'请先选择号码再提交投注');
		//检查时间 期数
		$ftime=$this->getTypeFtime($para['type']);  //封单时间
		$actionTime=$this->getGameActionTime($para['type']);  //当期时间
		$actionNo=$this->getGameActionNo($para['type']);  //当期期数
		if($actionTime!=$para['kjTime'])  $this->outputData(1,array(),'投注失败：你投注第'.$para['actionNo'].'已过购买时间');
		if($actionNo!=$para['actionNo'])  $this->outputData(1,array(),'投注失败：你投注第'.$para['actionNo'].'已过购买时间');
		if($actionTime-$ftime<$this->time) $this->outputData(1,array(),'投注失败：你投注第'.$para['actionNo'].'已过购买时间');
		
		// 查检每注的赔率是否正常
		$this->getPlayeds();
		foreach($codes as $code){
			$played=$this->playeds[$code['playedId']];
			//检查开启
			if(!$played['enable']) $this->outputData(1,array(),'游戏玩法组已停,请刷新再投');
			//检查赔率
			$chkBonus=($played['bonusProp']-$played['bonusPropBase'])/$this->settings['fanDianMax']*$this->user['fanDian']+$played['bonusPropBase']-($played['bonusProp']-$played['bonusPropBase'])*$code['fanDian']/$this->settings['fanDianMax'];//实际奖金
			//echo $chkBonus ;
			if($code['bonusProp']>$played['bonusProp']) $this->outputData(1,array(),'提交奖金大于最大奖金，请重新投注');
			if($code['bonusProp']<$played['bonusPropBase']) $this->outputData(1,array(),'提交奖金小于最小奖金，请重新投注');
			if(intval($chkBonus)!=intval($code['bonusProp'])) $this->outputData(1,array(),'提交奖金出错，请重新投注');
			//检查返点
			if(floatval($code['fanDian'])>floatval($this->user['fanDian']) || floatval($code['fanDian'])>floatval($this->settings['fanDianMax'])) $this->outputData(1,array(),'提交返点出错，请重新投注');
			//检查倍数
			if(intval($code['beiShu'])<1) $this->outputData(1,array(),'倍数只能为大于1正整数');
			//检查模式
			if($this->settings['fenmosi']==1){
			    if($code['mode']!=2 && $code['mode']!=0.2 && $code['mode']!=0.02) $this->outputData(1,array(),'模式出错，请重新投注');
			}else{
				if($code['mode']!=2 && $code['mode']!=0.2) $this->outputData(1,array(),'模式出错，请重新投注');
			}

			// 检查注数
			if($code['actionNum']<1) $this->outputData(1,array(),'注数不能小于1，请重新投注');
			if($betCountFun=$played['betCountFun']){
				if($played['betCountFun']=='descar'){
					if($code['actionNum']>Bet::$betCountFun($code['actionData'])) $this->outputData(1,array(),'提交注数出错，请重新投注');	
				}else{
					if($code['actionNum']!=Bet::$betCountFun($code['actionData'])) $this->outputData(1,array(),'提交注数出错，请重新投注');
				}
			}
		    //最大注数检查
            $maxcount=$this->getmaxcount($code['playedId']);
			if($code['actionNum']>$maxcount) $this->outputData(1,array(),'注数超过该玩法最高注数:'.$maxcount.'注,请重新投注');
    
            $code=current($codes);
    		if(!isset($para['qzEnable'])) $para['qzEnable']=0;
    		if($para['fpEnable'])  $fpcount=2;
    		if(isset($para['actionNo'])) unset($para['actionNo']);
    		if(isset($para['kjTime'])) unset($para['kjTime']);
    		$para=array_merge($para, array(
    			'actionTime'=>$this->time,
    			'actionNo'=>$actionNo,
    			'kjTime'=>$actionTime,
    			'actionIP'=>$this->ip(true),
    			'uid'=>$this->user['uid'],
    			'username'=>$this->user['username'],
    			'serializeId'=>uniqid(),
    			'nickname'=>$this->user['nickname']
    		));
    		
    		$code=array_merge($code, $para);
    
    		if($zhuihao=$_POST['zhuiHao']){
    			$liqType=102;
    			$codes=array();
    			$info='追号投注';
    			
    			if(isset($para['actionNo'])) unset($para['actionNo']);
    			if(isset($para['kjTime'])) unset($para['kjTime']);
    			
    			foreach(explode(';', $zhuihao) as $var){
    				list($code['actionNo'], $code['beiShu'], $code['kjTime'])=explode('|', $var);
    				$code['kjTime']=strtotime($code['kjTime']);
    				$actionNo=$this->getGameNo($para['type'],$code['kjTime']-1);
    
    				//if($actionNo['actionNo']!=$code['actionNo'])  throw new Exception('投注失败：你追号投注第'.$code['actionNo'].'已过购买时间');
    				if(strtotime($actionNo['actionTime'])-$ftime<$this->time) $this->outputData(1,array(),'投注失败：你追号投注第'.$code['actionNo'].'已过购买时间');
    				$codes[]=$code;
    				$amount+=abs($code['actionNum']*$code['mode']*$code['beiShu']*$fpcount);
    			}
    		}else{
    			$liqType=101;
    			$info='投注';
    
    			foreach($codes as $i=>$code){
    				$codes[$i]=array_merge($code, $para);
    				$amount+=abs($code['actionNum']*$code['mode']*$code['beiShu']*$fpcount);
    			}
    		}
	    }
		// 查询用户可用资金
		$userAmount=$this->getValue("select coin from {$this->prename}members where uid={$this->user['uid']}");
		if($userAmount < $amount) $this->outputData(1,array(),'您的可用资金不足，请充值。');

		// 开始事物处理
		$this->beginTransaction();
		try{
			foreach($codes as $code){
				// 插入投注表
				$code['wjorderId']=$code['type'].$code['playedId'].$this->randomkeys(8-strlen($code['type'].$code['playedId']));
				$code['actionNum']=abs($code['actionNum']);
				$code['mode']=abs($code['mode']);
				$code['beiShu']=abs($code['beiShu']);
				$amount=abs($code['actionNum']*$code['mode']*$code['beiShu']*$fpcount);
				unset($code['del_id'],$code['money'],$code['title'],$code['all_stake'],$code['all_money'],$code['playid'],$code['groupid']);
				
				$this->insertRow($this->prename .'bets', $code);
				// 添加用户资金流动日志
				$this->addCoin(array(
					'uid'=>$this->user['uid'],
					'type'=>$code['type'],
					//'playedId'=>$para['playedId'],
					'liqType'=>$liqType,
					'info'=>$info,
					'extfield0'=>$this->lastInsertId(),
					'extfield1'=>$para['serializeId'],
					//'extfield2'=>$data['orderId'],
					'coin'=>-$amount,
					//'fcoin'=>$amount
				));
			}
			// 返点与积分等开奖时结算

			$this->commit();
			$this->outputData(0,array(),'投注成功');
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	
	public final function getKJinfo($type) {
	    $this->type = intval($type);
	    $lastNo=$this->getGameLastNo($this->type);
	    $kjHao=$this->getValue("select data from {$this->prename}data where type={$this->type} and number='{$lastNo['actionNo']}'");
	    if($kjHao) $kjHao=explode(',', $kjHao);
	    $tnumber = '';		 	    
	    foreach($kjHao as $k=>$v) {
	        
                if(in_array($type, array(54,55))) {
                    $operate = "`+`";
                    if ($k == 2) {
                        $operate = "=";
                    }
                    
                    $tnumber .= str_replace("`+`", "+",  $v .  $operate );
                }else {
                    $tnumber .= "<span>$v</span>";
                }
	    }
	    if(in_array($type, array(54,55))) { 
                $data['kjNo'] = $tnumber.array_sum($kjHao);
            }else {
                $data['kjNo'] = $tnumber;
            }
	    $this->outputData(0,$data);
	}
	
	public final function getQhinfo($type) {
	    $this->type = intval($type);
	    $lastNo=$this->getGameLastNo($this->type);
	    $kjHao=$this->getValue("select data from {$this->prename}data where type={$this->type} and number='{$lastNo['actionNo']}'");
	    if($kjHao) $kjHao=explode(',', $kjHao);
	    $actionNo=$this->getGameNo($this->type);

	    $types=$this->getTypes();
	    $kjdTime=$types[$this->type]['data_ftime'];
	    $diffTime=strtotime($actionNo['actionTime'])-$this->time-$kjdTime;
	    $kjDiffTime=strtotime($lastNo['actionTime'])-$this->time;
	    $actionNo['difftime'] = $diffTime;
	    $actionNo['diffKTime'] = $kjDiffTime;
	    $actionNo['diffFTime'] = $kjdTime;
	    $data['name'] = $this->types[$type]['title'];
	    $data['actionNo'] = $actionNo;
	    $data['lastNo'] = $lastNo;
	    $tnumber = '';
	    foreach($kjHao as $k=>$v) {
	        
                if(in_array($type, array(54,55))) {
                    $operate = "`+`";
                    if ($k == 2) {
                        $operate = "=";
                    }
                    
                    $tnumber .= str_replace("`+`", "+",  $v .  $operate );
                }else {
                    $tnumber .= "<span>$v</span>";
                }
	    }
	    if(in_array($type, array(54,55))) { 
                $data['kjNo'] = $tnumber.array_sum($kjHao);
            }else {
                $data['kjNo'] = $tnumber;
            }
	    $data['num'] = $types[$this->type]['num'];
	     
	    $this->outputData(0,$data);
	}
	
	public final function getNo($type){
		$type=intval($type);
		$actionNo=$this->getGameNo($type);
		if($type==1 && $actionNo['actionTime']=='00:00'){
			$actionNo['actionTime']=strtotime($actionNo['actionTime'])+24*3600;
		}else{
			$actionNo['actionTime']=strtotime($actionNo['actionTime']);
		}
		$data['actionNo'] = $actionNo;
		$this->outputData(0,$data);
		
	}
	//{{{ 庄内庄投注
	public final function znzPost($id){
		if(!$id=intval($id)) throw new Exception('参数错误1');
		if(!$para=$_POST) throw new Exception('参数错误2');
		if($para['fanDianAmount']<0) throw new Exception('参数错误3');
		if($para['qz_chouShui']<0) throw new Exception('参数错误4');
		$this->beginTransaction();
		try{
			$data=$this->getRow("select * from {$this->prename}bets where id=$id");
			$amount=abs($data['mode']/2 * $data['beiShu'] * $data['bonusProp']) + abs($para['fanDianAmount']) + abs($para['qz_chouShui']);
			if(!$data) throw new Exception('参数错误5');
			if($para['qz_fcoin']<$amount) throw new Exception('参数错误6');
			if($data['isDelete']) throw new Exception('投注已经撤单');
			if($data['qz_uid']) throw new Exception('已经被别人抢庄了');
			if($data['uid']==$this->user['uid']) throw new Exception('不能抢自己的庄');
			if($amount>$this->user['coin']) throw new Exception('你的资金余额不足');
			
			// 冻结时间后不能抢庄
			$this->getTypes();
			$ftime=$this->getTypeFtime($data['type']);
			if($data['kjTime']-$ftime<$this->time) throw new Exception('这期已经结冻，不能抢庄');
			
			$para['qz_uid']=$this->user['uid'];
			$para['qz_username']=$this->user['username'];
			$para['qz_time']=$this->time;
			
			if($this->updateRows($this->prename .'bets', $para, 'id='.$id)){
				$amount=abs($para['qz_fcoin']);
				$this->addCoin(array(
					'uid'=>$this->user['uid'],
					'type'=>$data['type'],
					'liqType'=>100,
					'info'=>'抢庄投注',
					'extfield0'=>$data['id'],
					'fcoin'=>$amount,
					'coin'=>-$amount
				));
			}
			
			$this->commit();
			return '抢庄成功';
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	//}}}
	/**
	 * ajax取定单列表
	 */
	public final function getOrdered($type=null){
		$type=intval($type);
		if(!$this->type) $this->type=$type;
		if(!$this->types) $this->getTypes();
		if(!$this->playeds) $this->getPlayeds();
		$modes=array(
		    '0.02'=>'分',
		    '0.20'=>'角',
		    '2.00'=>'元'
		);
		$toTime=strtotime('00:00:00');
		$sql="select id,wjorderId,actionNo,actionTime,fpEnable,zjCount,playedId,type,actionData,beiShu,mode,actionNum,lotteryNo,bonus,isDelete,kjTime,qz_uid from {$this->prename}bets where   uid={$this->user['uid']} and actionTime>{$toTime} order by id desc limit 10";
		if($list=$this->getRows($sql, $actionNo['actionNo'])){
		    
		    foreach($list as $key=> $var){
		      $list[$key]['gamename'] = $this->types[$var['type']]['shortName'];
		      $list[$key]['playname'] = $this->playeds[$var['playedId']]['name'];
		      $list[$key]['playmode'] = $modes[$var['mode']];
		      $list[$key]['money'] = $var['beiShu']*$var['mode']*$var['actionNum']*(intval($this->iff($var['fpEnable'], '2', '1')));
		      if($var['lotteryNo'] || $var['isDelete']==1 || $var['kjTime']<$this->time || $var['qz_uid']){ 

                  if($var['isDelete']==1){
                      $list[$key]['status'] = 1;//已撤单
                  }elseif(!$var['lotteryNo']){
                      $list[$key]['status'] = 2;//未开奖
                  }else if($var['zjCount'] ){
                      $list[$key]['status'] = 3;//中奖
                  }elseif($var['type']==14 && $var['lotteryNo'] ){
                      if( ($var['kjTime']+20) >strtotime(date("Y-m-d H:i:s")) ){
                          $list[$key]['status'] = 2;//未开奖
                      }else{
                          $list[$key]['status'] = 4;//未中奖
                      }
                  }else{
                      $list[$key]['status'] = 4;//未中奖
                  }
      
               }else{
                   $list[$key]['status'] = 5;//可以撤单显示撤单操作
               } 
		   }
		}
		$this->outputData(0,$list);
		
	}
	/**
	 *  ajax撤单
	 */
	public final function deleteCode($id){
		$id=intval($id);
		$this->beginTransaction();
		try{
			$sql="select * from {$this->prename}bets where id=?";
			if(!$data=$this->getRow($sql, $id)) $this->outputData(1,array(),'找不到定单。');
			if($data['isDelete']) $this->outputData(1,array(),'这单子已经撤单过了。');
			if($data['uid']!=$this->user['uid']) $this->outputData(1,array(),'这单子不是您的，您不能撤单。');		// 可考虑管理员能给用户撤单情况
			if($data['kjTime']<=$this->time) $this->outputData(1,array(),'已经开奖，不能撤单');
			if($data['lotteryNo']) $this->outputData(1,array(),'已经开奖，不能撤单');
			if($data['qz_uid']) $this->outputData(1,array(),'单子已经被人抢庄，不能撤单');

			// 冻结时间后不能撤单
			$this->getTypes();
			$ftime=$this->getTypeFtime($data['type']);
			if($data['kjTime']-$ftime<$this->time) $this->outputData(1,array(),'这期已经结冻，不能撤单');

			$amount=$data['beiShu'] * $data['mode'] * $data['actionNum'] * (intval($this->iff($data['fpEnable'], '2', '1')));
			$amount=abs($amount);
			// 添加用户资金变更日志
			$this->addCoin(array(
				'uid'=>$data['uid'],
				'type'=>$data['type'],
				'playedId'=>$data['playedId'],
				'liqType'=>7,
				'info'=>"撤单",
				'extfield0'=>$id,
				'coin'=>$amount,
				//'fcoin'=>-$amount
			));

			// 更改定单为已经删除状态
			$sql="update {$this->prename}bets set isDelete=1 where id=?";
			$this->update($sql, $id);

			$this->commit();
			$this->outputData(0,array());
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
        
        public final function getKjListInfo($type) {
	    $type = intval($type);
            $sql = "select sd.type, sd.time, sd.number, sd.data,st.title from ssc_data sd,ssc_type st where sd.type = {$type} and st.id={$type}  order by sd.id desc  limit 0,5 ";
            $result = $this->getRows($sql);
            foreach ($result as $key => $val) {
                $result[$key]['time'] = date("Y-m-d H:i", $val['time']);
                $data = explode(",", $val['data']);
                $tnumber = [];
                foreach ($data as $k => $v) {
                    $operate = "`+`";
                    if ($k == 2) {
                        $operate = "=";
                    }
                    $tnumber[] = str_replace("`+`", "+", '<span class="qi_num">' . $v . '</span><span class="col_red">' . $operate . '</span>');
                }
                $sum = array_sum($data);
                $sumstr = self::calcBigNumber($sum) . "、" . self::calcDanNumber($sum);
                $tnumber[] = '<span class="qi_num qi_lv">' . $sum . '</span>（' . $sumstr . '）';
                $result[$key]['tnumber'] = implode("", $tnumber);
            }
            $this->result = $result;
            $data = $this->fetch('newplay/toplist.php');
	    $this->outputData(0,$data);
	}
        
        
    public static function calcBigNumber($number) {
        $result = "";
        if ($number >= 14 && $number <= 27) {
            $result = "大";
        } else {
            $result = "小";
        }
        return $result;
    }

    public static function calcDanNumber($number) {
        $result = "";
        if ($number % 2 == 0) {
            $result = "双";
        } else {
            $result = "单";
        }
        return $result;
    }
}
