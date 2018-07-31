<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员中心</title>
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
            <li class="clearfix rel">
                <div class="fl myw">银行类型：</div>
                <select class="fl col67 i0">
                    <option>中国邮政银行</option>
                    <option>中国建设银行</option>
                </select>
            </li>
            <li class="clearfix">
                <div class="fl myw">用户名：</div>
                <input  class="col67 fl i1" type="text" placeholder="4-16位的字母或数字组成" name="username" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw">密码：</div>
                <input class="col67 fl i2" type="text col67" name="password" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw">确认密码：</div>
                <input class="col67 fl i3" type="text" name="" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw">联系微信：</div>
                <input class="col67 fl i4" type="password" name="qq" value="">
            </li>
            <li class="clearfix">
                <div class="fl myw">返点：</div>
                <input class="col67 fl i4" name="fanDian" max="0.0" value="0" fandiandiff="0.1" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <span class="">0-0%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw">不定位返点：</div>
                <input class="col67 fl i4" name="fanDianBdw" max="0.0" value="" ōnkeyup="if(isNaN(value))execCommand(''undo'')" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')">
                <span class="fl">0-0%</span>
            </li>
        </ul>
        <div class="myi_btns flex">
            <div class="tc fx myi_btns1" id="dl_add">添加</div>
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
</div>

<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
</body>
</html>
