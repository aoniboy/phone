<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>开奖详情</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body>
<div class="wrap_box wrap_top">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a><?=$this->typename?></div>
    <ul class="lotter_dcont clearfix">
    	<?php  if($this->result) foreach($this->result as $key=>$var){ 
        $data = explode(",", $var['data']);
        $tnumber = '';
        foreach($data as $k=>$v) {
            $tnumber .= "<span>$v</span>";
        }
    ?>
        <li>
            <div class="clearfix"><p class="fl">第<?=$var['number']?>期</p><span class="fr f24 col9"><?=date("Y-m-d H:i",$var['time'])?>开奖</span></div>
            <div class="lot_num lot_left f34"><?=$tnumber?></div>
        </li>
        <?php } ?>
        
    </ul>
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
<script>
var type = '<?=$this->type?>'
    
    var page = 10;
    var is_false =false;
    $(window).scroll(function () {
        var scrollTop = $(this).scrollTop()
        var scrollHeight = $(document).height()
        var windowHeight = $(this).height()
        if(windowHeight + scrollTop >= scrollHeight-80){
            $.post('/index.php/index/getOpenHistoryData/'+type+'/'+page, function(res){
                var list = res.data.result;
                
                if(list.length>0){
                    page += 10;
         
                    var html = '';
                    for(var i=0;i<list.length;i++){
                        html+='    <li>'
                        html+='        <div class="clearfix"><p class="fl">第'+list[i].number+'期</p><span class="fr f24 col9">'+list[i].time+'开奖</spa></div>'
                        html+='        <div class="lot_num lot_left f34">'+list[i].tnumber+'</div>'
                        html+='    </li>'
                    }
                }
                $(".lotter_dcont").append(html);
            },'json' );
        }

    })
</script>
</body>
</html>

 