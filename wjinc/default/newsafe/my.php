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
<body>

<div class="wrap_box wrap_top">
    <div class="my_top rel">
        <a href="/index.php/safe/info"><img class="my_tx" src="/wjinc/default/images/tx.jpg">
        <div class="tc fff f32 my_name"><?=$this->user['username']?></div>
        </a>
        <div class="my_toppos">
            <span class="iconfont icon-kefu kf f30 fff"></span>
            <span class="iconfont icon-shezhi logout f34 fff"></span>
        </div>
        <div class="flex fff my_toptitle">
            <div class="fx tc">
                <div class="f34 yyue"><?=$this->user['coin']?></div>
                <div>可用余额</div>
            </div>
            <?php 
            $stime = strtotime(date("Y-m-d 00:00:00"));
            $etime = strtotime(date("Y-m-d 23:59:59"));
            $sql = "select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 and c.actionTime between $stime and $etime) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid` and r.state in(1,2,9) and r.actionTime between $stime and $etime) rechargeAmount, (select sum(l.coin) from ssc_coin_log l where l.`uid`=u.`uid` and l.liqType in(50,51,52,53) and l.actionTime between $stime and $etime) brokerageAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 and actionTime between $stime and $etime where 1 and u.uid=".$this->user['uid'];
            $info = $this->getRow($sql);
            $yingkui = sprintf("%.2f",$info['zjAmount']-$info['betAmount']);
            ?>
            <div class="fx tc">
                <div class="f34 yyingkui"><?=$yingkui?></div>
                <div>今日盈亏 <i class="iconfont icon-qiehuan"></i></div>
            </div>
        </div>
    </div>
    <div class="flex tc my_titl">
        <a href="/index.php/cash/recharge" class="fx f32"><i class="iconfont  icon-qiapian my_titl_icon1 f34"></i> 充值</a>
        <a href="/index.php/cash/toCash" class="fx f32"><i class="iconfont icon-qian my_titl_icon2 f34"></i> 提现</a>
    </div>
    <div class="my_line"></div>
    <ul class="my_list">

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
            <a href="/index.php/report/coin" class="clearfix">
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
    <?php if($this->user['type']){ ?>
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
            <a href="/index.php/team/coin" class="clearfix">
                <i class="iconfont icon-tuandui my_col4"></i> <span>团队帐变<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
        <li>
            <a href="/index.php/team/linkList" class="clearfix">
                <i class="iconfont icon-tuandui my_col6"></i> <span>邀请注册<span> <i class="iconfont icon-xiangyoujiantou fr my_coli"></i>
            </a>
        </li>
    </ul> 
     <?php } ?>   
             <div class="hint_pop hide">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">错误提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
     <div class="myi_btns flex myt_btns ">
        <div class="tc fx myi_btns1 logout " > 退出</div>
        
    </div>
    	<?php $this->display('newinc_footer.php'); ?>
</div>
<input id="ymy" type="hidden" value="1">
<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>

</body>
</html>
