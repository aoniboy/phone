var myScroll;
var myScroll2;
function loaded () {
	try{
		//myScroll = new IScroll('#wrapper_1', { mouseWheel: true,click: false });
	}catch(e){
		console.log(e);
	}

   // myScroll2 = new IScroll('#wrapper_2', { mouseWheel: true,click: true });
}
//下面代码影响页面所有的点击事件
isLogin = false;
//弹窗
$(function(){
	//$('.ui-betting-title').click(function(){
    $('.ui-betting-title').bind('touchend', function () {
        event.preventDefault();
        if (location.href.indexOf('/mine/betList.html?onlyWin=1') > -1) {
            return;
        }
        if (location.href.indexOf('/bet/') > -1 && $('.beet-odds-tips').css('display') != 'none') {
            return;
        }
	    $('.beet-tips').toggle();
        $('.beet-rig').hide();
	});
	
    $('.bett-heads').click(function(){
        $('.tips-bg').toggle();
    });

    $('.bett-head').click(function(){
        $('.beet-tips').hide();
		$('.beet-rig').toggle();
        return false;
	});
    
    $('.beet-tips').bind("click",function(){
    	//console.log($(this).css('display'));
    	if($(this).css('display')!='none'){
    		event.stopPropagation();
    	}
    });

    // click anywhere toggle off
    $(window).bind("load",function(){
        $(document).on("click",function() {
            if($('.beet-rig').is(':visible')) {
                $('.beet-rig').toggle();
            }
            else {
                $('.beet-rig').css('display','none');
            }
            if($('.beet-tips').is(':visible')) {
                $('.beet-tips').toggle();
            }
            else {
                $('.beet-tips').css('display','none');
            }
            
        });
        
        $('li.specific-cell-o>span').bind('touchend', function () {
            if($('.beet-rig').is(':visible')) {
                $('.beet-rig').toggle();
            }
            else {
                $('.beet-rig').css('display','none');
            }
            if($('.beet-tips').is(':visible')) {
                $('.beet-tips').toggle();
            }
            else {
                $('.beet-tips').css('display','none');
            }
        });

        $('#wrapper_1').bind('touchend', function () {
            if($('.beet-rig').is(':visible')) {
                $('.beet-rig').toggle();
            }
            else {
                $('.beet-rig').css('display','none');
            }
            if($('.beet-tips').is(':visible')) {
                $('.beet-tips').toggle();
            }
            else {
                $('.beet-tips').css('display','none');
            }
        });
    });
	// end
   
    // scroll toggle off
    $(document).scroll(function() {
      if($('.beet-rig').is(':visible')) {
        $('.beet-rig').toggle();
      }
      else {
        $('.beet-rig').css('display','none');
      }
      if($('.beet-tips').is(':visible')) {
          $('.beet-tips').toggle();
        }
        else {
          $('.beet-tips').css('display','none');
        }
    });
    // end

    //  hide address bar
    window.addEventListener("load",function() {
        // Set a timeout...
        /*setTimeout(function(){
            // Hide the address bar!
            window.scrollTo(0, 1);
        }, 0);*/
    });

    $('.bett-odd a').click(function(){
		$('.bett-odd').toggleClass('bett-odd-r')
	});
    timeOld = 0;//记录上次点击事件
    timeNew = 0;//判断是否恶意点击
    $('button#reveal-left, button#back_to_bet').click(function() {
    //$('button#reveal-left, button#back_to_bet').bind('touchend', function () {
        //event.preventDefault();
        timeNew = new Date().getTime() + 0;
        if (timeNew - timeOld < 1000) {
            return;
        }
        timeOld = timeNew;
        //event.preventDefault();
        var tmpCount = $('i#bet_time_count').text();
        //先判断投注单数
        if (tmpCount != null && tmpCount != undefined && tmpCount != '' && tmpCount > 0) {       	
//          if(confirm('退出页面会清空购物篮里的注单，是否退出？')) {
//              var tmpUrl = '';
//              if (document.referrer.indexOf('/index/login.html') > -1) {//从登陆页面返回
//                  tmpUrl = '/';
//              } else {
//                  tmpUrl = document.referrer;
//              }
//              clearBetSess(tmpUrl);
//              return;
//          }
			/*
			var tmpUrl = '';
            if($('#__dialog').length == 0) {
                $("body").append('<div id="__dialog"><div id="shuchukuang">退出页面会清空购物篮里的注单, 是否退出？</div></div>');
           }
            else{}

            $("#__dialog").dialog({
			    height: "auto",
                margin: "auto",
			    width: '93%',
			    modal: true,
			    buttons: {
				     确定: function() {
				        if (document.referrer.indexOf('/index/login.html') > -1) {//从登陆页面返回
			                    tmpUrl = '/';
		                } else {
		                    tmpUrl = document.referrer;
		                }
		                tmpUrl = '/lobby/index.html';
		                clearBetSess(tmpUrl);
				        return ;
				    },
                    '':function() {
                    },
					取消:function() {
			        	$( this ).dialog( "close" );
			        }
			    }
			});

            $(".ui-dialog").css("top","20%");
            $("#__dialog").css("margin","5%").css("min-height","120px");
            $(".ui-dialog-buttonpane button").css("color","##5a5af7");
            $(".ui-dialog-buttonset").css("width","100%").css("border-top","1px solid #e2e2e2");
            $(".ui-button-text-only").css("width","49%").css("margin","0%").css("background","transparent").css("border","0px").css("height","35px");
            $(".ui-button-text-only").eq(1).css("width","0px").css("border","1px solid #dcdcdc");
            $(".ui-button-text").css("font-size","17px");
			$(".ui-dialog-titlebar").remove();
            return;*/

            msgConfirm("退出页面会清空购物篮里的注单, 是否退出？",function(){
                if (document.referrer.indexOf('/index/login.html') > -1) {//从登陆页面返回
                    tmpUrl = '/';
                } else {
                    tmpUrl = document.referrer;
                }
                tmpUrl = '/lobby/index.html';
                clearBetSess(tmpUrl);
                return ;
            });
            return;
        }
        var tmpSelCount = $('span#bet_sel_count').text();
        if (location.href.indexOf('/bet/betList.html') == -1 && location.href.indexOf('/betSix/betList.html') == -1
            && tmpSelCount != undefined && tmpSelCount != '' && tmpSelCount > 0) {
            msgConfirm("是否放弃所选的号码？",function(){
                var idx = $('#his_idx').val();
                idx = (idx == undefined) ? 1 : idx;
                history.go(-idx);
                return;
                location.href = '/lobby/index.html';
                return;
            });
            return;
        }
        //从投注页返回上一页,时时彩
        if ((/\/bet\/[a-z]+(ssc|ks).html/g.test(location.href) ||
            /\/bet\/eleven[a-z]+.html/g.test(location.href) ||
            /\/bet\/(fcsd|tcps|ssl|pk10|twpk10|xync|xy28|xjp28|sfc).html/g.test(location.href) ||
            /\/betSix\/index.html/g.test(location.href))
            && location.href.indexOf('bet_url') == -1) {
            var tmpSelCount = $('span#bet_sel_count').text();
            //判断已选注数
            if (tmpSelCount != null && tmpSelCount != undefined && tmpSelCount != '' && tmpSelCount > 0) {
                msgConfirm("是否放弃所选的号码？",function(){
                    if (document.referrer.indexOf('/index/login.html') > -1) {//从登陆页面返回
                        tmpUrl = '/';
                    } else {
                        tmpUrl = document.referrer;
                    }
                    tmpUrl = '/lobby/index.html';
                    location.href = tmpUrl;
                    return ;
                });
                return;
            }else{
                var idx = $('#his_idx').val();
                idx = (idx == undefined) ? 1 : idx;
                history.go(-idx);
                return;
                location.href = '/lobby/index.html';
                return;
            }
        }
        if (location.href.indexOf('/betSix/betList.html') > -1) {
            gotoBack();
            return;
        }
        //从投注页面返回上一页
        if (location.href.indexOf('/bet/betList.html') > -1 ||
            location.href.indexOf('/betSix/betList.html') > -1) {
            var tmpUrl = $('#betUrl').val();
            if (tmpUrl != undefined && tmpUrl != '') {
                if (/his\_idx\=[0-9]+/g.test(tmpUrl)) {
                    tmpUrl = tmpUrl.replace(/his\_idx\=[0-9]+/g, 'his_idx='+(parseInt($('#his_idx').val())+1));
                } else {
                    tmpUrl = tmpUrl+(tmpUrl.indexOf('?') > -1 ? '&' : '?')+'his_idx='+(parseInt($('#his_idx').val())+1);
                }
                //返回上次玩法
                var tmpSpid = spid;
                if (',41,42,'.indexOf(','+gameId+',') > -1) {//pcdd
                    tmpSpid = toFaceSpid(spid);
                    tmpSpid = (tmpSpid == undefined) ? spid : tmpSpid;
                }
                if (/playid\=[0-9]*/g.test(tmpUrl)) {
                    tmpUrl = tmpUrl.replace(/playid\=[0-9]*/g, 'playid='+playid);
                } else {
                    tmpUrl = tmpUrl+(tmpUrl.indexOf('?') > -1 ? '&' : '?')+'playid='+playid;
                }
                if (/spid\=[0-9]*/g.test(tmpUrl)) {
                    tmpUrl = tmpUrl.replace(/spid\=[0-9]*/g, 'spid='+tmpSpid);
                } else {
                    tmpUrl = tmpUrl+(tmpUrl.indexOf('?') > -1 ? '&' : '?')+'spid='+tmpSpid;
                }
                location.href = tmpUrl;
            } else {
                history.go(-1);
            }
            return;
        }
        if (location.href.indexOf('/doBet/ok.html') > -1) {
            gotoUrl();
            return;
            history.go(-2);
            return;
        }
        //检测是否登陆
        //走势返回到首页。如果上一页是充值结束，则进入首页
        if (location.href.indexOf('/mine/index.html') > -1
            //|| location.href.indexOf('/trend/index.html') > -1
            || document.referrer.indexOf('/index/registerOk.html') > -1) {
            location.href = '/';
            return;
        }
        //充值后返回
        if (document.referrer.indexOf('/deposit/end.html') > -1
            || location.href.indexOf('/deposit/end.html') > -1
            || document.referrer.indexOf('/mine/withdrawOk.html') > -1
            || location.href.indexOf('/mine/withdrawOk.html') > -1) {
            location.href = '/mine/index.html';
            return;
        }
        if (location.href.indexOf('/deposit/index.html') > -1){
            var idx = $('#his_idx').val();
            idx = (idx == undefined) ? 1 : idx;
            history.go(-idx);
            return;

        }
        if (location.href.indexOf('/deposit/index.html') > -1
            ||location.href.indexOf('/deposit/wechat.html') > -1
            ||location.href.indexOf('/deposit/alipay.html') > -1
            ||location.href.indexOf('/deposit/bank.html') > -1 ){
            msgConfirm("您的支付未完成，是否放弃充值？",function(){
                window.history.go(-1);
                return;
            });
            return;
        }
        //个人中心、走势、充值提款页面，需要检测登陆
        if (document.referrer.indexOf('/mine/') > -1
            || document.referrer.indexOf('/trend/') > -1
            || document.referrer.indexOf('/deposit/') > -1
            || document.referrer.indexOf('/index/login.html') > -1) {
            checkLogin();
            return;
        }

        //红包
        if (location.href.indexOf('/luckymoney/index.html') > -1
            ||location.href.indexOf('/luckymoney/lshb.html') > -1
            ||location.href.indexOf('/luckymoney/ok.html') > -1) {
            location.href = '/luckymoney/qhb.html';
            return;
        }

        //我的红包
        if (location.href.indexOf('/luckymoney/myList.html') > -1) {
            //console.log(document.referrer);return
            if($(this).attr('data-gotourl')){
                console.log(decodeURIComponent($(this).attr('data-gotourl')));
                location.href = decodeURIComponent($(this).attr('data-gotourl'));
                return;
            }
        }
        if(location.href.indexOf('/luckymoney/qhb') > -1){
            location.href = '/lobby/index.html';
            return;
        }
        if(location.href.indexOf('/lobby/index.html') > -1){
            location.href = '/';
            return;
        }


        window.history.go(-1);
        return;
    });
});

function reLogin(desc) {
    if (/未指定具体帐号|帐号不存在|该帐号需要验证|请重新登录|请重新登陆|请登录|请登陆/g.test(desc)) {
        location.href = '/index/login.html?clear=1&ref_url=' + location.href;
        return true;
    }
}

//清除投注sess
function clearBetSess(url) {
    $.ajax({
        url: '/doBet/ajaxClearBet.html',
        type: 'POST',
        dataType: 'json',
        data: { },
        timeout: 30000,
        success: function (data) {
            if (data.Result) {
                $('#__dialog').dialog( "close" );
                var idx = $('#his_idx').val();
                if (/^[0-9]+$/g.test(idx)) {
                    history.go(-idx);
                } else {
                    location.href = url;
                }
                return;
            }
        }
    });
}

//检测登陆
function checkLogin() {
    $.ajax({
        url: '/index/isLogin.html',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.isLogin == false) {
                window.location.href = '/?wap=page';
            } else if (document.referrer.indexOf('/index/login.html') > -1) {
                window.location.href = '/';
            } else {
                window.history.go(-1);
            }
        }
    });
}

/*
 * 刷新用户状态
 */
function refreshUserStatus() {
    $.ajax({
        url: '/index/ajaxRefreshStatus.html',
        method: 'post',
        dataType: 'json',
        data: '',
        timeout: 30000,
        success: function (data) {
        }
    });
}

$(function() {
    setInterval("refreshUserStatus()", 1000*90);
});
