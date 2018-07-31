<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>游戏记录</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/js/calendar/LCalendar.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/calendar/LCalendar.js<?=$this->sversion?>"></script>
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>游戏记录</div>

    <div class="clearfix myp_top dl_gametop">
        <form class="dl_form">
            <div class="clearfix">
                <div class="rel fl myp_top_l ">
                    <select class="myp_sel1" name="type">
                        
                        <option value="0" <?=$this->iff($_REQUEST['type']=='', 'selected="selected"')?>>全部彩种</option>
                        <?php
                            if($this->types) foreach($this->types as $var){ 
                                if($var['enable']){
                        ?>
                        <option value="<?=$var['id']?>" <?=$this->iff($_REQUEST['type']==$var['id'], 'selected="selected"')?>><?=$this->iff($var['shortName'], $var['shortName'], $var['title'])?></option>
            
                        <?php }} ?>
                   
                    </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="rel fl myp_top_l ">
                    <select class="myp_sel2" name="state">
                        <option value="0">所有状态</option>
                        <option value="1">已派奖</option>
                        <option value="2">未中奖</option>
                        <option value="3">未开奖</option>
                        <option value="4">追号</option>
                        <option value="5">撤单</option>
                    </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="rel fl myp_top_l ">
                    <select class="myp_sel1" name="mode">
                        <option value="">全部模式</option>
                        <option value="2.00">元</option>
                        <option value="0.20">角</option>
                        <option value="0.02">分</option>
                    </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="rel fl myp_top_l ">
                    <select class="myp_sel2" name="utype">
                        <option value="0">所有人</option>
                        <option value="1">我自己</option>
                        <option value="2">直属下线</option>
                        <option value="3">所有下线</option>
                    </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
            </div>
            <div class="clearfix dlg_input">
            	<input class="fl dlg_idani" type="text" name="username" placeholder="输入用户名">
                <input class="fr dlg_idani" type="text" name="betId" placeholder="输入单号">
            </div>
            <div class="clearfix myp_top dl_gametop_1">
                <div class="rel fl myp_top_l ">
                    <input class="my_calendar" type="text" name="fromTime" id="start_date" placeholder="选择开始日期" readonly="readonly" value="<?=date("Y-m-d")?>">
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="fl myp_zhi">至</div>
                <div class="rel fl myp_top_l ">
                    <input class="my_calendar" type="text" name="toTime" id="end_date" placeholder="选择结束日期" readonly="readonly" value="<?=date("Y-m-d",strtotime("+1 days"))?>">
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="myp_btn fr">查询</div>
            </div>
        </form>
    </div>
    <div class="detail_pop hide">
        <div class="gameo_mask"></div>
        <div class="detail_box">
            <div class="detail_top f33">投注信息 </div>
            <div class="detail_table tc" style="" scrolltop="0" scrollleft="0">
                
            </div>
            <div class="">
                <div class="detail_btn tc">
                    <button type="button" style="border:none; border-radius:5px;padding:.1rem .5rem" class="detail_close f26">关闭</button>
                    
                </div>
            </div>
        </div>
        </div>
        <div class="table_scroll">
            <div class="myp_table" style="width:1000px">
                
            </div>
        </div>
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

<script type="text/javascript">

    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#start_date', 
        'type': 'date', 
        'minDate': (new Date().getFullYear()-20) + '-' + 1 + '-' + 1, 
        'maxDate': (new Date().getFullYear()) + '-' + 12 + '-' + 31 
    });
    var calendar = new LCalendar();
    calendar.init({
        'trigger': '#end_date',
        'type': 'date', 
        'minDate': (new Date().getFullYear()-20) + '-' + 1 + '-' + 1, 
        'maxDate': (new Date().getFullYear()) + '-' + 12 + '-' + 31
    });

    var page = 1;
    $(window).scroll(function () {
        var scrollTop = $(this).scrollTop()
        var scrollHeight = $(document).height()
        var windowHeight = $(this).height()
        if(windowHeight + scrollTop >= scrollHeight-80){
        	page++
            upload();
        }

    })
    upload(false);
    $(".myp_btn").on('click',function(){
        page = 1;
        upload(true);
    })
    function upload(flag){
        $.post('/index.php/team/searchGameRecord/?page='+page+"&"+$(".dl_form").serialize(), function(res){
        	if(res.data){
          		!flag?(page == 1 ?$(".myp_table").append(res.data):$(".table_b_tr").append(res.data)):page == 1 ?$(".myp_table").html(res.data):$(".table_b_tr").html(res.data);
            }
        },'json' );
    }
</script>
</body>
</html>
