var my = {
    init: function(){
        this.bindEvent();
        this.passwordEdit();
        this.myInfo();
        this.member();
    },
    bindEvent: function(){


        
        //提现转大写
        $(".my_tixian1").keyup(function(){
            $(".my_tixian2").val(my.convertCurrency($(this).val()));
        })
        $(".tixian_btn").click(function(){
            $.post('/index.php/cash/ajaxToCash', $(".myt_form").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );
        })
        //推广
        $(document).on('click','#tg_edit', function(){
            var t1 = $(".t1").val();
            var t2 = $(".t2").val();
            if(t1==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('请设置返点');
                return;
            }
            if(t2==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('请设置不定返点');
                return;
            }
            $.post('/index.php/team/linkUpdateed', $(".edit_form").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );
        })
        $(document).on('click','.td_delete', function(){
            var url = $(this).attr("data-href");
            if(confirm("确认删除吗")){
                $.post(url, function(res){
                    $(".hint_pop1").show();
                    $(".hint_pop1 .hint_cont").text(res.msg);
                },'json' );
            }

        })
        $('#dl_tgadd').on('click', function(){
            var t1 = $(".t1").val();
            var t2 = $(".t2").val();
            if(t1==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('请设置返点');
                return;
            }
            if(t2==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('请设置不定返点');
                return;
            }
            $.post('/index.php/team/insertLink',$(".add_form").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );
        })
    },
    myInfo: function(){
        $("#my_info_edit").on('touchend',function(){
            
            $.post('/index.php/safe/setCBAccount', $(".myi_form").serialize(), function(res){
            	$(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg); 
                if(!res.code) {
                	$('.myi_btns').hide();
                }
            },'json' );
        })
    },
    passwordEdit: function(){
       //登录密码修改
        $("#login_btn").on('touchend', function(){
            if($(".myi_form1 .pas1").val() ==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('密码不能为空');
                return;
            }
            if($(".myi_form1 .pas2").val() != $(".myi_form1 .pas3").val() || $(".myi_form1 .pas2").val() ==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('新密码不一致');
                return;
            }
            if($(".myi_form1 .pas2").val().length<6){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('登录密码至少6位');
                return;
            }
            $.post('/index.php/safe/setPasswd', $(".myi_form1").serialize(), function(res){
                    $(".hint_pop1").show();
                    $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );
        })
        //支付密码修改
        $("#pay_btn").on('touchend', function(){
            var url = $(this).attr("data-url");
            if($(".myi_form2 .pas1").val() ==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('密码不能为空');
                return;
            }
            if($(".myi_form2 .pas2").val() != $(".myi_form2 .pas3").val() || $(".myi_form2 .pas2").val() ==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('新密码不一致');
                return;
            }
            if($(".myi_form2 .pas2").val().length<6){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('资金密码至少6位');
                return;
            }
            $.post(url, $(".myi_form2").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );
        })
    },
    member: function(){
        //会员管理
        $("#my_member_edit").click(function(){
            var v1 = $(".i1").val();
            var v2 = $(".i2").val();
            var v3 = $(".i3").val();
            if(v1 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('分成不能大于或等于0.0');
                return;
            }
            if(v2 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('返点不能大于或等于0.0');
                return;
            }
            if(v3 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('不定返点不能大于或等于0.0');
                return;
            }
            $.post('/index.php/team/userUpdateed', $(".myi_form").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );

        })
        //会员添加
        $("#dl_add_member").click(function(){
            var v1 = $(".i1").val();
            var v2 = $(".i2").val();
            var v3 = $(".i3").val();
            var v4 = $(".i4").val();
            var v5 = $(".i5").val();
            var v6 = $(".i6").val();
            var v7 = $(".i7").val();
            var regEx = /^[a-zA-Z0-9_]{4,16}$/;
            var regExQQ = /^[a-zA-Z0-9_]{1,16}$/;
            if(!regEx.test(v1)){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('用户名由4-16位的字母或数字组成');
                return;
            }
            if(v2 != v3 || v2 ==""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('密码不一致');
                return;
            }
            if(v2.length<6){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('密码至少6位');
                return;
            }
            if(!regExQQ .test(v7)){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('微信只能由字母或数字组成');
                return;
            }
            if(v4 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('分成不能大于或等于0.0');
                return;
            }
            if(v5 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('返点不能大于或等于0.0');
                return;
            }
            if(v6 == ""){
                $(".hint_pop").show();
                $(".hint_pop .hint_cont").text('不定返点不能大于或等于0.0');
                return;
            }
            $.post('/index.php/team/insertMember', $(".myi_form").serialize(), function(res){
                $(".hint_pop1").show();
                $(".hint_pop1 .hint_cont").text(res.msg);
            },'json' );

        })
    },
    convertCurrency: function(money) {
        //汉字的数字
        var cnNums = new Array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        //基本单位
        var cnIntRadice = new Array('', '拾', '佰', '仟');
        //对应整数部分扩展单位
        var cnIntUnits = new Array('', '万', '亿', '兆');
        //对应小数部分单位
        var cnDecUnits = new Array('角', '分', '毫', '厘');
        //整数金额时后面跟的字符
        var cnInteger = '整';
        //整型完以后的单位
        var cnIntLast = '元';
        //最大处理的数字
        var maxNum = 999999999999999.9999;
        //金额整数部分
        var integerNum;
        //金额小数部分
        var decimalNum;
        //输出的中文金额字符串
        var chineseStr = '';
        //分离金额后用的数组，预定义
        var parts;
        if (money == '') {
            return '';
        }
        money = parseFloat(money);
        if (money >= maxNum) {
            //超出最大处理数字
            return '';
        }
        if (money == 0) {
            chineseStr = cnNums[0] + cnIntLast + cnInteger;
            return chineseStr;
        }
        //转换为字符串
        money = money.toString();
        if (money.indexOf('.') == -1) {
            integerNum = money;
            decimalNum = '';
        } else {
            parts = money.split('.');
            integerNum = parts[0];
            decimalNum = parts[1].substr(0, 4);
        }
        //获取整型部分转换
        if (parseInt(integerNum, 10) > 0) {
            var zeroCount = 0;
            var IntLen = integerNum.length;
            for (var i = 0; i < IntLen; i++) {
                var n = integerNum.substr(i, 1);
                var p = IntLen - i - 1;
                var q = p / 4;
                var m = p % 4;
                if (n == '0') {
                    zeroCount++;
                } else {
                    if (zeroCount > 0) {
                        chineseStr += cnNums[0];
                    }
                    //归零
                    zeroCount = 0;
                    chineseStr += cnNums[parseInt(n)] + cnIntRadice[m];
                }
                if (m == 0 && zeroCount < 4) {
                    chineseStr += cnIntUnits[q];
                }
            }
            chineseStr += cnIntLast;
        }
        //小数部分
        if (decimalNum != '') {
            var decLen = decimalNum.length;
            for (var i = 0; i < decLen; i++) {
                var n = decimalNum.substr(i, 1);
                if (n != '0') {
                    chineseStr += cnNums[Number(n)] + cnDecUnits[i];
                }
            }
        }
        if (chineseStr == '') {
            chineseStr += cnNums[0] + cnIntLast + cnInteger;
        } else if (decimalNum == '') {
            chineseStr += cnInteger;
        }
        console.log(chineseStr);
        return chineseStr;
    }

}
my.init();