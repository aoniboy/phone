<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员中心－个人资料</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>个人资料</div>
    <div class="myi_title">个人基本信息</div>
    <ul class="myi_list">
        <li class="clearfix">
            <div class="fl myw">登录账号：</div>
            <p class="fl col67"><?=$this->user['username']?></p>
        </li>
        <li class="clearfix">
            <div class="fl myw">可用资金：</div>
            <p class="fl col67"><?=$this->user['coin']?>元</p>
        </li>
        <li class="clearfix">
            <div class="fl myw">VIP等级：</div>
            <p class="fl col67">VIP<?=$this->user['grade']?></p>
        </li>
        <li class="clearfix">
            <div class="fl myw">积分：</div>
            <p class="fl col67"><?=$this->user['score']?></p>
        </li>
        <li class="clearfix">
            <div class="fl myw">会员类型：</div>
            <p class="fl col67"><?=$this->iff($this->user['type'], '代理', '会员')?></p>
        </li>
    </ul>
    <div class="myi_title">个人银行信息</div>
    <?php if($this->coinPassword){ ?>
    
    <form class="myi_form">
        <ul class="myi_list">
            <li class="clearfix rel">
                <div class="fl myw">银行类型：</div>
                
                <?php
            $myBank=$this->getRow("select * from {$this->prename}member_bank where uid=?", $this->user['uid']);
            $banks=$this->getRows("select * from {$this->prename}bank_list where isDelete=0 and id!=12 order by sort");
            
            $flag=($myBank['editEnable']!=1)&&($myBank);
        ?>
                <select class="fl col67 i0" name="bankId" <?=$this->iff($flag, 'disabled')?>>
                     <?php foreach($banks as $bank){ ?>
                        <option value="<?=$bank['id']?>" <?=$this->iff($myBank['bankId']==$bank['id'], 'selected')?>>
                        <?=$bank['name']?>
                        </option>
                    <?php } ?>
                </select>
            </li>
            <li class="clearfix">
                <div class="fl myw">姓名：</div>
                <input  class="col67 fl i1" type="text" name="username" value="<?=$this->iff($myBank['username'],mb_substr($myBank['username'],0,1,'utf-8').'**')?>" <?=$this->iff($myBank, 'readonly')?>>
            </li>
            <li class="clearfix">
                <div class="fl myw">银行账号：</div>
                <input class="col67 fl i2" type="text col67" name="account" value="<?=preg_replace('/^.*(\w{4})$/', '***\1', $myBank['account'])?>" <?=$this->iff($flag, 'readonly')?>>
            </li>
            <li class="clearfix">
                <div class="fl myw">开户行：</div>
                <input class="col67 fl i3" type="text" name="countname" value="<?=preg_replace('/^(\w{4}).*(\w{4})$/','\1***\2',$myBank['countname'])?>"  <?=$this->iff($flag, 'readonly')?>>
            </li>
            <li class="clearfix">
                <div class="fl myw">资金密码：</div>
                <input class="col67 fl i4" type="password" name="coinPassword" <?=$this->iff($flag, 'readonly')?> >
            </li>
        </ul>
    </form>
    <?php if(!$myBank['countname'] || !$flag){?>
    <div class="myi_btns flex">
        <div class="tc fx myi_btns1" id="my_info_edit">设置银行</div>
        <div class="tc fx myi_btns2">重置</div>
    </div>
    <?php }?>
    <?php }else{?>
    <ul class="myi_list">
    	<li class="clearfix" style="height:1.2rem;" >
        	<div class="fl myw">温馨提示：</div>
        	<div class="font_line_2">设置银行信息要用资金密码，您尚未设置资金密码！<a href="/index.php/safe/passwd" style="text-decoration:none; color:#f00">设置资金密码&gt;&gt;</a></div>
    	</li>
	</ul>
    <?php }?>
    <div class="hint_pop hide">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">错误提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
    <div class="hint_pop hide hint_pop1">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">系统提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
</div>

<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
</body>
</html>
