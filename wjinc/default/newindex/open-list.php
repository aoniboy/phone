<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>开奖</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body>
<div class="wrap_box wrap_top">
    <div class="title_top tc">开奖</div>
    <ul class="lotter_cont clearfix">
    <?php

	foreach ($this->gameinfo as $key=>$val) {
	    $sql = "select sd.type, sd.time, sd.number, sd.data,st.title from ssc_data_{$this->user['suffix']} sd,ssc_type st where sd.type = {$val} and st.id={$val}  order by sd.id desc   ";
	    $result  = $this->getRow($sql);
	    !empty($result)?$tmp[] = $result:'';
	}
	
?>
<?php if($tmp) foreach($tmp as $key=>$var){ 
        $tmp[$key]['tdata'] = explode(",", $var['data']);
        $tnumber = '';
        foreach($tmp[$key]['tdata'] as $k=>$v) {
            $tnumber .= "<span>$v</span>";
        }
    ?>
        <li>
            <a class="clearfix rel" href="/index.php/index/openListDetail/<?=$var['type']?>">
                <img class="fl" src="/wjinc/default/images/index_logo<?=$var['type']?>.jpg">
                <div class="fl lot_left">
                    <p class=""><?=$var['title']?><span class="f20 col9">第<?=$var['number']?>期 <?=date("H:i",$var['time'])?>开奖</span></p>
                    <div class="lot_num"><?=$tnumber?></div>
                </div>
                
                <i class="iconfont icon-xiangyoujiantou lot_iconr"></i>
            </a>
        </li>
        <?php } ?>
    </ul>
	<?php $this->display('newinc_footer.php'); ?>
	<div class="hint_pop hide">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">错误提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
</div>
<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>

</body>
</html>

 
