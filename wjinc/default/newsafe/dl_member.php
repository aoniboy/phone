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
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>会员管理</div>
    <div class="clearfix myp_top dlm_top">
        <form class="dl_form">
            <div class="clearfix">
                <div class="rel fl myp_top_l ">
                    <select name="mtype">
                <option value="" selected="">会员类型</option>
                <option value="0">会员</option>
                <option value="1">代理</option>
            </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <div class="rel fl myp_top_l ">
                    <select name="type">
            <option value="0">所有人</option>
            <option value="1">我自己</option>
            <option value="2" selected>直属下线</option>
            <option value="3">所有下线</option>
        </select>
                    <i class="iconfont icon-xialajiantou myp_topicon"></i>
                </div>
                <input class="dlm_input fr myp_sel3" type="text" value="" name="username" placeholder="用户名">    
            </div>
        </form>
        <div class="clearfix flex dlm_btns tc fff">
            <a class="dlm_link dlm_btn fx fff" href="/index.php/team/addMember">添加会员</a>
            <div class="dlm_btn fx dlm_btn_js">查询</div>
            
        </div>
        <!-- <div class="myp_btn fr">查询</div> -->
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
    $(".dlm_btn_js").on('click',function(){
        page = 1;
        upload(true);
    })
    function upload(flag){
        $.post('/index.php/team/searchMember/?page='+page+"&"+$(".dl_form").serialize(), function(res){
        	if(res.data){
          		!flag?(page == 1 ?$(".myp_table").append(res.data):$(".table_b_tr").append(res.data)):page == 1 ?$(".myp_table").html(res.data):$(".table_b_tr").html(res.data);
            }
        },'json' );
    }
    //查看详情
    $(document).on('click', '.caozuo', function(){
        var href = $(this).attr('data-href');
        $.post(href,function(res){
        	$(".myp_table").html(res.data);
        },'json' );
        return false;
    })
</script>
</body>
</html>
