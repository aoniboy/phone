var game = {
    init: function () {
        this.bindEvent();
        this.windowInit();
        this.dealh5inback();
    },
    code: [],
    allCont: {
        all_stake: 0,
        all_money: 0,
        playid: '',
        groupid: '',
        actionNo: '',
        kjTime: '1524574800',
        type: '',
        zhuiHao: '1',
        zhuiHaoMode: '',
    },
    zhuihao: '',
    del_id: 1,
    is_false: false,
    all_len: '',
    data: [],
    is_zhui: false,
    beiyong: {
        all_stake: 0,
        all_money: 0,
    },
    global: {
        cid: 0,
        gametimer: null,
        kjtimer: false,
        kjtimeryk: false,
        fengpantimer: null,
        counttimer: null,
        datainfo: {
            num: 0,
            bonus: 0,
            fun: ''
        },
        namespace: 'youle',
        fengpan: false,
        lastactionNo: '',
        ttime: 0
    },
    betInfo: {
        num: 0,
        data: '',
        money: 0,
        fandian: 0
    },
    bindEvent: function () {
        window[game.global.namespace] = [];
        game.betInfo.fandian = $('#slider').attr('fan-dian');
        //默认数据
        var cid = $(".playedtype").val();
        game.global.cid = cid;
        game.allCont.type = cid;
        //定时获取开奖信息
        game.qhinfo();
        $.post('/index.php/index/playedType/' + cid, function (res) {
            game.data = res.data;
            game.allCont.playid = game.data[0].id;
            var shtml = '';
            for (var i = 0; i < res.data.length; i++) {
                shtml += '<li data-num="' + game.data[i].selectNum + '" data-bonusProp="' + game.data[i].bonusProp + '" data-bonusPropBase="' + game.data[i].bonusPropBase + '" data-desc="' + game.data[i].simpleInfo + '" data-fun="' + game.data[i].betCountFun + '" id="' + game.data[i].id + '" data-groupid="' + game.data[i].groupId + '"><div class="tover">' + game.data[i].name + '</div></li>';
                if (i === 0) {
                    game.global.datainfo.num = game.data[i].selectNum;
                    game.global.datainfo.fun = game.data[i].betCountFun;
                    game.global.datainfo.bonus = game.data[i].bonusPropBase;
                }
            }
            game.renderHtml(game.allCont.playid)
            $(".select_title").html(shtml)
        }, 'json');
        //获取order
        game.getOrder();



        //选择游戏
        $(".gameo_titles").on('touchend', function () {
            $(".select_pop").show();
            var html = '';
        })
        $(document).on('touchend', '.select_title li', function () {
            game.allCont.playid = $(this).attr('id');
            game.allCont.groupid = $(this).attr('data-groupid');
            game.global.datainfo.num = $(this).attr('data-num');
            game.global.datainfo.fun = $(this).attr('data-fun');
            game.global.datainfo.bonus = $(this).attr('data-bonuspropbase');
            $(".gameo_sel").text($(this).find('div').text());
            $(".select_pop").hide();
            $(".dan_text").text('');
            game.renderHtml(game.allCont.playid);
            return false;
        })
        //清单双大小全
        var dan_len, dan_money, dan_stake;
        $('.gameo_cont').on('click', '.g_btn', function () {
            var id = $(this).data("id");
            var parent = $(this).parent(".game_stakes");
            var len = $(parent).find('i.active').length;
            switch (id) {
                case 'clear':
                    $(parent).find('i').removeClass('active');
                    break;
                case 'even':
                    $(parent).find('i').removeClass('active');
                    $(parent).find('i:even').addClass('active');
                    break;
                case 'odd':
                    $(parent).find('i').removeClass('active');
                    $(parent).find('i:odd').addClass('active');
                    break;
                case 'small':
                    $(parent).find('i').removeClass('active');
                    $(parent).find('a').prevAll().addClass('active');
                    break;
                case 'big':
                    $(parent).find('i').removeClass('active');
                    $(parent).find('a').nextAll().addClass('active');
                    break;
                case 'all':
                    $(parent).find('i').addClass('active');
                    break;
            }
            game.currentCount();
        })

        //数字选中 
        $(".gameo_cont").on('click', '.g_qiu', function () {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
            } else {
                $(this).addClass("active");
            }
            game.currentCount();
        })
        //元
        $(".gameo_check").on('touchend', function () {
            $(".gameo_check").removeClass("active");
            $(this).addClass("active");
            game.currentCount();
        })
        //加减
        $(".gameo_numc").on('touchend', function () {
            var op = $(this).data('op');
            var num = parseInt($(".gameo_numi").val());
            if (op == 'add') {
                num = num + 1;
            } else if (op == 'subtract') {
                num = num - 1;
            }
            if (num <= 0) {
                num = 1;
            }
            $(".gameo_numi").val(num);
            game.currentCount();
        })
        //倍数不能小于1
        $(".gameo_numi").on('keyup', function () {
            if ($(this).val() == 0 && $(this).val().length == 1) {
                $(this).val(1)
            } else {
                if ($.trim($(this).val())) {
                    $(this).val(Math.abs($(this).val()))
                    game.currentCount();
                }
            }

        })
        //倍数不能小于1
        $(".gameo_numi").on('blur', function () {
            if ($(this).val() == 0) {
                $(this).val(1)
            } else {
                $(this).val(Math.abs($(this).val()))
            }
            game.currentCount();
        })
        //添加
        $(".game_add").on('touchend', function () {
            if ($(".gameo_numi").val() == 0) {
                $(".gameo_numi").val(1)
            }
            if (!game.currentCount()) {
                return false;
            } else {
                var flag = $.parseJSON($.ajax('/index.php/game/checkBuy', {async: false}).responseText);
                if (flag.data) {
                    $(".hint_pop .hint_cont").text('暂停销售');
                    $(".hint_pop").show();
                    return false;
                }
                var list = {};

                var mode = $(".gameo_check.active").data('money');
                var multiple = $(".gameo_multiple").val();
                list.fanDian = game.betInfo.fandian;
                list.bonusProp = game.global.datainfo.bonus;
                list.mode = parseFloat($(".gameo_check.active").data('money') || 1);
                list.beiShu = multiple;
                list.orderId = (new Date()) - 2147483647 * 623;
                list.actionData = game.betInfo.data;
                list.actionNum = game.betInfo.num;
                list.weiShu = 0; //不确定；
                list.playedGroup = game.allCont.groupid
                list.playedId = game.allCont.playid;
                list.type = cid;
                list.del_id = game.del_id;
                game.del_id++;

                list.money = game.betInfo.money;
                game.code.push(list);
                $(".game_stakes").find('i').removeClass('active');
                //添加的html


                list.title = $(".gameo_sel").text();
                var html = '';
                html += '        <tr>'
                html += '            <td>' + list.title + '</td>'
                html += '            <td class="tdover">' + list.actionData + '</td>'
                html += '            <td>' + list.actionNum + '注</td>'
                html += '            <td>' + list.beiShu + '倍</td>'
                html += '            <td>' + list.money + '元</td>'
                html += '            <td>奖－返：' + parseFloat(game.global.datainfo.bonus).toFixed(2) + '-' + parseFloat(game.betInfo.fandian).toFixed(1) + '%</td>'
                html += '            <td class="iconfont icon-icon-cross-squre gameo_delete"  data-del=' + list.del_id + ' data-money=' + list.money + ' data-stake=' + list.actionNum + '></td>'
                html += '        </tr>'
                $(".game_tzlist table").append(html);
                game.allCont.all_money += Number(list.money);
                game.allCont.all_stake += Number(list.actionNum);
                game.beiyong.all_money = game.allCont.all_money;
                game.beiyong.all_stake = game.allCont.all_stake;
                $(".all_money").text(game.allCont.all_money.toFixed(2));
                $(".all_stake").text(game.allCont.all_stake)
                $(".gameo_int").val('');
                $(".dan_text").text('');
            }
            ;

        })
        //删除
        $(document).on('click', '.gameo_delete', function () {
            var id = parseInt($(this).attr('data-del'));
            $(this).parents('tr').remove();
            var money = $(this).attr('data-money');
            var stake = $(this).attr('data-stake');
            game.allCont.all_money = game.allCont.all_money - Number(money);
            game.allCont.all_stake = game.allCont.all_stake - Number(stake);
            $(".all_money").text(game.allCont.all_money.toFixed(2));
            $(".all_stake").text(game.allCont.all_stake);
            for (var i = 0; i < game.code.length; i++) {
                if (game.code[i].del_id == id) {
                    console.log(game.code.splice(i, 1));
                }
            }
            console.log(game.code, id);
        })
        //清空号码
        $(".gameo_clearall").on('touchend', function () {
            game.code = [];
            game.allCont.all_stake = 0;
            game.allCont.all_money = 0;
            $(".game_tzlist table").html('');
            $(".all_money").text(game.allCont.all_money.toFixed(2));
            $(".all_stake").text(game.allCont.all_stake);
            $(".dan_text").text('');
        })
        //确认是否投注
        $(".gameo_btns2").on('touchend', function () {
            if (game.global.fengpan) {
                $(".hint_pop .hint_cont").text('第' + game.allCont.actionNo + '期投注已截止!');
                $(".hint_pop").show();
                return false;
            }
            if ($('#wjdl'))
            {
                if (parseInt($('#wjdl').val()) > 0) {
                    $(".hint_pop .hint_cont").text('代理不能买单');
                    $(".hint_pop").show();
                    return false;
                }
            }
            if ($(".game_tzlist table tr").length > 0) {
                $(".tz_pop").show();

                //确认是否投注html
                $(".tz_title").text(game.allCont.actionNo);
                var is_html = '';
                var list = game.code;
                for (var i = 0; i < list.length; i++) {
                    var mode_name = '';
                    if (list[i].mode < 1) {
                        mode_name = '角';
                    } else {
                        mode_name = '元';
                    }
                    is_html += '        <tr>'
                    is_html += '            <td>' + list[i].title + '</td>'
                    is_html += '            <td class="tdover">' + list[i].actionData + '</td>'
                    is_html += '            <td>' + list[i].actionNum + '</td>'
                    is_html += '            <td>' + list[i].beiShu + '倍</td>'
                    is_html += '            <td>' + mode_name + '</td>'
                    is_html += '        </tr>'
                }
                $(".tz_table table tbody").html(is_html);
            } else {
                $(".hint_pop .hint_cont").text('您还未添加预投注');
                $(".hint_pop").show();
                return false;
            }
        })
        $(".gameo_btns1").click(function () {
            if ($(".game_tzlist table tr").length > 0) {
                if ($(".game_tzlist table tr").length < 2) {
                    $(".zhui_pop").show();
                    game.getZhuihao();
                } else {
                    $(".hint_pop .hint_cont").text('只能对一种方案追号');
                    $(".hint_pop").show();
                }

            } else {
                $(".hint_pop .hint_cont").text('您还未添加预投注');
                $(".hint_pop").show();
            }
            return false;

        });
        //取消追号
        $(".zhui_close").click(function () {
            $(".zhui_table table").find('input:checkbox').prop('checked', false);
            game.allCont.all_stake = game.beiyong.all_stake;
            game.allCont.all_money = game.beiyong.all_money;
            $(".all_money").text(game.allCont.all_money.toFixed(2));
            $(".all_stake").text(game.allCont.all_stake);
            game.zhuihao = '';
            game.allCont.zhuiHaoMode = '';
            $("zhui_qs").text('0');
            $(".zhui_amount").text('0');
            $(".zhui_pop").hide();
            return false;
        });
        //全选
        $(document).on('click', '.zhui_all', function () {
            $(".zhui_table table").find('input:checkbox').prop('checked', true)
            game.dealZhuihao();
        })
        //单个点击
        $(document).on('click', '.zhui_table tbody :checkbox', function () {
            game.dealZhuihao();
        })
        //反选
        $(document).on('click', '.zhui_fan', function () {
            $('.zhui_table tbody :checkbox').each(function () {
                this.checked = !this.checked;
                $(this).prop('checked', this.checked)
            });
            $('.zhui_table thead :checkbox').prop('checked', false);
            game.dealZhuihao();
        })
        //全/反选
        $(document).on('click', '.zhui_allfan', function () {
            $('.zhui_table tbody :checkbox').prop('checked', this.checked);
            game.dealZhuihao();
        })
        //填写倍数
        $(document).on('blur', '.beishu', function () {
            var val = parseInt($(this).val());
            var mode = parseFloat($(".gameo_check.active").data('money') || 1)
            $(this).parents('tr').find('.amount').text(parseFloat(val * game.betInfo.money).toFixed(2));
            game.dealZhuihao();
        })
        //确定追号
        $(document).on('click', '.zhui_sure', function () {
            $(".zhui_pop").hide();
            game.is_zhui = true;
            if ($('.zhuicheck1').is(':checked')) {
                game.allCont.zhuiHaoMode = $(".zhuicheck1").val();
            } else {
                game.allCont.zhuiHaoMode = 0;
            }
            game.beiyong.all_stake = game.allCont.all_stake;
            game.beiyong.all_money = game.allCont.all_money;
            game.allCont.all_stake = Number($(".zhui_qs").text() * game.betInfo.num);
            game.allCont.all_money = Number($(".zhui_amount").text());
            $(".all_money").text(game.allCont.all_money.toFixed(2));
            $(".all_stake").text(game.allCont.all_stake);

        })
        $(".hint_btn").on('touchend', function () {
            $(".hint_pop .hint_title").text('错误提示');
            $(".hint_pop").hide();
            return false;
        })
        $(".hint_btn2").on('touchend', function () {
            $(".hint_pop1").hide();
            game.code = [];
            game.allCont.all_stake = 0;
            game.allCont.all_money = 0;
            $(".game_tzlist table").html('');
            $(".all_money").text(game.allCont.all_money.toFixed(2));
            $(".all_stake").text(game.allCont.all_stake);
            $(".dan_text").text('');
            return false;
        })
        $(".hint_btn3").on('touchend', function () {
            $(".hint_pop1").hide();
            return false;
        })
        //提交
        $(".tz_btn1").on('touchend', function () {
            $(".hint_pop").hide();
            $(".tz_pop").hide();

            if (game.global.fengpan) {
                $(".hint_pop .hint_cont").text('第' + game.allCont.actionNo + '期投注已截止!');
                $(".hint_pop").show();
                return false;
            }
            $.post('/index.php/game/getNo/' + cid, function (data) {
                if (!data.code) {

                    game.allCont.actionNo = data.data.actionNo.actionNo;
                    game.allCont.kjTime = data.data.actionNo.actionTime;
                    $.post('/index.php/game/postCode', {code: game.code, para: game.allCont, zhuiHao: game.zhuihao}, function (res) {
                        if (!res.code) {
                            game.getOrder();
                            game.code = [];
                            game.allCont.all_stake = 0;
                            game.allCont.all_money = 0;
                            $(".game_tzlist table").html('');
                            $(".all_money").text(game.allCont.all_money.toFixed(2));
                            $(".all_stake").text(game.allCont.all_stake);
                            $(".hint_pop .hint_title").text('系统提示');
                            $(".hint_pop .hint_cont").text(res.msg);
                            $(".hint_pop").show();
                            //清除追号；
                            game.zhuihao = '';
                            game.allCont.zhuiHaoMode = '';
                            $("zhui_qs").text('0');
                            $(".zhui_amount").text('0');
                        } else {
                            $(".hint_pop .hint_cont").text(res.msg);
                            $(".hint_pop").show();
                        }
                    }, 'json');
                    $(".gameo_multiple").val('1')
                } else {
                    $(".hint_pop .hint_cont").text(data.msg);
                    $(".hint_pop").show();
                }


            }, 'json');
            return false;
        })
        //撤单
        $('table').on('click', 'td.prize_col', function () {
            var r = confirm("确定撤单么?");
            if (r == true) {
                var id = $(this).attr('id');
                $.post('/index.php/game/deleteCode/' + id, function (data) {
                    if (!data.code) {
                        $(".hint_pop .hint_title").text('提示');
                        $(".hint_pop .hint_cont").text('撤单成功');
                        $(".hint_pop").show();
                    } else {
                        $(".hint_pop .hint_cont").text(data.msg);
                        $(".hint_pop").show();
                    }
                    game.getOrder();
                }, 'json');
            }

            return false;
        })

        $(".tz_btn2").on('touchend', function () {
            $(".tz_pop").hide();
        })
        //只能是数字
        $(document).on('keyup', '.gameo_int', function () {
            $(this).val().replace(/[^\d]/g, '');
            game.currentCount();
        })
    },
    renderHtml: function (id) {
        var narr = [];
        for (var i = 0; i < game.data.length; i++) {
            if (game.data[i].id == id) {
                game.allCont.groupid = game.data[i].groupId;
                $(".gameo_sel").text(game.data[i].name)
                $(".gameo_tips").text("说明：" + game.data[i].simpleInfo)

                narr = game.data[i].position;
                game.all_len = game.data[i].position;
                var html = ''
                if (game.all_len.length == 1 && game.all_len[0] == '1') {
                    html = '<li><input class="gameo_int" placeholder="输入至少1个两位位数号码组成一注" type="tel"></li>';
                } else if (game.all_len.length == 1 && game.all_len[0] == '2') {
                    html = '<li><input class="gameo_int" placeholder="输入至少1个三位位数号码组成一注" type="tel"></li>';
                } else {
                    for (var j = 0; j < narr.length; j++) {
                        if (narr[j] == 3 || narr[j] == 4 || narr[j] == 5) {
                            var tips = '选择';
                        } else {
                            var tips = narr[j]
                        }
                        html += '    <li class="game_stakes rel" >'
                        html += '        <i class="g_qiu">0</i>'
                        html += '        <i class="g_qiu">1</i>'
                        html += '        <i class="g_qiu">2</i>'
                        html += '        <i class="g_qiu">3</i>'
                        html += '        <i class="g_qiu">4</i>'
                        html += '        <a class="game_sposl">' + tips + '</a>'
                        html += '        <i class="g_qiu">5</i>'
                        html += '        <i class="g_qiu">6</i>'
                        html += '        <i class="g_qiu">7</i><br>'
                        html += '        <i class="g_qiu">8</i>'
                        html += '        <i class="g_qiu">9</i>'
                        html += '        <span class="g_btn" data-id="clear">清</span>'
                        html += '        <span class="g_btn" data-id="even">双</span>'
                        html += '        <span class="g_btn" data-id="odd">单</span>'
                        html += '        <span class="g_btn" data-id="small">小</span>'
                        html += '        <span class="g_btn" data-id="big">大</span>'
                        html += '        <span class="g_btn" data-id="all">全</span>'
                        html += '    </li>'
                    }
                }
                $(".gameo_cont").html(html)
            }
        }
    },
    currentCount: function () {

        calcFun = game.global.datainfo.fun;
        if (calcFun && (calcFun = window[game.global.namespace][calcFun]) && (typeof calcFun == 'function')) {
            try {
                var obj = calcFun.call();
                var dan_multiple = $(".gameo_multiple").val();
                var dan_money = $(".gameo_check.active").attr('data-money');
                var dan_allmoney = (dan_money * obj.actionNum * dan_multiple).toFixed(2);
                $(".dan_text").text('共' + obj.actionNum + '注，金额' + dan_allmoney + '元');
                game.betInfo.num = obj.actionNum;
                game.betInfo.data = obj.actionData;
                game.betInfo.money = dan_allmoney;
                return true;
            } catch (err) {
                $(".dan_text").text(err);
                return false;
            }
        } else {
            return false;
        }
    },
    countdown: function (times, kjtime, kjftime) { //倒计时


        game.global.counttimer = setInterval(function () {
            var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
            if (times > 0) {
                day = Math.floor(times / (60 * 60 * 24));
                hour = Math.floor(times / (60 * 60)) - (day * 24);
                minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }

            $(".gameo_second").text(game.checkTime(second));
            $(".gameo_minute").text(game.checkTime(minute));
            if (hour > 0) {
                $(".gameo_hour").text(game.checkTime(hour));
            }
            if (day > 0) {
                $(".gameo_day").text(game.checkTime(day));
            }
            if (times == 5) {
                $(".kaijiang")[0].play();
            }
            if ($('.gameo_num').is(":hidden")) {
                game.global.fengpan = false;
                $('.gameo_ftips').hide();
                $('.gameo_num').show();
            }
            if (times < 0) {
                clearInterval(game.global.counttimer);
                $(".kaijiang")[0].pause();
                $(".hint_pop1 .hint_titles").text('第' + game.allCont.actionNo + '期投注已截止!');
                $(".hint_pop1 .hint_cont").text('清空预投注内容请点击"确定"，不刷新页面请点击"取消"。');
                $(".hint_pop1").show();
                $(".hint_pop").hide();
                $(".tz_pop").hide();
                $('.gameo_ftips').show();
                $('.gameo_num').hide();
                game.global.fengpan = true;
                $(".gameo_qi").text(game.allCont.actionNo);
                game.fengpancount(parseInt(kjftime), 1);
                return false;
            }
            if (kjtime > 0) {
                clearInterval(game.global.counttimer);
                $(".kaijiang")[0].pause();
                $(".hint_pop1 .hint_titles").text('第' + game.global.lastactionNo + '期投注已截止!');
                $(".hint_pop1 .hint_cont").text('清空预投注内容请点击"确定"，不刷新页面请点击"取消"。');
                $(".hint_pop1").show();
                $(".hint_pop").hide();
                $(".tz_pop").hide();
                $('.gameo_ftips').show();
                $('.gameo_num').hide();
                game.global.fengpan = true;
                $(".gameo_second").text('00');
                $(".gameo_minute").text('00');
                $(".gameo_hour").text('00');
                $(".gameo_qi").text(game.global.lastactionNo);
                game.fengpancount(parseInt(kjtime), 0);

            }
            times--;
        }, 1000);
    },
    fengpancount: function (times, flag) { //倒计时

        game.global.fengpantimer = setInterval(function () {
            var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
            if (times > 0) {
                day = Math.floor(times / (60 * 60 * 24));
                hour = Math.floor(times / (60 * 60)) - (day * 24);
                minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }

            var qishu = flag ? game.allCont.actionNo : game.global.lastactionNo;
            var text = "距" + qishu + "期封盘结束还有" + game.checkTime(hour) + "时" + game.checkTime(minute) + "分" + game.checkTime(second) + "秒";
            $(".gameo_ftips >span").text(text);
            if (times < 0) {
                clearInterval(game.global.fengpantimer);
                $('.gameo_ftips').hide();
                $('.gameo_num').show();
                game.global.fengpan = false;
                if (flag) {
                    game.qhinfo();
                    $(".gameo_stitle .gameo_qi").text(game.allCont.actionNo);

                } else {
                    game.countdown(game.global.ttime, 0, 0)
                    game.kjinfo();
                    $(".gameo_stitle .gameo_qi").text(game.allCont.actionNo);
                }

            }

            times--;
        }, 1000);
    },
    checkTime: function (i) { //将0-9的数字前面加上0，例1变为01 
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    },
    kjinfo: function () {
        var kjtimer = null;
        if (!game.global.kjtimer) {
            kjtimer = setInterval(function () {
                //默认期号
                $.post('/index.php/game/getkjinfo/' + game.global.cid, function (data) {
                    if (!data.code) {
                        if (data.data.kjNo) {
                            clearInterval(game.global.gametimer);
                            $(".gameo_num").html(data.data.kjNo);
                            game.is_false = false;
                            game.global.kjtimer = false;
                            clearInterval(kjtimer);
                            game.getOrder();
                            game.getYk();
                        } else {
                            if (!game.is_false) {
                                game.global.gametimer = setInterval(function () {
                                    for (var i = 0; i < $(".gameo_num span").length; i++) {
                                        $(".gameo_num span").eq(i).text(game.randomNum())
                                    }
                                }, 50)
                                game.is_false = true;

                            }
                        }
                    } else {
                        $(".hint_pop .hint_cont").text(data.msg);
                        $(".hint_pop").show();
                    }
                }, 'json');

            }, 3000);
            game.global.kjtimer = true;
        }
    },
    qhinfo: function () {

        //默认期号
        $.post('/index.php/game/getqhinfo/' + game.global.cid, function (data) {
            if (!data.code) {
                $(".gameo_qi").text(data.data.actionNo.actionNo);
                $(".gameo_toptitle .gameo_qi").text(data.data.lastNo.actionNo);
                $(".gameo_qiall").text(data.data.num);
                game.allCont.actionNo = data.data.actionNo.actionNo;
                game.global.lastactionNo = data.data.lastNo.actionNo;
                game.global.ttime = data.data.actionNo.difftime - data.data.actionNo.diffKTime;
                //倒计时
                game.countdown(data.data.actionNo.difftime, data.data.actionNo.diffKTime, data.data.actionNo.diffFTime);
                if (!data.data.kjNo) {

                    if (!game.is_false) {
                        game.global.gametimer = setInterval(function () {
                            for (var i = 0; i < $(".gameo_num span").length; i++) {
                                $(".gameo_num span").eq(i).text(game.randomNum())
                            }
                        }, 50)
                        game.kjinfo();
                        game.is_false = true;

                    }
                } else {
                    $(".gameo_num").html(data.data.kjNo);
                }
            } else {
                $(".hint_pop .hint_cont").text(data.msg);
                $(".hint_pop").show();
            }
        }, 'json');
    },
    getOrder: function () {
        //默认底部数据
        $.post('/index.php/game/getOrdered/' + game.global.cid, function (data) {
            if (!data.code) {
                var list = data.data;
                var html = '';
                var text = '';
                var prize_col = '';
                for (var i = 0; i < list.length; i++) {
                    if (list[i].status == 1) {
                        text = '已撤单';
                        prize_col = '';
                    } else if (list[i].status == 2) {
                        text = '未开奖';
                        prize_col = 'prize_green';
                    } else if (list[i].status == 3) {
                        text = '中奖';
                        prize_col = 'prize_win';
                    } else if (list[i].status == 4) {
                        text = '未中奖';
                        prize_col = '';
                    } else if (list[i].status == 5) {
                        text = '撤单';
                        prize_col = 'prize_col';
                    }
                    html += '    <tr>'
                    html += '        <td data-id="' + list[i].id + '" class="orderdetail" >' + list[i].wjorderId + '</td>'
                    html += '        <td>' + list[i].gamename + '</td>'
                    html += '        <td>' + list[i].playname + '</td>'
                    html += '        <td>' + list[i].actionNo + '</td>'
                    html += '        <td>' + list[i].money + '</td>'
                    html += '        <td id="' + list[i].id + '" class="' + prize_col + '">' + text + '</td>'
                    html += '    </tr>'
                }
                $(".gameo_list tbody").html(html);
            } else {
                $(".hint_pop .hint_cont").text(data.msg);
                $(".hint_pop").show();
            }
        }, 'json');
    },
    randomNum: function () {
        return(Math.floor(Math.random() * 9))
    },

    /* 组合算法*/
    C: function (arr, num) {
        var r = [];
        (function f(t, a, n) {
            if (n == 0)
                return r.push(t);
            for (var i = 0, l = a.length; i <= l - n; i++) {
                f(t.concat(a[i]), a.slice(i + 1), n - 1);
            }
        })([], arr, num);
        return r;
    },
    /* 排列算法*/
    A: function (arr, num) {
        var r = [];
        (function f(t, a, n) {
            if (n == 0)
                return r.push(t);
            for (var i = 0, l = a.length; i < l; i++) {
                f(t.concat(a[i]), a.slice(0, i).concat(a.slice(i + 1)), n - 1);
            }
        })([], arr, num);
        return r;
    },
    getZhuihao: function () {
        var mode = game.betInfo.money;
        $('.tr-cont').load('/index.php/index/zhuiHaoQs/' + game.global.cid + '/' + mode + '/10');
        $('.zhui_top').find('select:first').change(function () {
            $('.tr-cont').load('/index.php/index/zhuiHaoQs/' + game.global.cid + '/' + mode + '/' + $(this).val());
            $('.zhui_table thead :checkbox').prop('checked', false);
        });
    },
    windowInit: function () {

        window[game.global.namespace].sscqzh3xfs = function  sscqzh3xfs() {
            var code = [], len = 1, codeLen = parseInt(game.global.datainfo.num), delimiter = "";
            if ($(".game_stakes").has('.active').length != codeLen) {
                throw('请选' + game.global.datainfo.num + '位数字');
            }
            $(".game_stakes").each(function (i) {
                var $code = $('i.active', this);
                if ($code.length == 0) {
                    code[i] = '-';
                } else {
                    len *= $code.length;
                    code[i] = [];
                    $code.each(function () {
                        code[i].push(this.innerText);
                    });
                    code[i] = code[i].join(delimiter);
                }
            });
            return {actionData: code.join(','), actionNum: len};
        }
        window[game.global.namespace].qzh3ds = function  qzh3ds() {
            var codeLen = parseInt(game.global.datainfo.num),
                    codes = [],
                    str = $('.gameo_int').val().replace(/[^\d]/g, '');
            if (str.length && str.length % codeLen == 0) {
                if (/[^\d]/.test(str))
                    throw('投注有错，不能有数字以外的字符。');
                codes = codes.concat(str.match(new RegExp('\\d{' + codeLen + '}', 'g')));
            } else {
                throw('输入号码不正确');
            }
            codes = codes.map(function (code) {
                return code.split("").join(',')
            });
            return {actionData: codes.join('|'), actionNum: codes.length}
        }
        window[game.global.namespace].rx3z3 = function rx3z3() {
            var codeLen = parseInt(game.global.datainfo.num),
                    codes = ''
            $select = $("i.active"),
                    len = 1;
            if ($select.length < codeLen)
                throw('请选' + codeLen + '位数');
            $select.each(function () {
                codes += this.innerText;
            });
            len = game.A(codes.split(""), codeLen).length;
            return {actionData: codes, actionNum: len};
        }
        window[game.global.namespace].rx3z6 = function rx3z6() {
            var codeLen = parseInt(game.global.datainfo.num),
                    codes = ''
            $select = $("i.active"),
                    len = 1;
            if ($select.length < codeLen)
                throw('请选' + codeLen + '位数');
            $select.each(function () {
                codes += this.innerText;
            });
            len = game.C(codes.split(""), codeLen).length;
            return {actionData: codes, actionNum: len};
        }
        window[game.global.namespace].sscqh2xfs = function sscqh2xfs() {
            var obj = window[game.global.namespace].sscqzh3xfs.call();
            return obj;
        }
        window[game.global.namespace].qh2ds = function qh2ds() {
            var obj = window[game.global.namespace].qzh3ds.call();
            return obj;
        }
        window[game.global.namespace].z2 = function z2() {
            var obj = window[game.global.namespace].rx3z6.call();
            return obj;
        }
        window[game.global.namespace].ssc5xdwd = function ssc5xdwd() {
            var code = [], len = 0, delimiter = "";
            $(".game_stakes").each(function (i) {
                var $code = $('i.active', this);
                if ($code.length == 0) {
                    code[i] = '-';
                } else {
                    len += $code.length;
                    code[i] = [];
                    $code.each(function () {
                        code[i].push(this.innerText);
                    });
                    code[i] = code[i].join(delimiter);
                }
            });
            if (!len)
                throw('至少选一个号码');
            return {actionData: code.join(','), actionNum: len};
        }
        window[game.global.namespace].sscqzhr31m = function sscqzhr31m() {
            var obj = window[game.global.namespace].ssc5xdwd.call();
            return obj;
        }


    },
    dealh5inback: function () {
        var hiddenProperty = 'hidden' in document ? 'hidden' :
                'webkitHidden' in document ? 'webkitHidden' :
                'mozHidden' in document ? 'mozHidden' :
                null;
        var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
        var onVisibilityChange = function () {

            if (!document[hiddenProperty]) {
                //window.location.href = location.href;
                if (game.global.fengpantimer)
                    clearInterval(game.global.fengpantimer);
                if (game.global.counttimer)
                    clearInterval(game.global.counttimer);
                game.qhinfo();
            } else {
                if (game.global.fengpantimer)
                    clearInterval(game.global.fengpantimer);
                if (game.global.counttimer)
                    clearInterval(game.global.counttimer);
            }
        }
        document.addEventListener(visibilityChangeEvent, onVisibilityChange);
    },
    dealZhuihao: function () {


        $('.zhui_table tbody :checkbox').each(function () {
            var d = [];
            var s = null;
            var n = 0;
            $('.zhui_table tbody :checkbox').each(function (index, item) {
                if (this.checked) {
                    s += Number($(this).parent("td").siblings("td").find('.amount').text());
                    n = n + 1;
                    var value = $(this).parent("td").siblings(".qqh").text() + "|" + $(this).parent("td").siblings("td").find('.beishu').val() + "|" + $(this).parent("td").siblings(".qqt").text()
                    d.push(value);
                }
            });
            game.zhuihao = d.join(";");
            $(".zhui_qs").text(n);
            if (s) {
                $(".zhui_amount").text(parseFloat(s).toFixed(2));
            } else {
                $(".zhui_amount").text('0')
            }
        });

    },
    getYk: function () {
        var kjtimery = null;
        if (!game.global.kjtimeryk) {
            kjtimery = setInterval(function () {
                $.post('/index.php/Tip/getYKTip/' + game.allCont.type + '/' + game.global.lastactionNo, function (res) {
                    if (res.data.flag) {
                        clearInterval(kjtimery);
                        game.global.kjtimeryk = false;
                        if (res.data.message) {
                            $(".hint_pop .hint_cont").html(res.data.message);
                            $(".hint_pop .hint_title").text("系统提示");
                            $(".hint_pop").show();
                        }
                    }
                }, 'json');
            }, 1000);
            game.global.kjtimeryk = true;
        }
    }

}
game.init();
