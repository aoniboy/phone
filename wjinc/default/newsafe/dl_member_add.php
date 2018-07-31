<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员添加</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>会员管理</div>
    <div class="myi_title">新增成员</div>
    <form class="myi_form">
        <ul class="myi_list dla_list">
            <li class="clearfix rel">
                <div class="fl myw">账号类型：</div>
                <div class="fl ol67">
                    <label><input type="radio" name="type" value="1" title="代理" checked="checked" style="-webkit-appearance: radio "> 代理</label>
                    <label><input name="type" type="radio" value="0" title="会员" style="-webkit-appearance:radio; margin-left: .2rem"> 会员</label>
                </div>
            </li>
            <li class="clearfix">
                <div class="fl myw ">用户名：</div>
                <input  class="col67 fl i1" type="text"  placeholder="4-16位的字母或数字组成" name="username" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw ">密码：</div>
                <input class="col67 fl i2" type="password" name="password" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw ">确认密码：</div>
                <input class="col67 fl i3" type="password" name="" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw">联系微信：</div>
                <input class="col67 fl i7" type="text" name="qq" value="">
            </li>
            <li class="clearfix rel">
                <div class="fl myw">提成类型：</div>
                <div class="fl ol67">
                    <label><input type="radio" name="tctype" value="1" title="分成" checked="checked" style="-webkit-appearance: radio " checked="checked" > 分成</label>
                    <label><input name="tctype" type="radio" value="0" title="返点" style="-webkit-appearance:radio; margin-left: .2rem"> 返点</label>
                </div>
            </li>
            <li class="clearfix">
                <div class="fl myw ">分成：</div>
                <input class="col67 fl i4" name="fanDian" max="<?=$this->user['tcpoint']?>" value="0"  tcpointDiff=<?=$this->settings['tcpointDiff']?> onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <span class="">0-<?=$this->iff($this->user['tcpoint']-$this->settings['tcpointDiff']<=0,0,$this->user['tcpoint']-$this->settings['tcpointDiff'])?>%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw ">返点：</div>
                <input class="col67 fl i5" name="fanDian" max="<?=$this->user['fanDian']?>" value="0"  fanDianDiff=<?=$this->settings['fanDianDiff']?> onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <span class="">0-<?=$this->iff($this->user['fanDian']-$this->settings['fanDianDiff']<=0,0,$this->user['fanDian']-$this->settings['fanDianDiff'])?>%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw ">不定位返点：</div>
                <input class="col67 fl i6" name="fanDianBdw" max="<?=$this->user['fanDianBdw']?>" value=""  ōnkeyup="if(isNaN(value))execCommand(''undo'')" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <span class="fl">0-<?=$this->iff($this->user['fanDianBdw']-$this->settings['fanDianDiff']<=0,0,$this->user['fanDianBdw']-$this->settings['fanDianDiff'])?>%</span>
            </li>
        </ul>
        <div class="myi_btns flex">
            <div class="tc fx myi_btns1" id="dl_add_member">添加</div>
            <input class="tc fx myi_btns2" type="reset" value="重置" />
        </div>
    </form>
    <div class="hint_pop hide">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">错误提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
    <div class=" hide hint_pop1">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">系统提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
</div>

<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js?<?=$this->sversion?>"></script>
</body>
</html>
