<?php 

	$sql="select * from {$this->prename}links where lid=?";
	$linkData=$this->getRow($sql, $this->id);
	
	if($linkData['uid']){
		$parentData=$this->getRow("select fanDian, fanDianBdw, username from {$this->prename}members where uid=?", $linkData['uid']);
	}else{
		$this->getSystemSettings();
		$parentData['fanDian']=$this->settings['fanDianMax'];
		$parentData['fanDianBdw']=$this->settings['fanDianBdwMax'];
	}


	include_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/Xxtea.class';
	$key=Xxtea::encrypt($this->id.",".$this->user['uid'], $this->urlPasswordKey);
	$key=base64_encode($key);
	$key=str_replace(array('+','/','='), array('youle','woshi',''), $key);
?><div>
	<ul class="myi_list dla_list">
		<li class="clearfix">
            <div class="fl myw f24" style="width:40%">上级会员：</div>
            <input  class="col67 fl f22" style="width:55%" readonly value="<?=$parentData['username']?>">
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%">返点：</div>
            <input class="col67 fl i5" style="width:20%"  type="text" name="fanDian" value="<?=$linkData['fanDian']?>" max="<?=$parentData['fanDian']?>" min="0" fanDianDiff=<?=$this->settings['fanDianDiff']?> >
            <span class="fl">0—<?=$parentData['fanDian']?>%</span>
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%">不定位返点：</div>
            <input class="col67 fl i6" style="width:20%" name="fanDianBdw" value="<?=$linkData['fanDianBdw']?>" max="<?=$parentData['fanDianBdw']?>" min="0">
            <span class="fl">0—<?=$parentData['fanDianBdw']?>%</span>
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%">注册推广链接：</div>
            <input  class="col67 fl f22" style="width:55%" readonly id="adv-url" readonly="readonly" value="http://<?=$_SERVER['HTTP_X_REAL_HOST']?>/index.php/user/r/<?=$key?>" >
        </li>
        <li class="clearfix">
            <div class="fl myw f24" style="width:40%"> &nbsp</div>
            <input  class="col67 fl f30" style="width:59%;border: 1px solid #eee; text-align: center; font-weight: 700" readonly id="clip_button" onClick="copyNum()" value="点击复制">
        </li>
    </ul>
	

</div>
