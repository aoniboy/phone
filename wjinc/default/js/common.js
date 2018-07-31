var common = {
    init: function(){
        this.bindEvent();
        this.kf();
        this.checklogin();
        this.orderdetail();
        this.logout();
        this.dealInfo();
    },
    bindEvent: function(){
        $(".w_heiht").height($(window).height());
    },
    kf: function(){
    	$(".kf").on('click', function(){
	        var iTop = (window.screen.availHeight-30-570)/2; //获得窗口的垂直位置;
	        var iLeft = (window.screen.availWidth-10-750)/2; //获得窗口的水平位置;
	        var url = $('#kefu').val();
	        var winOption = "height=570,width=750,top="+iTop+",left="+iLeft+",toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,fullscreen=1";
	        var newWin = window.open(url,window, winOption);
	        return false;
    	});
    },
    checklogin: function() {//每5秒检查用户是否在线
    	if($('#denglu').val() !=1) {
	    	var timers=null;
	        timers=setInterval(function(){
	        	//默认期号
	            $.post('/index.php/user/checklogin',function(data){
	                if(!data.code){
	                	if(data.data){
	                		clearInterval(timers)
	                		window.location.href='/index.php/user/login';
	                		return false;
	                	}
	                    
	                }
	            },'json' );
	            
	        },5000);
    	}
    },
    orderdetail: function(){
    	//查看详情
        $('table').on('click', 'td.orderdetail', function(){
            var id = $(this).attr('data-id');
            $.post('/index.php/record/betInfo/'+id,function(data){
            	$(".detail_pop").show();
                $('.detail_table').html(data);
            },'text' );
            return false;
        })
        //查看详情
        $('.myp_table').on('click', 'td.orderdetail', function(){
            var id = $(this).attr('data-id');
            $.post('/index.php/record/betInfo/'+id,function(data){
            	$(".detail_pop").show();
                $('.detail_table').html(data);
            },'text' );
            return false;
        })
        //撤单
        $('.myp_table').on('click', '.chedan', function(){
        	var r=confirm("确定撤单么?");
            if (r==true){
            	var id = $(this).attr('id');
                $.post('/index.php/game/deleteCode/'+id,function(data){
                    if(!data.code){
                        $(".hint_pop .hint_title").text('提示');
                        $(".hint_pop .hint_cont").text('撤单成功');
                        $(".hint_pop").show();
                    }else{
                        $(".hint_pop .hint_cont").text(data.msg);
                        $(".hint_pop").show();
                    }
                },'json' );
            }
            
            return false;
        })
         $(".detail_close").on('touchend', function(){
            $(".detail_pop").hide();
        })
    },
    logout: function() {
    	$('div').on('click', '.logout', function(){
    		window.location.href = "/index.php/user/logout";
    	});
    },
    dealInfo: function() {//每10秒检查用户信息
    	if($('#denglu').val() !=1) {
    		var time_d1 = setInterval(function(){
                $.post('/index.php/Tip/getCZTip',function(res){
                    if(res.data.flag){
                        $(".hint_pop .hint_cont").text(res.data.message);
                        $(".hint_pop .hint_title").text("系统提示");
                        $(".hint_pop").show();
                    }
                },'json' );
            },10000) 
            $(".hint_btn").on('touchend', function(){
                $(".hint_pop .hint_title").text('错误提示');
                $(".hint_pop").hide();
                $(".hint_pop1").hide();
                return false;
            })
            if($('#ymy').val() ==1){
	            var time_d2 = setInterval(function(){
	                $.post('/index.php/index/userajaxinfo',function(res){
	                    if(!res.code){
	                        $('.yyue').text(res.data.money);
	                        $('.yyingkui').text(res.data.yingkui);
	                    }
	                },'json' );
	            },10000) 
            }
    		var time_d3 = setInterval(function(){
                $.post('/index.php/Tip/getTKTip',function(res){
                    if(res.data.flag){
                        $(".hint_pop .hint_cont").html(res.data.message);
                        $(".hint_pop .hint_title").text("系统提示");
                        $(".hint_pop").show();
                    }
                },'json' );
            },10000)

    	}
    },
}
common.init();
