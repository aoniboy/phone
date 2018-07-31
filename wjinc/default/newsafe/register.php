<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>会员注册</title>
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?=$this->sversion?>">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?=$this->sversion?>">
    <script src="/wjinc/default/js/jquery.min.js<?=$this->sversion?>"></script>
</head>
<body class="bgf5">
<div class="wrap_box">
    <div class="title_top tc"><a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>会员管理</div>
     <div class="clearfix myp_top dlm_top">
         <?php if($args[0] && $args[1]){
        
		$sql="select * from {$this->prename}links where lid=?";
		$linkData=$this->getRow($sql, $args[1]);
		$sql="select * from {$this->prename}members where uid=?";
		$userData=$this->getRow($sql, $args[0]);
	
		?>

		<form class="dl_form my_register" action="/index.php/user/registered" method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax">
        	<input type="hidden" name="parentId" value="<?=$args[0]?>" />
            <input type="hidden" name="lid" value="<?=$linkData['lid']?>"  />
          	<dl>
            	<dt>用户名：</dt>
                <dd><input name="username" type="text" id="username" class="login-text my_reinput m_re1" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"/></dd>
            </dl>
            <dl>
            	<dt>密  码：</dt>
                <dd><input name="password" type="password" id="password" class="login-text my_reinput m_re2" /></dd>
            </dl>
             <dl>
            	<dt>确认密码：</dt>
                <dd><input name="cpasswd" type="password" id="cpasswd" class="login-text my_reinput m_re3" /></dd>
            </dl>
             <dl>
            	<dt>微  信：</dt>
                <dd><input name="qq" type="test" id="qq" class="login-text my_reinput m_re4" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/></dd>
            </dl>
            <dl>
            	<dt>验证码：</dt>
                <dd style="position:relative;"><input name="vcode" type="text" class="login-text my_reinput m_re5" /><div class="yzmNum my_yzm"><img width="72" height="24" border="0" id="vcode" style="cursor:pointer;" align="absmiddle" src="/index.php/user/vcode/<?=$this->time?>" title="看不清楚，换一张图片" onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()"/></div></dd>
            </dl>
             <dl>
            	<dt class="hide"><input type="submit" value=""/></dt>
                <dd><button class="login-btn my_reibtn" tabindex="5" type="button">注　册</button></dd>
            </dl>
          </form>
           <?php }else{?>
           <div style="text-align:center; line-height:50px; color:#FF0; font-size:20px; font-weight:bold;">链接失效！</div>
           <?php }?>
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
<input id="denglu" type="hidden" value="1">
<script src="/wjinc/default/js/common.js<?=$this->sversion?>"></script>
<script src="/wjinc/default/js/my.js<?=$this->sversion?>"></script>
<script>
    $(".my_reibtn").click(function(){
        var m1 = $(".m_re1").val();
        var m2 = $(".m_re2").val();
        var m3 = $(".m_re3").val();
        var m4 = $(".m_re4").val();
        var m5 = $(".m_re5").val();
        var regEx = /^[a-zA-Z0-9_]{4,16}$/;
        var regExQQ = /^[a-zA-Z0-9_]{1,16}$/;
    
        if(!regEx.test(m1)){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('用户名由4到16位的字母、数字及下划线组成');
            return;
        }else if(m2.length<6 || m2!=m3){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('密码至少6位');
            return;
        }else if(m5==""){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('验证码不能为空');
            return;
        }
        if(!regExQQ .test(m4)){
            $(".hint_pop").show();
            $(".hint_pop .hint_cont").text('微信只能由字母或数字组成');
            return;
        }

        $.ajax({
            //几个参数需要注意一下
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "/index.php/user/registered" ,//url
                data: $(".dl_form").serialize(),
                success: function (res) {
                	if(!res.code){
                    	$(".hint_pop").show();
                    	$(".hint_pop .hint_title").text('系统提示');
                        $(".hint_pop .hint_cont").text(res.msg);
                        window.location.href="/index.php/user/login/"
                    } else{
                        $(".hint_pop").show();
                        $(".hint_pop .hint_cont").text(res.msg);
                    }
                    
                },
                error : function() {
                    alert("异常！");
                }
            });
    })
    $(".hint_btn").click(function(){
        $(".hint_pop").hide();
    })
</script>
</body>
</html>
