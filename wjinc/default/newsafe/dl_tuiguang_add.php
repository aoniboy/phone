<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>添加推广链接</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>添加推广链接</div>
    <div class="myi_title">新增注册链接</div>
    <form class="add_form">
        <input name="uid" type="hidden" id="uid" value="<?=$this->user['uid']?>" />
        <ul class="myi_list dla_list">
            <li class="clearfix rel">
                <div class="fl myw">账号类型：</div>
                <div class="fl ol67">
                    <label><input type="radio" name="type" value="1" title="代理" checked="checked" style="-webkit-appearance: radio "> 代理</label>
                    <label><input name="type" type="radio" value="0" title="会员" style="-webkit-appearance:radio; margin-left: .2rem" checked="checked"> 会员</label>
                </div>
            </li>
            <li class="clearfix">
                <div class="fl myw">返点：</div>
                <input class="col67 fl t1"  name="fanDian" max="<?=$this->user['fanDian']?>" value=""  fanDianDiff=<?=$this->settings['fanDianDiff']?> >
                <span class="fl">0-<?=$this->user['fanDian']?>%</span>
            </li>
            <li class="clearfix">
                <div class="fl myw">不定位返点：</div>
                <input class="col67 fl t2"  name="fanDianBdw" max="<?=$this->user['fanDianBdw']?>" value="">
                <span class="fl">0-<?=$this->user['fanDianBdw']?>%</span>
            </li>
        </ul>
        <div class="myi_btns flex">
            <div class="tc fx myi_btns1" id="dl_tgadd">添加链接</div>
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
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
</body>
</html>
