var newdh = {
    init: function(){
        this.bindEvent();
    },
    global:{
        counttimer:null
    },
    bindEvent: function(){
        $.post('/index.php/game/get28qhinfo/54',function(data){
            var data = data.data;
            $(".qishu1").text(data.actionNo.actionNo);
            newdh.countdown(Math.abs(data.actionNo.difftime));
        },'json' );
        $(".wf_btn").click(function(){
            var num = $(this).attr("data-index");
            var add = $(this).attr("data-add");
            if(add=="jia"){
                if(num >=2){
                    num =0;
                }else{
                    num ++;
                }
            }else if(add=="jian"){
                if(num ==0){
                    num =2;
                }else{
                    num--;
                }
            }
            $(this).attr("data-index",num);
            $(".wf_n").hide();
            $(".wf_n").eq(num).show();
            $(".wf_cont> li").hide();
            $(".wf_cont>li").eq(num).show();
        })
        $(".wf_zhi1 li").click(function(){
            $(".wf_zhi1 li .wf_z").removeClass("active");
            $(this).find(".wf_z").addClass("active");
            var title = $(this).find(".c_title").attr("data-title");
            var val = $(this).find(".c_val").attr("data-value");
            $(".f_title").val(title);
            $(".f_val").val(val);
        })
        $(".cp_input").blur(function(){
            console.log($(this).val());
            if($(this).val()==0){
                $(this).val(1)
            }
        })
        $(".tz_btns").click(function(){
            $(".pop_wrap").show();
        })
        $(".mask").click(function(){
            $(".pop_wrap").hide();
        })
        $(".js_jia").click(function(){
            console.log(1)
            var val = $(this).attr("data-value");
            var num = $(".cp_input").val();
            if(val == "jia"){
                num ++;
                $(".cp_input").val(num)
            }else if(val == "jian"){
                num --;
                $(".cp_input").val(num);
                if(num <=0){
                    $(".cp_input").val(1);
                }
            }
        })
        $(".toplist").on("click",".top_title",function(){
            var d = $(this).index();
            if(d ==0){
                if($(this).hasClass("on")){
                    $(".toplist li").hide();
                    $(this).removeClass("on")
                }else{
                     $(".toplist li").show();
                     $(this).addClass("on")
                }
               
            }
        })
        $(".hi_btn").click(function(){
            $(".hi_pop").hide();
        })
    },
    countdown: function(times,kjtime,kjftime){ //倒计时
        newdh.global.counttimer=setInterval(function(){
            var day=0,
            hour=0,
            minute=0,
            second=0;//时间默认值
            if(times > 0){
                day = Math.floor(times / (60 * 60 * 24));
                hour = Math.floor(times / (60 * 60)) - (day * 24);
                minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            
            $(".gameo_second").text(game.checkTime(second));
            $(".gameo_minute").text(game.checkTime(minute));
            if(times ==5 ){
                // $(".kaijiang")[0].play();
            }
            times--;
        },1000);
    },
}

newdh.init();