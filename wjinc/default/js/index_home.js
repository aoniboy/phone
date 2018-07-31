var index = {
    init: function(){
        // this.loopwin();
        this.opengame();
    },
    opengame:function(){
    	$('.alink').on('click',function(){
    		var flag = $(this).attr('data-open');
    		if(flag === 'true' ||flag === '1' ) {
    			var url = $(this).attr('data-href');
    			window.location.href = url;
    		}else {
    			alert('该彩种还没有权限');
    		}
    	})
    },
    logindo:function(err, data) {
    	if(err){
            alert(err);

        }else{
            location='/';
        }
    },
    loopwin: function(){
    	//循环轮播中奖排名 @ Moda 2016-09-23
    	try {
            var length = 220;
            $("#win_list").css("height",length+"px");
            if( $("#win_list ul").height() < length )
            {
                //数据小于5行的时候不用循环轮播
                return;
            }
            var iCount = 0 ;
            function goPaly()
            {
                iCount++;
                if( iCount%6 > 0 )
                {
                    $("#win_list ").css("top",0 - (iCount%6)*4);
                }
                else
                {
                    var newTr = $("#win_list ul li:eq(0)");
                    $("#win_list ul").append("<li class='rel clearfix'>"+newTr.html()+"</li>");
                    $("#win_list ul").css("top",0);
                    $("#win_list ul  li:eq(0)").remove();
                    iCount = 0;
                }
            }
            window.__sItl_1 = setInterval(goPaly,200);
            $("#prizeUser").bind("touchstart",function(){
                clearInterval( window.__sItl_1);
            });
            $("#prizeUser").bind("touchmove",function(){
                clearInterval( window.__sItl_1);
                event.stopPropagation();
            });
            $("#prizeUser").bind("touchend",function(){
                window.__sItl_1 = setInterval(goPaly,200);
            });
            $("#prizeUser").bind("touchcancle",function(){
                window.__sItl_1 = setInterval(goPaly,200);
            });
        }catch (e){console.log(e);};
    }
    
}
index.init();
