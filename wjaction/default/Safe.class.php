<?php
@session_start();
class Safe extends WebLoginBase{
	public $title='香雨娱乐平台';
	private $vcodeSessionName='ssc_vcode_session_name';
	/**
	 * 我的页面
	 */
	public final function my(){
	    $this->my = 'active';
	    $this->freshSession();
		$this->display('newsafe/my.php');
	}
	/**
	 * 用户信息页面
	 */
	public final function info(){
	    $this->my = 'active';
	    $sql="select password, coinPassword from {$this->prename}members where uid=?";
	    $pwd=$this->getRow($sql, $this->user['uid']);
	    if(!$pwd['coinPassword']){
	        $coinPassword=false;
	    }else{
	        $coinPassword=true;
	    }
	    $this->coinPassword =  $coinPassword;
		$this->display('newsafe/my_info.php');
	}
	/**
	 * 密码管理
	 */
	public final function passwd(){
		$sql="select password, coinPassword from {$this->prename}members where uid=?";
		$pwd=$this->getRow($sql, $this->user['uid']);
		if(!$pwd['coinPassword']){
			$coinPassword=false;
		}else{
			$coinPassword=true;
		}

		$this->display('newsafe/my_info_edit.php',0,$coinPassword);
	}
	
	/**
	 * 设置密码
	 */
	public final function setPasswd(){
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  $this->outputData(1,array(),'数据包被篡改，请重新操作');

		$opwd=$_POST['oldpassword'];
		if(!$opwd) $this->outputData(1,array(),'原密码不能为空');
		if(strlen($opwd)<6) $this->outputData(1,array(),'原密码至少6位');
		if(!$npwd=$_POST['newpassword']) $this->outputData(1,array(),'密码不能为空');
		if(strlen($npwd)<6) $this->outputData(1,array(),'密码至少6位');
		
		$sql="select password from {$this->prename}members where uid=?";
		$pwd=$this->getValue($sql, $this->user['uid']);
		
		$opwd=md5($opwd);
		if($opwd!=$pwd) $this->outputData(1,array(),'原密码不正确');
		
		$sql="update {$this->prename}members set password=? where uid={$this->user['uid']}";
		if($this->update($sql, md5($npwd))) $this->outputData(0,array(),'修改密码成功');
		$this->outputData(1,array(),'修改密码失败');
	}
	
	/**
	 * 设置资金密码
	 */
	public final function setCoinPwd(){
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  $this->outputData(1,array(),'数据包被篡改，请重新操作');

		$opwd=$_POST['oldpassword'];
		if(!$npwd=$_POST['newpassword'])  $this->outputData(1,array(),'资金密码不能为空');
		if(strlen($npwd)<6) $this->outputData(1,array(),'资金密码至少6位');
		
		$sql="select password, coinPassword from {$this->prename}members where uid=?";
		$pwd=$this->getRow($sql, $this->user['uid']);
		if(!$pwd['coinPassword']){
			$npwd=md5($npwd);
			if($npwd==$pwd['password']) $this->outputData(1,array(),'资金密码与登录密码不能一样');
			$tishi='资金密码设置成功';
		}else{
			if($opwd && md5($opwd)!=$pwd['coinPassword']) $this->outputData(1,array(),'原资金密码不正确');
			$npwd=md5($npwd);
			if($npwd==$pwd['password']) $this->outputData(1,array(),'资金密码与登录密码不能一样');
			$tishi='资金密码设置成功';
		}
		$sql="update {$this->prename}members set coinPassword=? where uid={$this->user['uid']}";
		if($this->update($sql, $npwd)) $this->outputData(0,array(),$tishi);
		$this->outputData(1,array(),'修改资金密码失败');
	}
	
	public final function setCoinPwd2(){
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  $this->outputData(1,array(),'数据包被篡改，请重新操作');
		$opwd=$_POST['oldpassword'];
		if(!$opwd) $this->outputData(1,array(),'原资金密码不能为空');
		if(strlen($opwd)<6) $this->outputData(1,array(),'原资金密码至少6位');
		if(!$npwd=$_POST['newpassword']) $this->outputData(1,array(),'资金密码不能为空');
		if(strlen($npwd)<6) $this->outputData(1,array(),'资金密码至少6位');
		
		$sql="select password, coinPassword from {$this->prename}members where uid=?";
		$pwd=$this->getRow($sql, $this->user['uid']);
		if(!$pwd['coinPassword']){
			$npwd=md5($npwd);
			if($npwd==$pwd['password']) $this->outputData(1,array(),'资金密码与登录密码不能一样');
			$tishi='资金密码设置成功';
		}else{
			if($opwd && md5($opwd)!=$pwd['coinPassword']) $this->outputData(1,array(),'原资金密码不正确');
			$npwd=md5($npwd);
			if($npwd==$pwd['password']) $this->outputData(1,array(),'资金密码与登录密码不能一样');
			$tishi = "修改资金密码成功";
		}
		$sql="update {$this->prename}members set coinPassword=? where uid={$this->user['uid']}";
		if($this->update($sql, $npwd)) $this->outputData(0,array(),$tishi);
		$this->outputData(1,array(),'修改资金密码失败');
	}
	
	/**
	 * 设置银行帐户
	 */
	public final function setCBAccount(){
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  $this->outputData(1,array(),'数据包被篡改，请重新操作');

		if(!$_POST) $this->outputData(1,array(),'参数出错');

		$update['account']=wjStrFilter($_POST['account']);
		$update['countname']=wjStrFilter($_POST['countname']);
		$update['username']=wjStrFilter($_POST['username']);
		$update['bankId']=intval($_POST['bankId']);
		$update['coinPassword']=$_POST['coinPassword'];

		if(!isset($update['account'])) $this->outputData(1,array(),'请填写银行账号!');
		if(!isset($update['countname'])) $this->outputData(1,array(),'请填写开户行!');
		if(!isset($update['username'])) $this->outputData(1,array(),'请填写账户名!');
		if(!isset($update['bankId'])) $this->outputData(1,array(),'请选择银行类型!');

		$x=strlen($update['countname']);$a=strlen($update['username']);
		$y=mb_strlen($update['countname'],'utf8');$b=mb_strlen($update['username'],'utf8');
		if(($x!=$y && $x%$y==0)==FALSE) $this->outputData(1,array(),'开户行必须为汉字');
		
		unset($x);unset($y);
		

		// 更新用户信息缓存
		$this->freshSession();
		if(md5($update['coinPassword'])!=$this->user['coinPassword']) $this->outputData(1,array(),'资金密码不正确');
		unset($update['coinPassword']);
		$update['uid']=$this->user['uid'];
		$update['editEnable']=0;//设置过银行
		
		//检查银行账号唯一
		if($account=$this->getValue("select account FROM {$this->prename}member_bank where account=? LIMIT 1",$update['account'])) $this->outputData(1,array(),'该'.$account.'银行账号已经使用');
		//检查账户名唯一
		if($account=$this->getValue("select username FROM {$this->prename}member_bank where account=? LIMIT 1",$update['username'])) $this->outputData(1,array(),'该'.$username.'账户名已经使用');
			
		if($bank=$this->getRow("select editEnable from {$this->prename}member_bank where uid=? LIMIT 1", $this->user['uid'])){
		    unset($update['username']);
			if($bank['editEnable']!=1) $this->outputData(1,array(),'银行信息绑定后不能随便更改，如需更改，请联系在线客服');
			if($this->updateRows($this->prename .'member_bank', $update, 'uid='. $this->user['uid'])){
				$this->outputData(0,array(),'更改银行信息成功');
			}else{
				$this->outputData(1,array(),'更改银行信息出错');
			}
		}else{
		    if(($a!=$b && $a%$b==0)==FALSE) $this->outputData(1,array(),'用户名必须为汉字');
		    unset($a);unset($b);
			if($this->insertRow($this->prename .'member_bank', $update)){
				// 如果是工行，参与工行卡首次绑定活动
				if($update['bankId']==1){
					$this->getSystemSettings();
					if($coin=floatval($this->settings['huoDongRegister'])){
						$liqType=51;
						$info='首次绑定工行卡赠送';
						$ip=$this->ip(true);
						$bankAccount=$update['account'];
						
						// 查找是否已经赠送过
						$sql="select id from {$this->prename}coin_log where liqType=$liqType and (`uid`={$this->user['uid']} or extfield0=$ip or extfield1='$bankAccount') limit 1";
						if(!$this->getValue($sql)){
							$this->addCoin(array(
								'coin'=>$coin,
								'liqType'=>$liqType,
								'info'=>$info,
								'extfield0'=>$ip,
								'extfield1'=>$bankAccount
							));
							$this->outputData(0,array(),sprintf('更改银行信息成功，由于你第一次绑定工行卡，系统赠送%.2f元', $coin));
						}
					}
				}
				$this->outputData(0,array(),'更改银行信息成功');
			}else{
				$this->outputData(0,array(), '更改银行信息出错');
			}
		}
	}

//设置登陆问候语
public final function care(){
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  throw new Exception('数据包被非法篡改，请重新操作');

		if(!$_POST) throw new Exception('提交参数出错');

		//过滤未知字段
		$update['care']=wjStrFilter($_POST['care']);

        //问候语长度限制
		$len=mb_strlen($update['care'],'utf8');
		if($len>10) throw new Exception( '登陆问候语过长，请重新输入');
		if($len=0) throw new Exception( '登陆问候语不能为空，请重新输入');

		if($this->updateRows($this->prename .'members', $update, 'uid='. $this->user['uid'])){
				return '更改登陆问候语成功';
			}else{
				throw new Exception( '更改登陆问候语出错');
			}
  }

 //设置昵称
public final function nickname(){
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  throw new Exception('数据包被非法篡改，请重新操作');

		if(!$_POST) throw new Exception('提交参数出错');

		//过滤未知字段
		$update['nickname']=wjStrFilter($_POST['nickname']);

		$len=mb_strlen($update['nickname'],'utf8');
		if($len>8) throw new Exception( '昵称过长，请重新输入');
		if($len=0) throw new Exception( '昵称不能为空，请重新输入');

		if($this->updateRows($this->prename .'members', $update, 'uid='. $this->user['uid'])){
				return '更改昵称成功';
			}else{
				throw new Exception( '更改昵称出错');
			}
  }
}
