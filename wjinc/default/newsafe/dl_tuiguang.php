<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>推广链接</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>推广链接</div>
    <div class="clearfix myp_top dlm_top">
            <div class="myp_btn tc dl_dglink"><a class="fff" href="/index.php/team/addlink">添加链接</a></div> 
    </div>
    <div class="table_scroll">
    <div class="myp_table" style="width:550px;">
        <?php
	$sql="select * from {$this->prename}links where uid={$this->user['uid']}";
	
	if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
	$data=$this->getPage($sql, $this->page, $this->pageSize);
	?>
	<table width="100%" class='table_b'>
	<thead>
		<tr class="table_b_th">
			<td width="70">编号</td>
            <td width="70">类型</td>
			<td width="70">返点</td>
            <td width="100">不定位返点</td>
			<td>操作</td>
		</tr>
	</thead>
	<tbody class="table_b_tr">
	<?php if($data['data']) foreach($data['data'] as $var){ ?>
		<tr>
			<td><?=$var['lid']?></td>
			<td><?php if($var['type']){echo'代理';}else{echo '会员';}?></td>
			<td><?=$var['fanDian']?>%</td>
            <td><?=$var['fanDianBdw']?>%</td>
           
			<td><a href="javascript:void(0)" class="caozuo" data-href="/index.php/team/linkUpdate/<?=$var['lid']?>" style="color:#333;" target="modal"  width="350" title="修改注册链接" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">修改</a> | <a href="javascript:void(0)" class="caozuo" data-href="/index.php/team/getLinkCode/<?=$var['lid']?>" button="取消:defaultCloseModal" modal="true" title="获取链接" width="350" target="modal"  style="color:#333;">获取链接</a> | <a  href="javascript:void(0)" class="td_delete" data-href="/index.php/team/linkDeleteed/<?=$var['lid']?>" button="确定删除:dataAddCode" modal="true" title="删除注册链接" width="350" target="modal"  style="color:#333;">删除</a> </td>
           
		</tr>
	<?php } ?>
	</tbody>
    </div>
        <div class="detail_pop hide">
        <div class="gameo_mask"></div>
        <div class="detail_box">
            <div class="detail_top f33">链接信息 </div>
            <div class="detail_table tc" style="" scrolltop="0" scrollleft="0">
                
            </div>
            <div class="">
                <div class="detail_btn tc">
                    <button type="button" style="border:none; border-radius:5px;padding:.1rem .5rem" class="detail_close f26">关闭</button>
                    
                </div>
            </div>
        </div>
        </div>
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
    <div class="hint_pop hide hint_pop1">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">系统提示</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
<script type="text/javascript">
//查看详情
$(document).on('click', '.caozuo', function(){
    var href = $(this).attr('data-href');
    $.post(href,function(res){
    	$(".detail_table").html(res.data);
    	$(".detail_pop").show();
    },'json' );
    return false;
})
function copyNum() {
                var NumClip=document.getElementById("adv-url");
                var NValue=NumClip.value;
                var valueLength = NValue.length;
                selectText(NumClip, 0, valueLength);
                document.execCommand("Copy","false",null); // 执行浏览器复制命令
                alert("已复制,可分享给朋友啦，试试看。");
            }
//input自带的select()方法在苹果端无法进行选择，所以需要自己去写一个类似的方法
function selectText(obj, startIndex, stopIndex) {
    if (obj.setSelectionRange) {
        obj.setSelectionRange(startIndex, stopIndex);
    } else if (obj.createTextRange) {
        var range = obj.createTextRange();
        range.collapse(true);
        range.moveStart('character', startIndex);
        range.moveEnd('character', stopIndex - startIndex);
        range.select();
    }
    obj.focus();
}
</script>
</body>
</html>
