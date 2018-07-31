<?php
class Xyylcp extends WebBase{
	public $title='自主研发五分彩';
	/**
	 * 获取信息页面
	 */
	public final function xml(){
		$this->display('xyyl/5fc.php');
	}
	public final function xml2(){
		$this->display('xyyl/2fc.php');
	}
	public final function xml1(){
		$this->display('xyyl/ffc.php');
	}
	public final function xml3(){
	    $this->display('xyyl/3fc.php');
	}
}
