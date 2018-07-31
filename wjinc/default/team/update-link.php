<?php 
	$sql="select * from {$this->prename}links where lid=?";
	$linkData=$this->getRow($sql, $this->id);
	
	if($linkData['uid']){
		$parentData=$this->getRow("select fanDian, fanDianBdw from {$this->prename}members where uid=?", $linkData['uid']);
	}else{
		$this->getSystemSettings();
		$parentData['fanDian']=$this->settings['fanDianMax'];
		$parentData['fanDianBdw']=$this->settings['fanDianBdwMax'];
	}

?>
<div>
<form class="edit_form">
	<input type="hidden" name="lid" value="<?=$this->id?>"/>
    <ul class="myi_list dla_list dtg_list">
        <li class="clearfix">
            <div class="fl myw f24 " style="width:40%">返点：</div>
            <input class="col67 fl t1" style="width:20%"  type="text" name="fanDian" value="<?=$linkData['fanDian']?>" max="<?=$parentData['fanDian']?>" min="0" fanDianDiff=<?=$this->settings['fanDianDiff']?> >
            <span class="fl">0—<?=$parentData['fanDian']?>%</span>
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%">不定位返点：</div>
            <input class="col67 fl t2" style="width:20%" name="fanDianBdw" value="<?=$linkData['fanDianBdw']?>" max="<?=$parentData['fanDianBdw']?>" min="0">
            <span class="fl">0—<?=$parentData['fanDianBdw']?>%</span>
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%">加入时间：</div>
            <input  class="col67 fl f22" style="width:55%" readonly value="<?=date("Y-m-d H:i:s",$linkData['regTime'])?>">
        </li>
    </ul>
    <div id="tg_edit" style="width:2rem; padding:.1rem;border-radius: .1rem; color:#fff;text-align: center;margin:.2rem auto; background: #fc7166;">修改</div>
</form>
</div>