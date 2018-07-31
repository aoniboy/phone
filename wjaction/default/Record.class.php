<?php
class Record extends WebLoginBase{
	public $pageSize=20;
	public final function search(){
		
		$this->getTypes();
		$this->getPlayeds();
		$this->action='searchGameRecord';
		$this->display('newsafe/my_game.php');
	}

	public final function searchGameRecord(){
		$this->getTypes();
		$this->getPlayeds();
		$this->page = empty($_GET['page'])?1:$_GET['page'];
		$data = $this->fetch('record/search-list.php');
		$this->outputData(0,$data);
	}
	
	public final function betInfo($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('record/bet-info.php', 0 , intval($id));
	}
	public final function bet(){
		$this->display('record/bet.php');
	}
}
