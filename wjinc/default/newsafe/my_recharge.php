<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>充值</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>

</head>
<body class="bgf5">
<?php
$set=$this->getSystemSettings(); 

?>

<style>
.myi_list li .col67{ min-width: 3.5rem; }
.myt_list li .myw{ width:1.65rem; }
.yzmNum{position: absolute;right:.2rem; top:0;}
.cz_pos{ position: absolute;right:.1rem;top:0; }
</style>

<div class="wrap_box">
    <div class="pay_box1">
        <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>充值</div>
        <div class="f24 myt_text">
                  1、<b style="display:inline;color:#ff2525;">微信、支付宝</b>每天的充值处理时间为：<b style="display:inline;color:#ff2525;">10:00-17：00，19：00-24：00</b>，填写充值金额，点击[下一步]后，将有详细的文字说明 ；<br>
                  2、充值后，<b style="display:inline;color:#ff2525;">请手动刷新&nbsp&nbsp</b>  你的余额及查看相关账变信息，若超过5分钟未加金额，请与在线客服联系。
        </div>

        <form class="myt_form">
            <?php
                $sql="select * from {$this->prename}bank_list b, {$this->prename}sysadmin_bank m where m.admin=1 and m.enable=1 and b.isDelete=0 and b.id=m.bankId ";
                $banks=$this->getRows($sql);
                        
            if($banks&&((date("H")>=0 && date("H")<=16)||(date("H")>=19 && date("H")<=23))){?>
            <ul class="myi_list myt_list myt_list1">
                         
                <li class="clearfix rel">
                    <div class="fl myw">充值方式：</div>

                    <div class="fl ol67 pay_fs">

                    </div>
                </li>
                <li class="clearfix rel flex cz_online">
                    
            
                        <?php
                            if($banks) foreach($banks as $bank){
                        ?>
                        <div class="fx">
                            <label><input class="pay_checked" value="<?=$bank['id']?>" type="radio" bankid="<?=$bank['bankId']?>" name="mBankId" data-bank='<?=json_encode($bank)?>' style="width:auto;-webkit-appearance:radio;" /><img style="display: inline; width:80%" src="/<?=$bank['logo']?>"></label>
                        </div>
                        <?php } ?>
               
                </li>
                <li class="clearfix rel">
                    <div class="fl myw">充值金额：</div>
                    <input class="col67 fl n2" type="tel" style="width:1rem;" name="amount"  value="<?=preg_replace('/^.*(\w{4})$/', '***\1', $bank['account'])?>">
                    <span class="f20 cz_pos" style="pointer-events:none" id="rechargemsg">(单笔限额 最低： <b style="color:#ff2525"><?=$set['rechargeMin']?></b>  元，最高：  <b style="color:#ff2525"><?=$set['rechargeMax']?></b>  元)</span>
                </li>
                <li class="clearfix rel">
                    <div class="fl myw">验证码：</div>
                    <input class="col67 fl n3" type="text"  name="vcode" value="<?=preg_replace('/^(\w).*$/', '\1**', $bank['username'])?>">
                    <b class="yzmNum"><img width="80" height="30" border="0" style="cursor:pointer;margin-bottom:0px;" id="vcode" alt="看不清？点击更换" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></b>
                </li>
                
            </ul>
            <input class="myt_btn tc chongzhi_btn" type="button" value="下一步">
            <?php }else{ ?>
            <div style=" margin-top:30px; text-align:center;color:#F00;">
                	 充值暂停！
            </div>
            <?php }?>
        </form>
    </div>
    <div class="pay_box2">
        
    </div>
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
    <div class=" hide hint_pop2">
        <div class="gameo_mask"></div>
        <div class="hint_con">
            <div class="hint_title f32 tc hint_titles">充值二维码</div>
            <div class="hint_cont f24"></div>
            <div class="tc hint_btn f32">确定</div>
        </div>
    </div>
</div>

<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
<script type="text/javascript">
    $(".chongzhi_btn").click(function(){

        if($('.pay_checked:checked').val()==""){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('请选择充值方式');
            return
        }
        if($(".n2").val()==""){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('请输入充值金额');
            return
        }
        if($(".n3").val()==""){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('请输入验证码');
            return
        }
        $.post('/index.php/cash/inRecharge',$('.myt_form').serialize(), function(res){
            if(!res.code){
                $(".pay_box2").html(res.data); 
                $(".pay_box1").hide();

            }else{
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            }

        },'json')
    })

</script>
</body>
</html>
