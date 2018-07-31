<?php

@session_start();
class User extends WebBase{
	public $title='FUN娱乐平台';
	private $vcodeSessionName='ssc_vcode_session_name';
	
	/**
	 * 用户登录页面
	 */
	public final function login(){
		$this->display('newuser/login.php');
	}
	
	/**
	 * 用户登录页面2
	 */
	public final function loginto(){
		$this->display('user/loginto.php');
	}
	public final function login2(){
	    $this->display('user/login.php');
	}
	
	/**
	 * 用户登出操作
	 */
	public final function logout(){
		$_SESSION=array();
		header('location: /index.php/user/login');
	}
	
	public final function bulletin(){
		$this->display('user/bulletin.php');
	}
	
	private function getBrowser(){
		$flag=$_SERVER['HTTP_USER_AGENT'];
		$para=array();
		
		// 检查操作系统
		if(preg_match('/Windows[\d\. \w]*/',$flag, $match)) $para['os']=$match[0];
		
		if(preg_match('/Chrome\/[\d\.\w]*/',$flag, $match)){
			// 检查Chrome
			$para['browser']=$match[0];
		}elseif(preg_match('/Safari\/[\d\.\w]*/',$flag, $match)){
			// 检查Safari
			$para['browser']=$match[0];
		}elseif(preg_match('/MSIE [\d\.\w]*/',$flag, $match)){
			// IE
			$para['browser']=$match[0];
		}elseif(preg_match('/Opera\/[\d\.\w]*/',$flag, $match)){
			// opera
			$para['browser']=$match[0];
		}elseif(preg_match('/Firefox\/[\d\.\w]*/',$flag, $match)){
			// Firefox
			$para['browser']=$match[0];
		}else{
			$para['browser']='unkown';
		}
		//print_r($para);exit;
		return $para;
	}
	
	/**
	 * 用户登录检查
	 */
	public final function logined(){
		$username=wjStrFilter($_POST['username']);
		$vcode=$_POST['vcode'];

        if(!ctype_alnum($username)) $this->outputData(1,array(),'用户名包含非法字符,请重新输入');

		if(!isset($username)){
			$this->outputData(1,array(),'请输入用户名');
		}
		if(!isset($vcode)){
			$this->outputData(1,array(),'请输入验证码');
		}
		
		if($vcode!=$_SESSION[$this->vcodeSessionName]){
			$this->outputData(1,array(),'验证码不正确。');
		}
		
		$sql="select * from {$this->prename}members where isDelete=0 and admin=0 and username=?";
		if(!$user=$this->getRow($sql, $username)){
			$this->outputData(1,array(),'用户名不正确');
		}
		if(!$user['enable']){
			$this->outputData(1,array(),'您的帐号被冻结，请联系管理员。');
		}
		setcookie('username',$user['username']);
		if($user['care']){
		   setcookie('care',$user['care']);
		}else{
		   setcookie('care',"尚未设置，请尽快设置吧。");
		}
	}
	/**
	 * 用户登录检查2
	 */
	public final function loginedto(){

	    $username=wjStrFilter($_POST['username']);
        $password=wjStrFilter($_POST['password']);

		if(!ctype_alnum($username)) throw new Exception('用户名包含非法字符,请重新登陆');
		
		if(!$username){
			 throw new Exception('请输入用户名');
		}
		
		if(!$password){
			 throw new Exception('不允许空密码登录');
		}
		
		$sql="select * from {$this->prename}members where isDelete=0 and admin=0 and username=?";
		if(!$user=$this->getRow($sql, $username)){
			 throw new Exception('用户名或密码不正确');
		}
		
		if(md5($password)!=$user['password']){
			 throw new Exception('密码不正确');
		}

		if(!$user['enable']){
			 throw new Exception('您的帐号被冻结，请联系管理员。');
		}

		$session=array(
			'uid'=>$user['uid'],
			'username'=>$user['username'],
			'session_key'=>session_id(),
			'loginTime'=>$this->time,
			'accessTime'=>$this->time,
			'loginIP'=>self::ip(true)
		);
		
		$session=array_merge($session, $this->getBrowser());
		
		if($this->insertRow($this->prename.'member_session', $session)){
			$user['sessionId']=$this->lastInsertId();
		}
		$_SESSION[$this->memberSessionName]=serialize($user);
		
		// 把别人踢下线
		$this->update("update ssc_member_session set isOnLine=0 where uid={$user['uid']} and id < {$user['sessionId']}");

		return $user;
	}

	/**
	 * 验证码产生器
	 */
	public final function vcode($rmt=null){
		$lib_path=$_SERVER['DOCUMENT_ROOT'].'/lib/';
		include_once $lib_path .'classes/CImage.class';
		$width=72;
		$height=24;
		$img=new CImage($width, $height);
		$img->sessionName=$this->vcodeSessionName;
		$img->printimg('png');
	}
	
	/**
	 * 推广注册
	 */
	public final function r($userxxx){
		if(!$userxxx){
			//$this->outputData(1,array(),'链接错误！');
			$this->display('newsafe/register.php');
		}else{
			include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
			$userxxx=str_replace(array('youle','woshi',''), array('+','/','='), $userxxx);
			$userxxx=base64_decode($userxxx);
			$LArry=Xxtea::decrypt($userxxx, $this->urlPasswordKey);
			$LArry=explode(",",$LArry);
			$lid=$LArry[0];
			$uid=$LArry[1];

			if(!$this->getRow("select uid from {$this->prename}members where uid=?",$uid)){
				//$this->outputData(1,array(),'链接失效！');
				$this->display('newsafe/register.php');
			}else{
				$this->display('newsafe/register.php',0,$uid,$lid);
			}
		}
	}
	public final function registered(){
		$urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
		$urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
		$urlcheck=substr($urlshang,7,strlen($urldan));
		if($urlcheck<>$urldan)  $this->outputData(1,array(),'数据包被篡改，请重新操作');

		if(!$_POST)  $this->outputData(1,array(),'提交数据出错，请重新操作');

		//表单过滤
		$lid=intval($_POST['lid']);
		$parentId=intval($_POST['parentId']);
		$user=wjStrFilter($_POST['username']);
		$qq=wjStrFilter($_POST['qq']);
		$vcode=wjStrFilter($_POST['vcode']);
		$password=md5($_POST['password']);

		if($vcode!=$_SESSION[$this->vcodeSessionName]) $this->outputData(1,array(),'验证码不正确。');

		//清空验证码session
	    $_SESSION[$this->vcodeSessionName]="";

		if(!ctype_alnum($user)) $this->outputData(1,array(),'用户名包含非法字符');
		if(!ctype_digit($qq)) $this->outputData(1,array(),'QQ包含非法字符');
		
		$sql="select * from {$this->prename}links where lid=?";
		$linkData=$this->getRow($sql, $lid);
		if(!$_POST['lid']) $para['lid']=$lid;
		if(!$linkData) $this->outputData(1,array(),'不存在此注册链接。');
		if(!$parentId) $this->outputData(1,array(),'链接错误');
		$para=array(
			'username'=>$user,
			'type'=>$linkData['type'],
			'password'=>$password,
			'parentId'=>$parentId,
			'parents'=>$this->getValue("select parents from {$this->prename}members where uid=?",$parentId),
			'fanDian'=>$linkData['fanDian'],
			'fanDianBdw'=>$linkData['fanDianBdw'],
			'qq'=>$qq,
			'regIP'=>$this->ip(true),
			'regTime'=>$this->time
			);
        //$regtime=$this->getrow("select * from {$this->prename}members where regIP=? order by regTime DESC limit 1",ip2long($this->ip(true)));
		//$time=strtotime($this->time)-$this->iff($regtime['regTime'],$regtime['regTime'],strtotime($this->time)-400);
		//if($time<300) $this->outputData(1,array(),'同一IP 5 分钟内只能注册一次');

		if(!$para['nickname']) $para['nickname']='未设昵称';
		if(!$para['name']) $para['name']=$para['username'];
		$this->beginTransaction();
		try{
			$sql="select username from {$this->prename}members where username=?";
			if($this->getValue($sql, $para['username'])) $this->outputData(1,array(),'用户"'.$para['username'].'"已经存在');
			if($this->insertRow($this->prename .'members', $para)){
				$id=$this->lastInsertId();
				$sql="update {$this->prename}members set parents=concat(parents, ',', $id) where `uid`=$id";
				$this->update($sql);
				$this->commit();
				$this->outputData(0,array(),'注册成功');
			}else{
				$this->outputData(1,array(),'注册失败');
			}	
		}catch(Exception $e){
			$this->rollBack();
			throw $e;
		}
	}
	public final function checkLogin() {
	    if($user=unserialize($_SESSION[$this->memberSessionName])) {
	        $this->outputData(0,0);
	    }else{
	        $this->outputData(0,1);
	    }
	}
	public function outputData($code=0,$data=array(),$message='操作成功') {
	    $output = array('code'=>$code,'data'=>$data,'msg'=>$message);
	    echo json_encode($output);
	    exit;
	}
}
