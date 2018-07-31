<!DOCTYPE html>
<!-- saved from url=(0021)https://m.ub8one.com/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=320.1, target-densitydpi=320, initial-scale=0.5, user-scalable=no, minimum-scale=0.5, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?=$this->iff($args[0], $args[0] . '－'). $this->settings['webName']?></title>
    <link rel="Shortcut Icon" href="https://m.ub8one.com/images/icon.png">
    <link rel="Bookmark" href="https://m.ub8one.com/images/icon.png">
    <link rel="icon" href="https://m.ub8one.com/images/icon.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="https://m.ub8one.com/images/icon.png">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/user/reset.css">
    <link rel="stylesheet" type="text/css" href="/wjinc/default/user/message_default.css" >
    <link rel="stylesheet" type="text/css" href="/wjinc/default/user/public.css" >
    <link rel="stylesheet" type="text/css" href="/wjinc/default/user/login.css" >
    <script type="text/javascript" src="/skin/js/jquery-1.8.0.min.js?v=5.0"></script>


    <script type="text/javascript">
        function registerBeforSubmit(){
            var type=$('[name=type]:checked',this).val();
            if(!this.username.value) throw('没有输入用户名');
            if(!/^\w{4,16}$/.test(this.username.value)) throw('用户名由4到16位的字母、数字及下划线组成');
            if(!this.password.value) throw('请输入密码');
            if(this.password.value.length<6) throw('密码至少6位');
            if(!this.cpasswd.value) throw('请输入确认密码');
            if(this.cpasswd.value!=this.password.value) throw('两次输入密码不一样');
        }
        function registerSubmit(err,data){
            if(err){
                alert(err);
            }else{
                alert(data);
                location='/index.php/user/login';
            }
            $("#vcode").trigger("click");
        }
        function userBeforeLogin(){
            var u=this.username.value;
            var v=this.vcode.value;
            if(!u || u=='帐号'){alert("请输入用户名");}
            else if(!v || v=='验证码'){alert("请输入验证码");}
            else{return true;}
            return false;
        }
        function userLogin(err, data){
            if(err){
                alert(err);
                $('input[name=vcode]')
                    .val('')
                    .closest('div')
                    .find('.yzmNum img')
                    .click();

            }else{
                location='/index.php/user/loginto';
            }
        }
        function userBeforLoginto(){
            var u=this.username.value;
            var p=this.password.value;
            if(!u || u=='帐号'){alert("请输入用户名");}
            else if(!p || p=='xx@x@x.x'){alert("请输入密码");}
            else{return true;}
            return false;
        }
        function userLoginto(err, data){
            if(err){
                alert(err);

            }else{
                location='/';
            }
        }

        $(function(){

            $('form[target=ajax]').live('submit', function(){
                var data	= [],
                    $this		= $(this),
                    self		= this,
                    onajax		= window[$this.attr('onajax')],
                    call		= window[$this.attr('call')];

                if(typeof call!='function'){
                    call=function(){}
                }
                if('function'==typeof onajax){
                    try{
                        if(onajax.call(this)===false) return false;
                    }catch(err){
                        call.call(self, err);
                        return false;
                    }
                }
                $(':input[name]', this).each(function(){
                    var $this=$(this),
                        value=$this.data('value'),
                        name=$this.attr('name');
                    if($this.is(':radio, :checkbox') && this.checked==false) return true;
                    if(value===undefined) value=this.value;
                    data.push({name:name, value:value});
                });
                $.ajax({
                    url:$this.attr('action'),
                    async:true,
                    data:data,
                    type:$this.attr('method')||'get',
                    dataType:$this.attr('dataType')||'json',
                    headers:{"x-form-call":1},
                    error:function(xhr, textStatus, errThrow){
                        call.call(self, errThrow||textStatus);
                    },
                    success:function(data, textStatus, xhr, headers){
                        var errorMessage=xhr.getResponseHeader('X-Error-Message');
                        if(errorMessage){
                            call.call(self, decodeURIComponent(errorMessage), data);
                        }else{
                            call.call(self, null, data);
                        }
                    }
                });
                return false;
            });


        })
    </script>
</head>
<body>

<!--Login-->
<div id="" class="wrapper blue-bg login1">
    <div class="content">
        <div class="panel nobg">
            <form action="/index.php/user/loginedto" method="post" onajax="userBeforeLoginto" enter="true" call="userLoginto" target="ajax">
            <div class="row"><img src="/wjinc/default/images/logo.png"  style="height: 140px"> </div>
            <div class="row"><input class="textfield icon-user" type="text" name="username" maxlength="14" placeholder="请输入您的账号" id="username" value=""></div>
            <div class="row"><input class="textfield icon-lock" type="password" name="password" maxlength="16" placeholder="请输入您的密码" id="password" value=""></div>
            <div class="row"><button class="button button-red" type="submit" id="">登录</button></div>
            <div class="w80 sepline"></div>
            </form>
        </div>
    </div>

    <p class="copyright"><small>Copyright © 2007-<span id="showdt">2017</span></small></p>
    <!-- <p class="copyright"><small>Si 1.1.0</small></p> -->
</div>
<!---->

<!--维护中
<div id="" class="wrapper blue-bg login2">
    <div class="content">
        <div class="oops">
            <h1>OOPS...</h1>
        </div>
        <div class="tip-white w60">
            <p>您可以根据以上三种方式，找回您遗失的密码。</p>
        </div>
    </div>
    <p class="copyright"><small>Copyright &copy; 2014 ub8 Inc. All rights reserved.</small></p>
</div>
<!---->
<script type="text/javascript">
    var today=new Date();
    document.getElementById('showdt').innerHTML = today.getFullYear();
</script>

<div class="dhx_modal_cover" style="display: none;"></div></body></html>