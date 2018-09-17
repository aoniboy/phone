<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title><?= $this->pageTitle ?></title>
        <link rel="stylesheet" type="text/css" href="/wjinc/default/css/style.css<?= $this->sversion ?>">
        <link rel="stylesheet" type="text/css" href="/wjinc/default/css/font.css<?= $this->sversion ?>">
        <script src="/wjinc/default/js/jquery.min.js<?= $this->sversion ?>"></script>
        <script type="text/javascript" src="/skin/js/jqueryui/jquery-ui-1.8.23.custom.min.js<?= $this->sversion ?>"></script>
        <link type="text/css" rel="stylesheet" href="/skin/js/jqueryui/skin/smoothness/jquery-ui-1.8.21.custom.css<?= $this->sversion ?>" />

    </head>
    <body class="body">
        <input class="f_name" type="hidden" value="<?= $this->user['nickname'] ?>">
        <input class="f_uid" type="hidden" value="<?= $this->user['uid'] ?>">
        <input class="f_type" type="hidden" value="<?= $this->ftype ?>">
        <div class="title_top tc" style="position: fixed;width:100%;">
            <a href="javascript:history.back(-1)" class="iconfont icon-xiangzuojiantou iconback"></a>
            <span class="iconfont icon-jilu iconright" style="right: .8rem"></span>
            <span class="iconfont icon-gantanhao iconright"></span>
            <span class="gameo_titles"><?= $this->pageTitle ?><br></span>
        </div>
        <div class="hint_pop hide">
            <div class="gameo_mask" style="z-index:999"></div>
            <div class="hint_con">
                <div class="hint_title f32 tc hint_titles">错误提示</div>
                <div class="hint_cont f24"></div>
                <div class="tc hint_btn f32">确定</div>
            </div>
        </div>

        <div class="hint_pop1 hide">
            <div class="gameo_mask"></div>
            <div class="hint_con">
                <div class="hint_title f32 tc hint_titles">系统提示</div>
                <div class="hint_cont f24"></div>
                <div class="tc hint_btn1 f32">
                    <div class="tc hint_btn2">确定</div>
                    <div class="tc hint_btn3">取消</div>
                </div>
            </div>
        </div>
        <div class="wrap_box newdh">
            <div class="topfix">
                <div class="top dx tc">
                    <div class="fx top_bor">
                        <p class="col666">距离<sapn class="info_currqishu"><?= $this->info28['number'] ?></sapn>期截止</p>
                        <div class="col_red f34 info_time"><span class="gameo_hour hide">00</span> <span class="gameo_hour_text hide">时</span> <span class="gameo_minute"></span>分<span class="gameo_second"></span>秒</div>
                        <div class="col_red f34 info_fengpan hide">已封盘</div>
                        <div class="col_red f34 info_kaijiang hide">开奖中</div>
                    </div>
                    <div class="fx">
                        <p class="col666">余额</p>
                        <div class="col_red f34 info_money"><?= $this->user['coin'] ?>元</div>
                    </div>
                </div>
                <ul class="toplist">

                </ul>

            </div>
            <div class="top_padding">
                <ul class="d_box">

                    <li class="d_center">
                        <div class="f30 d_text2 "><span class="col_red info_qishu" >[<?= $this->info28['number'] ?>期]</span>单注<span class="col_red">2元</span>起，<span class="col_red">20000元</span>封顶，总注<span class="col_red">3000000元</span>封顶<br><span class="col_red">★★现状可以开始投注★★</span></div>
                    </li>
                    <li class="d_center">
                        <div class="f30 d_text2 ">聊天窗口已激活，现支持显示他人投注</div>
                    </li>

                </ul>

                <div class="top_text">


                </div>
            </div>
            <div class="tc fff tz_bg"><div class="tz_btns tc">投注</div></div>
            <div class="pop_wrap hide">
                <div class="mask"></div>
                <div class="pop_box ">
                    <div class="tc wf_pos">
                        <span class=" wf_n f30">大小单双</span>
                        <span class=" wf_n f30 hide">猜数字</span>
                        <span class=" wf_n f30 hide">特殊玩法</span>
                        <span class="iconfont icon-sanjiaoleft wf_btn1  wf_btn col_red" data-add="jian"></span>
                        <span class="iconfont icon-sanjiaoright wf_btn2 wf_btn col_red" data-add="jia"></span>
                        <input type="hidden" class="data_index" value="0">
                    </div>
                    <ul class="wf_cont">
                        <li class="wf_cont1">
                            <div class="col999 tc f24">中奖和值：<span class="zj_tips">14 15 16 17 18 19 20 21 22 23 24 25 26 27</span></div>
                            <div class="wf_zhi">
                                <ul class="wf_zhi1 clearfix" style="height: 2.08rem">
                                    <?php
                                    if ($this->result)
                                        foreach ($this->result[101] as $key => $var) {
                                            ?>
                                            <li class="tc fl">
                                                <div class="wf_z <?= $key == 0 ? "active" : "" ?>">
                                                    <div class="c_title c_lineh" data-title="<?= $var['name'] ?>"><?= $var['name'] ?></div>
                                                    <div class="col_red c_lineh c_val" data-index="wf_cont1" data-id="<?= $var['id'] ?>" data-groupid="<?= $var['groupId'] ?>" data-info="<?= $var['numinfo'] ?>" data-value="<?= $var['money'] ?>"><?= $var['money'] ?></div>
                                                </div>
                                            </li>
                                        <?php } ?>

                                </ul>
                            </div>	
                        </li>
                        <li class="wf_cont2 hide">
                            <div class="col999 tc f24">中奖号码：<span class="zj_tips">0</span></div>
                            <div class="wf_zhi">
                                <ul class="wf_zhi1 clearfix" style="height: 2.08rem; overflow-y: scroll;">

                                    <?php
                                    if ($this->result)
                                        foreach ($this->result[102] as $key => $var) {
                                            ?>
                                            <li class="tc fl">
                                                <div class="wf_z <?= $key == 0 ? "active" : "" ?>">
                                                    <div class="c_title c_lineh" data-title="<?= $var['name'] ?>"><?= $var['name'] ?></div>
                                                    <div class="col_red c_val c_lineh" data-index="wf_cont2" data-id="<?= $var['id'] ?>" data-groupid="<?= $var['groupId'] ?>" data-info="<?= $var['numinfo'] ?>" data-value="<?= $var['money'] ?>"><?= $var['money'] ?></div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                </ul>
                            </div>	
                        </li>
                        <li class="wf_cont3 hide">
                            <div class="col999 tc f24 ">中奖和值：<span class="zj_tips">3 6 9 12 15 18 21 24</span></div>
                            <div class="wf_zhi">
                                <ul class="wf_zhi1 wf_zhi2 clearfix" style="height: 2.08rem;">
                                    <?php
                                    if ($this->result)
                                        foreach ($this->result[103] as $key => $var) {
                                            ?>
                                            <li class="tc fl">
                                                <div class="wf_z <?= $key == 0 ? "active" : "" ?>">
                                                    <div class="c_title c_lineh" data-title="<?= $var['name'] ?>"><?= $var['name'] ?></div>
                                                    <div class="col_red c_val c_lineh" data-index="wf_cont3" data-id="<?= $var['id'] ?>" data-groupid="<?= $var['groupId'] ?>" data-info="<?= $var['numinfo'] ?>" data-value="<?= $var['money'] ?>"><?= $var['money'] ?></div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    <li class="tc fl">
                                        <div class="">
                                            <div class="c_title c_lineh">&nbsp</div>
                                            <div class="col_red c_val c_lineh"  >&nbsp</div>
                                        </div>
                                    </li> 

                                </ul>
                            </div>	
                        </li>
                    </ul>
                    <form class="form">
                        <input type="hidden" class="f_number" name="number" value="2309331">
                        <input type="hidden" class="f_title" name="name" value="">
                        <input type="hidden" class="f_val" name="val" value="">
                        <input type="hidden" class="f_dan" name="beishu" value="1">
                        <div class="pos_bs clearfix f30">
                            <div class="fl">倍数</div>
                            <div class="fl pos_b1">
                                <span class="fl iconfont icon-jianhao f36 col999 js_jia" data-value="jian"></span>
                                <input class="fl col666 cp_input f_input f_beishu" type="tel" name="beishu" value="1">
                                <span class="fl iconfont icon-untitled44 f36 col999 js_jia" data-value="jia"></span>
                            </div>
                            <div class="sure_btn fr tc fff">确认投注</div>
                        </div>
                    </form>
                </div>
            </div>
            <style>
                .hi_pop{ position: fixed;left:0;top:0;width:100%; height:100%; }
                .hi_mask{position: fixed;left:0;top:0;width:100%; height:100%; background: rgba(0,0,0,0.5); }
                .hi_t{ position: fixed;left:50%;top:50%;width:80%;transform: translate(-50%,-50%); background:#e9e9e9; border-radius: .2rem; padding:.2rem 0; }
                .hi_msg{ padding:.2rem 0; }
                .hi_btn{  color:#0079fe;border-top:1px solid #eee; padding:.2rem 0 0 0; }
                .c_lineh{ line-height: .4rem; height: .4rem; }
                .go_box{ position: fixed;left:50%;top:50%;transform: translate(-50%,-50%); background: rgba(0,0,0,0.5); }
                .ddsf{max-height: 50px; height: 50px; overflow-y: scroll}
                .go_title{ display: flex }
                .go_title span{ flex: 1;text-align: center; }
                .gameo_list li{ display: flex; }
                .go_title li span{ flex: 1 }
            </style>
            <div class="hi_pop hide">
                <div class="hi_mask"></div>
                <div class="hi_t">
                    <div class="tc f30">提示</div>
                    <div class="hi_msg tc f24">请填写投注金额</div>
                    <div class="hi_btn tc">确定</div>
                </div>
            </div>
        </div>
        <div class="go_box">
            <div class="go_title">
                    <span>单号</span>
                    <span>彩种</span>
                    <span>玩法</span>
                    <span>期号</span>
                    <span>金额</span>
                    <span>操作</span> 
            </div>
            <ul class="gameo_list">
                <li>
                    <span></span>
                </li>
            </ul>
        </div>
        <div class="fandian-k" style="display: none"> <span class="spn8">奖金/返点：</span>
            <div class="fandian-box">
                <input type="button" class="min" value="" step="-0.1"/>
                <div id="slider" class="slider" value="<?= $this->ifs($_COOKIE['fanDian'], 0) ?>" data-bet-count="<?= $this->settings['betMaxCount'] ?>" data-bet-zj-amount="<?= $this->settings['betMaxZjAmount'] ?>" max="<?= $this->user['fanDian'] ?>" game-fan-dian="<?= $this->settings['fanDianMax'] ?>" fan-dian="<?= $this->user['fanDian'] ?>" game-fan-dian-bdw="<?= $this->settings['fanDianBdwMax'] ?>" fan-dian-bdw="<?= $this->user['fanDianBdw'] ?>" min="0" step="0.1" slideCallBack="gameSetFanDian"></div>
                <input type="button" class="max" value="" step="0.1"/>
            </div>
        </div>
        <?php if ($this->settings['switchDLBuy'] == 0) { //代理不能买单?>
            <input name="wjdl" type="hidden" value="<?= $this->ifs($this->user['type'], 1) ?>" id="wjdl" />
        <?php } ?>
        <script type="text/javascript">
            $("#slider").slider();
        </script>
        <script src="/wjinc/default/js/newdh.js<?= $this->sversion ?>"></script>
        <audio class="kaijiang" loop src="/wjinc/default/sound/kaijiang.wav<?= $this->sversion ?>"></audio>
        <script>
            $(function () {
                var host = (window.location.host).split(":")
                var wsurl = 'ws://' + host[0] + ':9009/socket.php';
                var websocket;
                var name = $('.f_name').val();
                var uid = $('.f_uid').val();
                var ftype = $('.f_type').val();
                var i = 0;
                //function connect() {
                if (window.WebSocket) {
                    websocket = new WebSocket(wsurl);

                    //连接建立
                    websocket.onopen = function (evevt) {
                        console.log("Connected to WebSocket server.");
                        //用户进来

                        var msg = {
                            type: 'system',
                            name: name,
                            uid: uid,
                            class: 1,
                            ftype: ftype
                        };
                        websocket.send(JSON.stringify(msg));
                        // $('.show-area').append('<p class="bg-info message"><i class="glyphicon glyphicon-info-sign"></i>Connected to WebSocket server!</p>');
                    }
                    //收到消息
                    websocket.onmessage = function (event) {
                        var msg = JSON.parse(event.data); //解析收到的json消息数据
                        var type = msg.type;
                        console.log(msg)
                        var fmtype = msg.ftype;
                        if (fmtype == ftype) {
                            if (type == 'usermsg') {
                                var cls = msg.class;
                                var html = '';
                                if (cls == 1) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_right">' +
                                                '   <div class="tc col999 f24">' + msg.time + '</div>' +
                                                '   <div class="clearfix d_content">' +
                                                '       <div class=" d_float"><img class="tx" src="/wjinc/default/images/tx.png"></div>' +
                                                '       <div class=" d_float d_w">' +
                                                '           <p class="col999 f24 tr">' + msg.name + '</p>' +
                                                '           <div class="bg_red">' +
                                                '               <div class="f30 clearfix fff d_title">' +
                                                '                   <div class="fl">' +
                                                '                       <span class="iconfont icon-shijian"></span> 第<span>' + msg.number + '期</span>' +
                                                '                   </div>' +
                                                '                   <div class="fr">投注类型：<span>' + msg.title + '</span></div>' +
                                                '               </div>' +
                                                '               <div class="f40 fff"><span class="iconfont icon-qiandai1 f40"></span> ' + msg.money + '元</div>' +
                                                '           </div>' +
                                                '       </div>' +
                                                '   </div>' +
                                                '</li>';
                                    } else {
                                        html += '<li class="d_left">' +
                                                '   <div class="tc col999 f24">' + msg.time + '</div>' +
                                                '   <div class="clearfix d_content">' +
                                                '       <div class=" d_float"><img class="tx" src="/wjinc/default/images/tx.png"></div>' +
                                                '       <div class=" d_float d_w">' +
                                                '           <p class="col999 f24 tl">' + msg.name + '</p>' +
                                                '           <div class="bg_red">' +
                                                '               <div class="f30 clearfix fff d_title">' +
                                                '                   <div class="fl">' +
                                                '                       <span class="iconfont icon-shijian"></span> 第<span>' + msg.number + '期</span>' +
                                                '                   </div>' +
                                                '                   <div class="fr">投注类型：<span>' + msg.title + '</span></div>' +
                                                '               </div>' +
                                                '               <div class="f40 fff"><span class="iconfont icon-qiandai1 f40"></span> ' + msg.money + '元</div>' +
                                                '           </div>' +
                                                '       </div>' +
                                                '   </div>' +
                                                '</li>';
                                    }
                                }
                                $(".d_box").append(html);

                            }
                            if (type == 'system') {
                                var cls = msg.class;
                                var html = '';

                                if (cls == 1) {
                                    if (msg.uid != uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="f24 "><div class="d_text1">欢迎<span class="col_red">' + msg.name + '</span>进入房间</div></div>' +
                                                '</li>'
                                    }
                                } else if (cls == 2) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="f30 d_text2 "><span class="col_red">[' + msg.number + '期]</span>单注<span class="col_red">2元</span>起，<span class="col_red">20000元</span>封顶，总注<span class="col_red">3000000元</span>封顶<br><span class="col_red">★★现状可以开始投注★★</span></div>' +
                                                '</li>'
                                    }
                                } else if (cls == 3) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]已封盘</span>，下注结果已系统开奖为标准，如有异议，请及时联系客服</div>' +
                                                '</li>'
                                    }
                                } else if (cls == 4) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="d_text2"><span class="col_red">[' + msg.number + '期]</span>恭喜<span class="col_red">' + msg.name + '</span>已中2倍，共获得<span class="col_red">' + msg.winmoney + '元</span></div>' +
                                                '</li>'
                                    }
                                } else if (cls == 5) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]</span>距离封盘时间不足<span class="col_red">60秒</span>，请抓紧时间下注</div>' +
                                                '</li>'
                                    }
                                } else if (cls == 6) {
                                    if (msg.uid == uid) {
                                        html += '<li class="d_center">' +
                                                '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]开奖号码：' + msg.name + '</span></div>' +
                                                '</li>'
                                    }
                                }

                                $(".d_box").append(html);
                            }
                        }
                        window.scrollTo(0, document.body.scrollHeight);
                        $('#message').val('');
                    }

                    //发生错误
                    websocket.onerror = function (event) {
                        i++;
                        console.log("Connected to WebSocket server error");
                        $('.show-area').append('<p class="bg-danger message"><a name="' + i + '"></a><i class="glyphicon glyphicon-info-sign"></i>Connect to WebSocket server error.</p>');
                    }

                    //连接关闭
                    websocket.onclose = function (event) {
                        i++;
                        console.log('websocket Connection Closed. ');
                        $('.show-area').append('<p class="bg-warning message"><a name="' + i + '"></a><i class="glyphicon glyphicon-info-sign"></i>websocket Connection Closed.</p>');

                    }




                } else {
                    alert('该浏览器不支持web socket');
                }
                function reconnect() {
                    if (window.WebSocket) {
                        websocket = new WebSocket(wsurl);

                        //连接建立
                        websocket.onopen = function (evevt) {
                            console.log("Connected to WebSocket server.");
                            //
                            // $('.show-area').append('<p class="bg-info message"><i class="glyphicon glyphicon-info-sign"></i>Connected to WebSocket server!</p>');
                        }
                        //收到消息
                        websocket.onmessage = function (event) {
                            var msg = JSON.parse(event.data); //解析收到的json消息数据
                            var type = msg.type;
                            console.log(msg)
                            var fmtype = msg.ftype;
                            if (fmtype == ftype) {
                                if (type == 'usermsg') {
                                    var cls = msg.class;
                                    var html = '';
                                    if (cls == 1) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_right">' +
                                                    '   <div class="tc col999 f24">' + msg.time + '</div>' +
                                                    '   <div class="clearfix d_content">' +
                                                    '       <div class=" d_float"><img class="tx" src="/wjinc/default/images/tx.png"></div>' +
                                                    '       <div class=" d_float d_w">' +
                                                    '           <p class="col999 f24 tr">' + msg.name + '</p>' +
                                                    '           <div class="bg_red">' +
                                                    '               <div class="f30 clearfix fff d_title">' +
                                                    '                   <div class="fl">' +
                                                    '                       <span class="iconfont icon-shijian"></span> 第<span>' + msg.number + '期</span>' +
                                                    '                   </div>' +
                                                    '                   <div class="fr">投注类型：<span>' + msg.title + '</span></div>' +
                                                    '               </div>' +
                                                    '               <div class="f40 fff"><span class="iconfont icon-qiandai1 f40"></span> ' + msg.money + '元</div>' +
                                                    '           </div>' +
                                                    '       </div>' +
                                                    '   </div>' +
                                                    '</li>';
                                        } else {
                                            html += '<li class="d_left">' +
                                                    '   <div class="tc col999 f24">' + msg.time + '</div>' +
                                                    '   <div class="clearfix d_content">' +
                                                    '       <div class=" d_float"><img class="tx" src="/wjinc/default/images/tx.png"></div>' +
                                                    '       <div class=" d_float d_w">' +
                                                    '           <p class="col999 f24 tl">' + msg.name + '</p>' +
                                                    '           <div class="bg_red">' +
                                                    '               <div class="f30 clearfix fff d_title">' +
                                                    '                   <div class="fl">' +
                                                    '                       <span class="iconfont icon-shijian"></span> 第<span>' + msg.number + '期</span>' +
                                                    '                   </div>' +
                                                    '                   <div class="fr">投注类型：<span>' + msg.title + '</span></div>' +
                                                    '               </div>' +
                                                    '               <div class="f40 fff"><span class="iconfont icon-qiandai1 f40"></span> ' + msg.money + '元</div>' +
                                                    '           </div>' +
                                                    '       </div>' +
                                                    '   </div>' +
                                                    '</li>';
                                        }
                                    }
                                    $(".d_box").append(html);

                                }
                                if (type == 'system') {
                                    var cls = msg.class;
                                    var html = '';

                                    if (cls == 1) {
                                        if (msg.uid != uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="f24 "><div class="d_text1">欢迎<span class="col_red">' + msg.name + '</span>进入房间</div></div>' +
                                                    '</li>'
                                        }
                                    } else if (cls == 2) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="f30 d_text2 "><span class="col_red">[' + msg.number + '期]</span>单注<span class="col_red">2元</span>起，<span class="col_red">20000元</span>封顶，总注<span class="col_red">3000000元</span>封顶<br><span class="col_red">★★现状可以开始投注★★</span></div>' +
                                                    '</li>'
                                        }
                                    } else if (cls == 3) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]已封盘</span>，下注结果已系统开奖为标准，如有异议，请及时联系客服</div>' +
                                                    '</li>'
                                        }
                                    } else if (cls == 4) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="d_text2"><span class="col_red">[' + msg.number + '期]</span>恭喜<span class="col_red">' + msg.name + '</span>已中2倍，共获得<span class="col_red">' + msg.winmoney + '元</span></div>' +
                                                    '</li>'
                                        }
                                    } else if (cls == 5) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]</span>距离封盘时间不足<span class="col_red">60秒</span>，请抓紧时间下注</div>' +
                                                    '</li>'
                                        }
                                    } else if (cls == 6) {
                                        if (msg.uid == uid) {
                                            html += '<li class="d_center">' +
                                                    '   <div class="d_text2 "><span class="col_red">[' + msg.number + '期]开奖号码：' + msg.name + '</span></div>' +
                                                    '</li>'
                                        }
                                    }

                                    $(".d_box").append(html);
                                }
                            }
                            window.scrollTo(0, document.body.scrollHeight);
                            $('#message').val('');
                        }

                        //发生错误
                        websocket.onerror = function (event) {
                            i++;
                            console.log("Connected to WebSocket server error");
                            $('.show-area').append('<p class="bg-danger message"><a name="' + i + '"></a><i class="glyphicon glyphicon-info-sign"></i>Connect to WebSocket server error.</p>');
                        }

                        //连接关闭
                        websocket.onclose = function (event) {
                            i++;
                            console.log('websocket Connection Closed. ');
                            $('.show-area').append('<p class="bg-warning message"><a name="' + i + '"></a><i class="glyphicon glyphicon-info-sign"></i>websocket Connection Closed.</p>');

                        }




                    } else {
                        alert('该浏览器不支持web socket');
                    }
                }
                //}

                var onlyht = false;
                var game = {
                    init: function () {
                        this.bindEvent();
                        this.submitGame();
                        if (websocket) {
                            this.qhinfo(true);
                        }
                        this.getKjList();
                        this.checklogin();
                        this.getUserInfo();
                        this.dealh5inback();
                    },
                    allCont: {
                        all_stake: 1, //注数
                        all_money: 0,
                        playid: 0,
                        groupid: 0,
                        actionNo: '',
                        kjTime: '1524574800',
                        type: ftype,
                        zhuiHao: '1',
                        zhuiHaoMode: '',
                    },
                    code: [],
                    global: {
                        counttimer: null,
                        number: 906704,
                        fengpan: false,
                        cid: ftype,
                        tipsfor60: false,
                        lastactionNo: 0,
                        kjtimer: false,
                        kjtimeryk: false,
                        oldno: 0,
                        reconnect: false,
                        oldtime: 0
                    },
                    betInfo: {
                        num: 0,
                        data: '',
                        money: 0,
                        fandian: 0,
                        bonus: 0
                    },
                    bindEvent: function () {
                        game.getOrder();
                        game.betInfo.fandian = $('#slider').attr('fan-dian');
                        var that = $(".wf_cont > li").eq(0);
                        $(".wf_zhi1 li .wf_z").removeClass("active");
                        $(that).find(".wf_zhi1 li .wf_z").eq(0).addClass("active");
                        var title = $(that).find(".c_title").attr("data-title");
                        var val = $(that).find(".c_val").attr("data-value");
                        val = Number(val).toFixed(2);
                        var tips = $(that).find(".c_val").attr("data-info");
                        var sindex = $(that).find(".c_val").attr("data-index");
                        var dataid = $(that).find(".c_val").attr("data-id");
                        var datagid = $(that).find(".c_val").attr("data-groupid");
                        game.allCont.playid = dataid;
                        game.allCont.groupid = datagid;
                        game.betInfo.bonus = val;
                        $(".f_title").val(title);
                        $(".f_val").val(val);
                        $(".wf_btn").click(function () {
                            game.code = [];
                            game.allCont.all_stake = 0;
                            game.allCont.all_money = 0;
                            var num = $(".data_index").val();
                            var add = $(this).attr("data-add");
                            if (add == "jia") {
                                if (num >= 2) {
                                    num = 0;
                                } else {
                                    num++;
                                }
                            } else if (add == "jian") {
                                if (num == 0) {
                                    num = 2;
                                } else {
                                    num--;
                                }
                            }
                            $(".data_index").val(num);
                            $(".wf_n").hide();
                            $(".wf_n").eq(num).show();
                            $(".wf_cont> li").hide();
                            $(".wf_cont>li").eq(num).show();

                            var that = $(".wf_cont > li").eq(num);
                            $(".wf_zhi1 li .wf_z").removeClass("active");
                            $(that).find(".wf_zhi1 li .wf_z").eq(0).addClass("active");
                            var title = $(that).find(".c_title").attr("data-title");
                            var val = $(that).find(".c_val").attr("data-value");
                            val = Number(val).toFixed(2);
                            var tips = $(that).find(".c_val").attr("data-info");
                            var sindex = $(that).find(".c_val").attr("data-index");
                            var dataid = $(that).find(".c_val").attr("data-id");
                            var datagid = $(that).find(".c_val").attr("data-groupid");
                            game.allCont.playid = dataid;
                            game.allCont.groupid = datagid;
                            game.betInfo.bonus = val;
                            $(".f_title").val(title);
                            $(".f_val").val(val);
                            $("." + sindex + " .zj_tips").text(tips);
                        })
                        $(".wf_zhi1 li").click(function () {
                            game.code = [];
                            game.allCont.all_stake = 0;
                            game.allCont.all_money = 0;
                            $(".wf_zhi1 li .wf_z").removeClass("active");
                            $(this).find(".wf_z").addClass("active");
                            var title = $(this).find(".c_title").attr("data-title");
                            var val = $(this).find(".c_val").attr("data-value");
                            val = Number(val).toFixed(2);
                            var tips = $(this).find(".c_val").attr("data-info");
                            var sindex = $(this).find(".c_val").attr("data-index");
                            var dataid = $(this).find(".c_val").attr("data-id");
                            var datagid = $(this).find(".c_val").attr("data-groupid");
                            game.allCont.playid = dataid;
                            game.allCont.groupid = datagid;
                            game.betInfo.bonus = val;
                            $(".f_title").val(title);
                            $(".f_val").val(val);
                            $("." + sindex + " .zj_tips").text(tips);
                        })



                        $(".mask").click(function () {
                            $(".pop_wrap").hide();
                        })
                        $(".f_beishu").blur(function () {
                            var val = $('.f_beishu').val();
                            if (val <= 0) {
                                $(".hi_msg").text('注数不能小于1');
                                $(".hi_pop").show();
                                $(".cp_input").val(1);
                            }
                            if (val > 10000) {
                                $(".hi_msg").text('注数不能大于10000');
                                $(".hi_pop").show();
                                $(".cp_input").val(10000);
                            }
                        })
                        $(".js_jia").click(function () {
                            var val = $(this).attr("data-value");
                            var num = $(".cp_input").val();
                            if (val == "jia") {
                                num++;

                                $(".cp_input").val(num)
                                if (num >= 10000) {
                                    $(".hi_msg").text('注数不能大于10000');
                                    $(".hi_pop").show();
                                    $(".cp_input").val(10000);
                                }
                            } else if (val == "jian") {
                                num--;
                                $(".cp_input").val(num);
                                if (num <= 0) {
                                    $(".hi_msg").text('注数不能小于1');
                                    $(".hi_pop").show();

                                    $(".cp_input").val(1);
                                }
                            }
                        })

                        $(".toplist").on("click", ".top_title", function () {
                            var d = $(this).index();
                            if (d == 0) {
                                if ($(this).hasClass("on")) {
                                    $(".toplist li").hide();
                                    $(this).removeClass("on")
                                } else {
                                    $(".toplist li").show();
                                    $(this).addClass("on")
                                }

                            }
                        })
                        $(".hi_btn").click(function () {
                            $(".hi_pop").hide();
                        })
                    },
                    submitGame: function () {
                        $(".tz_btns").click(function () {
                            if (game.global.fengpan) {
                                $(".hi_msg").text('封盘中不能下注！');
                                $(".hi_pop").show();
                                return false;
                            }
                            $(".pop_wrap").show();
                            $(".wf_cont .wf_cont1").show();
                            $(".wf_cont .wf_cont2,.wf_cont .wf_cont3").hide();
                            var that = $(".wf_cont > li").eq(0);
                            $(".wf_zhi1 li .wf_z").removeClass("active");
                            $(that).find(".wf_zhi1 li .wf_z").eq(0).addClass("active");
                            var title = $(that).find(".c_title").attr("data-title");
                            var val = $(that).find(".c_val").attr("data-value");
                            val = Number(val).toFixed(2);
                            var tips = $(that).find(".c_val").attr("data-info");
                            var sindex = $(that).find(".c_val").attr("data-index");
                            $(".f_title").val(title);
                            $(".f_val").val(val);
                            $("." + sindex + " .zj_tips").text(tips);
                        })
                        //提交

                        $(".sure_btn").click(function () {
                            if (!game.global.fengpan) {
                                game.send();
                            } else {
                                $(".hi_msg").text('封盘中不能下注！');
                                $(".hi_pop").show();
                                return false;
                            }
                        })


                    },
                    send: function () {
                        if (game.global.fengpan) {
                            $(".hi_msg").text('封盘中不能下注！');
                            $(".hi_pop").show();
                            return false;
                        }
                        var val = $('.f_val').val();
                        var title = $('.f_title').val();
                        var input = $('.f_input').val();
                        var beishu = $('.f_beishu').val();
                        var dan = $('.f_dan').val();
                        var name = $('.f_name').val();
                        var money = dan * beishu;
                        var beishu = $('.f_beishu').val();
                        if (beishu <= 0) {
                            $(".hi_msg").text('注数不能小于0');
                            $(".hi_pop").show();
                            $(".cp_input").val(1);
                            return false;
                        }
                        if (beishu > 10000) {
                            $(".hi_msg").text('注数不能大于10000');
                            $(".hi_pop").show();
                            $(".cp_input").val(10000);
                            return false;
                        }
                        if (!title) {
                            $(".hi_msg").text('请选择投注内容');
                            $(".hi_pop").show();
                            return false;
                        }
                        var msg = {
                            number: game.global.number,
                            val: val,
                            title: title,
                            input: input,
                            name: name,
                            money: money,
                            beishu: beishu,
                            dan: dan,
                            type: 'usermsg',
                            uid: uid,
                            class: 1,
                            ftype: ftype
                        };
                        game.allCont.all_money = msg.money;
                        var list = {};



                        list.fanDian = game.betInfo.fandian;
                        list.bonusProp = game.betInfo.bonus;
                        list.mode = 1;
                        list.beiShu = beishu;
                        list.orderId = (new Date()) - 2147483647 * 623;
                        list.actionData = msg.title;
                        list.actionNum = 1;
                        list.weiShu = 0; //不确定；
                        list.playedGroup = game.allCont.groupid;
                        list.playedId = game.allCont.playid;
                        list.type = game.allCont.playid;
                        game.code.push(list)
                        try {
                            console.log(msg);


                            $.post('/index.php/game/post28Code', {code: game.code, para: game.allCont, zhuiHao: game.zhuihao}, function (res) {
                                game.code = [];
                                game.allCont.all_stake = 0;
                                game.allCont.all_money = 0;
                                if (!res.code) {

                                    websocket.send(JSON.stringify(msg));
                                    $(".pop_wrap").hide();
                                } else {
                                    $(".hi_msg").text(res.msg);
                                    $(".hi_pop").show();
                                    return false;
                                }
                            }, 'json');
                        } catch (ex) {
                            console.log(ex);
                        }
                    },
                    checkTime: function (i) { //将0-9的数字前面加上0，例1变为01 
                        if (i < 10) {
                            i = "0" + i;
                        }
                        return i;
                    },
                    countdown: function (times, kjtime, kjftime) { //倒计时

                        //times = 5;
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
                                $(".gameo_hour, .gameo_hour_text").show();
                                $(".gameo_hour").text(game.checkTime(hour));
                            } else {
                                $(".gameo_hour, .gameo_hour_text").hide();
                            }

                            // if (times == 5) {
                            //     $(".kaijiang")[0].play();
                            // }
                            if (times < 60 && !game.global.tipsfor60) {
                                var msg = {
                                    type: 'system',
                                    name: name,
                                    uid: uid,
                                    class: 5,
                                    ftype: ftype,
                                    number: game.global.number
                                };
                                websocket.send(JSON.stringify(msg));
                                game.global.tipsfor60 = true;
                                // $(".kaijiang")[0].play();
                            }
                            if (times < 0) {
                                if (times == -1) {
                                    game.global.fengpan = true;
                                    $(".info_fengpan").show();
                                    $(".info_time").hide();
                                    var msg = {
                                        type: 'system',
                                        name: name,
                                        uid: uid,
                                        class: 3,
                                        ftype: ftype,
                                        number: game.global.number
                                    };
                                    websocket.send(JSON.stringify(msg));
                                }
                                if (Math.abs(times) == kjftime) {
                                    clearInterval(game.global.counttimer);
                                    game.global.fengpan = false;
                                    game.global.tipsfor60 = false;

                                    game.qhinfo();
                                }
                            }

                            times--;
                        }, 1000);
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

                                            game.is_false = false;
                                            game.global.kjtimer = false;
                                            clearInterval(kjtimer);
                                            game.getYk();
                                            game.getKjList();
                                            var msg = {
                                                type: 'system',
                                                name: data.data.kjNo,
                                                uid: uid,
                                                class: 6,
                                                ftype: ftype,
                                                number: game.global.lastactionNo
                                            };
                                            websocket.send(JSON.stringify(msg));
                                        }
                                    } else {
                                        window.location.reload;
                                    }
                                }, 'json');

                            }, 3000);
                            game.global.kjtimer = true;
                        }
                    },
                    qhinfo: function (flag) {
                        $.post('/index.php/game/getqhinfo/' + game.global.cid, function (data) {
                            if (!data.code) {
                                var data = data.data;

                                $(".info_currqishu").text(data.actionNo.actionNo);
                                $(".info_qishu").text("[" + data.actionNo.actionNo + "]")
                                game.global.number = data.actionNo.actionNo;
                                game.global.lastactionNo = data.lastNo.actionNo;
                                game.allCont.actionNo = data.actionNo.actionNo;
                                game.allCont.kjTime = data.actionNo.timestamp;

                                game.countdown(Math.abs(data.actionNo.difftime), data.actionNo.diffKTime, data.actionNo.diffFTime);
                                $(".info_fengpan").hide();
                                $(".info_time").show();
                                if (!data.kjNo) {
                                    game.kjinfo();
                                }

                                if (!flag || game.global.oldno != data.actionNo.actionNo) {
                                    var msg = {
                                        type: 'system',
                                        name: name,
                                        uid: uid,
                                        class: 2,
                                        ftype: ftype,
                                        number: game.global.number
                                    };
                                    try {
                                        websocket.send(JSON.stringify(msg));
                                    } catch (err) {
//
//                                        $(".hint_pop .hint_cont").html("服务器异常,请刷新重试");
//                                        $(".hint_pop .hint_title").text("系统提示");
//                                        $(".hint_pop").show();
                                    }


                                }
//                                console.log(game.global.reconnect,data.actionNo.nowtimestamp - game.global.oldtime,1233)
//                                if (!flag) {
//                                    if (data.actionNo.nowtimestamp - game.global.oldtime > 60) {
//                                        game.global.reconnect = true;
//                                        console.log(game.global.reconnect,data.actionNo.nowtimestamp - game.global.oldtime,12335)
//                                    } else {
//                                        game.global.reconnect = false;
//                                        console.log(game.global.reconnect,data.actionNo.nowtimestamp - game.global.oldtime,1236)
//                                    }
//                                }
//                                console.log(game.global.reconnect,data.actionNo.nowtimestamp - game.global.oldtime,12337)
//                                game.global.oldtime = data.actionNo.nowtimestamp;
                                game.global.oldno = data.actionNo.actionNo;
                            } else {
                                window.location.reload;
                            }
                        }, 'json');

                    },
                    getYk: function () {
                        var kjtimery = null;
                        if (!game.global.kjtimeryk) {
                            kjtimery = setInterval(function () {
                                $.post('/index.php/Tip/getYKTip/' + game.global.cid + '/' + game.global.lastactionNo, function (res) {
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
                    },
                    getKjList: function () {
                        $.post('/index.php/game/getkjlistinfo/' + game.global.cid, function (res) {
                            if (res.data) {
                                $('.toplist').html(res.data);
                            }
                        }, 'json');
                    },
                    checklogin: function () {//每5秒检查用户是否在线
                        var timers = null;
                        timers = setInterval(function () {
                            //默认期号
                            $.post('/index.php/user/checklogin', function (data) {
                                if (!data.code) {
                                    if (data.data) {
                                        clearInterval(timers)
                                        window.location.href = '/index.php/user/login';
                                        return false;
                                    }

                                }
                            }, 'json');

                        }, 10000);

                    },
                    getUserInfo: function () {
                        var time_d2 = setInterval(function () {
                            $.post('/index.php/index/userajaxinfo', function (res) {
                                if (!res.code) {
                                    $('.info_money').text(res.data.money);

                                }
                            }, 'json');
                            $.post('/index.php/Tip/getCZTip', function (res) {
                                if (res.data.flag) {
                                    $(".hint_pop .hint_cont").text(res.data.message);
                                    $(".hint_pop .hint_title").text("系统提示");
                                    $(".hint_pop").show();
                                }
                            }, 'json');
                            $.post('/index.php/Tip/getTKTip', function (res) {
                                if (res.data.flag) {
                                    $(".hint_pop .hint_cont").html(res.data.message);
                                    $(".hint_pop .hint_title").text("系统提示");
                                    $(".hint_pop").show();
                                }
                            }, 'json');
                            var msg = {
                                type: 'system',
                                name: name,
                                uid: uid,
                                class: 8,
                                ftype: ftype,
                                number: game.global.number
                            };
                            try {
                                websocket.send(JSON.stringify(msg));
                            } catch (err) {
                            }
                        }, 10000)
                        $(".hint_btn").on('click', function () {
                            $(".hint_pop .hint_title").text('错误提示');
                            $(".hint_pop").hide();
                            $(".hint_pop1").hide();
                            return false;
                        })

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
                                if (game.global.counttimer)
                                    clearInterval(game.global.counttimer);
                                game.qhinfo(true);
                                var msg = {
                                    type: 'system',
                                    name: name,
                                    uid: uid,
                                    class: 8,
                                    ftype: ftype,
                                    number: game.global.number
                                };
                                try {
                                    websocket.send(JSON.stringify(msg));
                                } catch (err) {
                                    reconnect();
                                }
                            } else {
                                if (game.global.counttimer)
                                    clearInterval(game.global.counttimer);
                                
                            }
                        }
                        document.addEventListener(visibilityChangeEvent, onVisibilityChange);
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
                                        prize_col = '';
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
                                    html += '    <li>'
                                    html += '        <span data-id="' + list[i].id + '" class="orderdetail" >' + list[i].wjorderId + '</span>'
                                    html += '        <span>' + list[i].gamename + '</span>'
                                    html += '        <span>' + list[i].playname + '</span>'
                                    html += '        <span>' + list[i].actionNo + '</span>'
                                    html += '        <span>' + list[i].money + '</span>'
                                    html += '        <span id="' + list[i].id + '" class="' + prize_col + '">' + text + '</td>'
                                    html += '    </li>'
                                }
                                $(".gameo_list").html(html);
                            } else {
                                $(".hint_pop .hint_cont").text(data.msg);
                                $(".hint_pop").show();
                            }
                        }, 'json');
                    },
                }
                game.init();
            });
        </script> 
    </body>
</html>
