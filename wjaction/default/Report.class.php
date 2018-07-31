<?php
class Report extends WebLoginBase{
	public $type;
	public $pageSize=20;
	
	// �ʱ��б�
	public final function coin($type=0){
		$this->type=intval($type);
		$this->action='coinlog';
		$this->display('newsafe/my_zhangbian.php');
	}
	
	public final function coinlog($type=0){
		$this->type=intval($type);
		$this->page = empty($_GET['page'])?1:$_GET['page'];
		$data = $this->fetch('report/coin-log.php');
		$this->outputData(0,$data);
	}

	// �ܽ����ѯ
	public final function count(){
		$this->action='countSearch';
		$this->display('newsafe/my_yingkui.php');
	}
	
	public final function countSearch(){
		$data = $this->fetch('report/count-list.php');
		$this->outputData(0,$data);
	}
}
