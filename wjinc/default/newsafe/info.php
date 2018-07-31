<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员中心</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css">
    <script src="/wjinc/default/js/jquery.min.js"></script>
</head>
<body>

<div class="wrap_box wrap_top">
    <div class="my_top rel">
        <img class="my_tx" src="/wjinc/default/images/tx.jpg">
        <div class="tc fff f32 my_name"><?=$this->user['username']?></div>
        <div class="my_toppos">
            <span class="iconfont icon-kefu kf f30 fff"></span>
            <span class="iconfont icon-shezhi f34 fff"></span>
        </div>
        <div class="flex fff my_toptitle">
            <div class="fx tc">
                <div class="f34"><?=$this->user['coin']?></div>
                <div>可用余额</div>
            </div>
            <div class="fx tc">
                <div class="f34">0.00</div>
                <div>今日盈亏 <i class="iconfont icon-qiehuan"></i></div>
            </div>
        </div>
    </div>
    <div class="flex tc my_titl">
        <a href="javascript:;" class="fx f32 kf"><i class="iconfont  icon-qiapian my_titl_icon1 f34"></i> 充值</a>
        <a href="/index.php/cash/toCash" class="fx f32"><i class="iconfont icon-qian my_titl_icon2 f34"></i> 提现</a>
    </div>
    <div class="my_line"></div>
    <ul class="my_list">
<!--         <li>
            <a href="/index.php/record/search" class="clearfix">
                <i class="iconfont icon-jilu my_col1"></i> <span>个人资料<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li> -->
        <li>
            <a href="/index.php/safe/passwd" class="clearfix">
                <i class="iconfont icon-jilu my_col1"></i> <span>密码管理<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/record/search" class="clearfix">
                <i class="iconfont icon-jilu my_col1"></i> <span>游戏记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/report/count" class="clearfix">
                <i class="iconfont icon-jilu my_col1"></i> <span>盈亏报表<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/cash/rechargeLog" class="clearfix">
                <i class="iconfont icon-jilu my_col1"></i> <span>帐变记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/cash/rechargeLog" class="clearfix">
                <i class="iconfont icon-yinxingqia my_col2"></i> <span>充值记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/cash/toCashLog" class="clearfix">
                <i class="iconfont icon-qian my_col3"></i> <span>提现记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
    </ul>
    <div class="my_line"></div>
    <ul class="my_list1 my_list">
        <li>
            <a href="/index.php/team/memberList" class="clearfix">
                <i class="iconfont icon-huiyuanguanli my_col4"></i> <span>会员管理<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/gameRecord" class="clearfix">
                <i class="iconfont icon-huiyuanguanli my_col4"></i> <span>游戏记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/report" class="clearfix">
                <i class="iconfont icon-huiyuanguanli my_col4"></i> <span>盈亏报表<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/coinall" class="clearfix">
                <i class="iconfont icon-045zhuanqulirun my_col4"></i> <span>团队统计<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/coin" class="clearfix">
                <i class="iconfont icon-tuandui my_col4"></i> <span>帐变记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>

        <li>
            <a href="/index.php/team/cashRecord" class="clearfix">
                <i class="iconfont icon-yaoqinghaoyou my_col5"></i> <span>提现记录<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/linkList" class="clearfix">
                <i class="iconfont icon-tuandui my_col6"></i> <span>团队帐变<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
    </ul>    
    
</div>

<script src="/wjinc/default/js/common.js"></script>

</body>
</html>
