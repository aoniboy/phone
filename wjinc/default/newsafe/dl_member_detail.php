<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员管理</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<?php 
    $sql="select * from {$this->prename}members where uid=?";
    $userData=$this->getRow($sql, $args[0]);
    
    if($userData['parentId']){
        $parentData=$this->getRow("select fanDian, fanDianBdw from {$this->prename}members where uid=?", $userData['parentId']);
    }else{
        $this->getSystemSettings();
        $parentData['fanDian']=$this->settings['fanDianMax'];
        $parentData['fanDianBdw']=$this->settings['fanDianBdwMax'];
    }
?>
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>会员管理</div>
    <div class="myi_title">会员详情</div>
    <form class="myi_form">
        <ul class="myi_list dla_list">

            <li class="clearfix">
                <div class="fl myw">上级关系：</div>
                <input  class="col67 fl" type="text" readonly value="<?=$this->getValue("select username from {$this->prename}members where uid={$userData['parentId']} ")?> > <?=$userData['username']?>">
            </li>
            <li class="clearfix">
                <div class="fl myw">用户名：</div>
                <input class="col67 fl i2" type="text col67" readonly value="<?=$userData['username']?>">
            </li>
            <li class="clearfix">
                <div class="fl myw">返点：</div>
                <input class="col67 fl i4" name="fanDian" readonly value="<?=$userData['fanDian']?>" max="<?=$parentData['fanDian']?>" max="<?=$parentData['fanDian']?>" min="0" fanDianDiff=<?=$this->settings['fanDianDiff']?> val="<?=$userData['fanDian']?>" >
                <span class="fl">0—<?=$this->iff($parentData['fanDian']-$this->settings['fanDianDiff']<=0,0,$parentData['fanDian']-$this->settings['fanDianDiff'])?>%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw">不定位返点：</div>
                <input class="col67 fl i4" name="fanDianBdw" readonly value="<?=$userData['fanDianBdw']?>" max="<?=$parentData['fanDianBdw']?>" min="0" val="<?=$userData['fanDianBdw']?>">
                <span class="fl">0—<?=$this->iff($parentData['fanDianBdw']-$this->settings['fanDianDiff']<=0,0,$parentData['fanDianBdw']-$this->settings['fanDianDiff'])?>%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw">注册时间：</div>
                <input class="col67 fl i2" type="text col67" readonly value="<?=date("Y-m-d",$userData['regTime'])?>">
            </li>
        </ul>
<!--         <div class="myi_btns flex">
            <div class="tc fx myi_btns1" id="dl_add">添加</div>
            <input class="tc fx myi_btns2" type="reset" value="重置" />
        </div> -->
    </form>
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
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
</body>
</html>
