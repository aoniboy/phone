<?php

class Index extends WebLoginBase {

    public $pageSize = 10;

    public final function game($type = null, $groupId = null, $played = null) {
        $tmp = array();
        foreach ($this->gameinfo as $key => $val) {
            $sql = "select st.id,st.title,st.num,st.enable from ssc_type st where st.id={$val}     ";
            $result = $this->getRow($sql);
            !empty($result) ? $tmp[$val] = $result : '';
        }
        $this->finalgameinfo = $tmp;
        $this->type = intval($type);
        $this->game = 'active';
        if (!empty($this->type) && $this->finalgameinfo[$type]['enable']) {
            $this->display('newmain.php');
        }
    }

    public final function gameList() {
        $this->game = 'active';
        $this->display('newindex/game-list.php');
    }

    //平台首页
    public final function main() {
        $sql = "select * from {$this->prename}content where enable=1 and nodeId=1 ";
        $sql .= ' order by id desc limit 3';
        $this->noticeinfo = $this->getRows($sql);
        $this->index = 'active';
        $this->display('newindex.php');
    }

    public final function znz($type = null, $groupId = null, $played = null) {
        if ($type)
            $this->type = intval($type);
        if ($groupId)
            $this->groupId = intval($groupId);
        if ($played)
            $this->played = intval($played);

        $this->getTypes();
        $this->getPlayeds();
        $this->display('index/inc_game_znz.php');
    }

    public final function group($type, $groupId) {
        $this->type = intval($type);
        $this->groupId = intval($groupId);
        $this->display('index/load_tab_group.php');
    }

    public final function played($type, $playedId) {
        $playedId = intval($playedId);
        $sql = "select type, groupId, playedTpl from {$this->prename}played where id=?";
        $data = $this->getRow($sql, $playedId);
        $this->type = intval($type);
        if ($data['playedTpl']) {
            $this->groupId = $data['groupId'];
            $this->played = $playedId;
            $this->display("index/game-played/{$data['playedTpl']}.php");
        } else {
            $this->display('index/game-played/un-open.php');
        }
    }

    public final function playedType($type, $playedId) {
        $sql = "select type from {$this->prename}type where id=? and enable = 1 order by sort";
        $data = $this->getRow($sql, $type);
        if (empty($data))
            $this->outputData(1, array(), '操作失败');
        $sql = "select id from {$this->prename}played_group where type=? and enable = 1 order by sort";
        $data = $this->getRows($sql, $data['type']);
        $result = array();
        foreach ($data as $key => $val) {
            $sql = "select id,name,selectNum,groupId,numinfo,simpleInfo,bonusProp, bonusPropBase,betCountFun from {$this->prename}played where  groupId= ? and enable = 1";
            $tmp = $this->getRows($sql, $val['id']);
            foreach ($tmp as $k => $v) {
                $result[] = $v;
            }
        }


        foreach ($result as $key => $val) {
            $result[$key]['position'] = explode(',', $val['numinfo']);
        }

        $this->outputData(0, $result);
    }

    // 加载玩法介绍信息
    public final function playTips($playedId) {
        $this->display('index/inc_game_tips.php', 0, intval($playedId));
    }

    public final function getQiHao($type) {
        $thisNo = $this->getGameNo($type);
        return array(
            'lastNo' => $this->getGameLastNo($type),
            'thisNo' => $this->getGameNo($type),
            'diffTime' => strtotime($thisNo['actionTime']) - $this->time,
            'validTime' => $thisNo['actionTime'],
            'kjdTime' => $this->getTypeFtime($type)
        );
    }

    // 弹出追号层HTML
    public final function zhuiHaoModal($type) {
        $this->display('index/game-zhuihao-modal.php');
    }

    // 追号层加载期号
    public final function zhuiHaoQs($type, $mode, $count) {
        $this->type = intval($type);
        $this->display('index/game-zhuihao-qs.php', 0, $mode, $count);
    }

    // 加载历史开奖数据
    public final function getHistoryData($type) {
        $this->type = intval($type);
        $this->display('index/inc_data_history.php');
    }

    // 历史开奖HTML
    public final function historyList($type) {
        $this->type = intval($type);
        $this->display('index/history-list.php', $pageSize, $type);
    }

    //全部彩种开奖页面
    public final function openList($type) {
        $this->type = intval($type);
        $this->open = 'active';
        $this->display('newindex/open-list.php', $pageSize, $type);
    }

    //new彩种开奖详情页面
    public final function openListDetail($type) {
        $this->type = intval($type);
        $this->typename = $this->getValue("select title from ssc_type where id=?", $type);
        $sql = "select sd.type, sd.time, sd.number, sd.data,st.title from ssc_data sd,ssc_type st where sd.type = {$type} and st.id={$type}  order by sd.id desc  limit 0,10 ";
        $this->result = $this->getRows($sql);
        $this->open = 'active';
        $this->display('newindex/open-list-detail.php');
    }

    // new加载历史开奖数据
    public final function getOpenHistoryData($type, $start = 10) {
        $typename = $this->getValue("select title from ssc_type where id=?", $type);
        $sql = "select sd.type, sd.time, sd.number, sd.data,st.title from ssc_data sd,ssc_type st where sd.type = {$type} and st.id={$type}  order by sd.id desc  limit {$start},10 ";
        $result = $this->getRows($sql);
        foreach ($result as $key => $val) {
            $result[$key]['time'] = date("Y-m-d H:i", $val['time']);
            $data = explode(",", $val['data']);
            $tnumber = '';
            foreach ($data as $k => $v) {
                $tnumber .= "<span>$v</span>";
            }
            $result[$key]['tnumber'] = $tnumber;
        }
        $data = array('name' => $typename, 'result' => $result);
        $this->outputData(0, $data);
    }

    public final function getLastKjData($type) {
        $ykMoney = 0;
        $czName = '重庆时时彩';
        $this->type = intval($type);
        if (!$lastNo = $this->getGameLastNo($this->type))
            throw new Exception('查找最后开奖期号出错');
        if (!$lastNo['data'] = $this->getValue("select data from {$this->prename}data where type={$this->type} and number='{$lastNo['actionNo']}'"))
            throw new Exception('获取数据出错');

        $thisNo = $this->getGameNo($this->type);
        $lastNo['actionName'] = $czName;
        $lastNo['thisNo'] = $thisNo['actionNo'];
        $lastNo['diffTime'] = strtotime($thisNo['actionTime']) - $this->time;
        $lastNo['kjdTime'] = $this->getTypeFtime($type);
        return $lastNo;
    }

    // 加载人员信息框
    public final function userInfo() {
        $this->display('index/inc_user.php');
    }

    // 加载人员信息框
    public final function userAjaxInfo() {
        $stime = strtotime(date("Y-m-d 00:00:00"));
        $etime = strtotime(date("Y-m-d 23:59:59"));
        $sql = "select u.username, u.coin, u.uid, u.parentId, sum(b.mode * b.beiShu * b.actionNum) betAmount, sum(b.bonus) zjAmount, (select sum(c.amount) from ssc_member_cash c where c.`uid`=u.`uid` and c.state=0 and c.actionTime between $stime and $etime) cashAmount,(select sum(r.amount) from ssc_member_recharge r where r.`uid`=u.`uid` and r.state in(1,2,9) and r.actionTime between $stime and $etime) rechargeAmount, (select sum(l.coin) from ssc_coin_log l where l.`uid`=u.`uid` and l.liqType in(50,51,52,53) and l.actionTime between $stime and $etime) brokerageAmount from ssc_members u left join ssc_bets b on u.uid=b.uid and b.isDelete=0 and actionTime between $stime and $etime where 1 and u.uid=" . $this->user['uid'];
        $info = $this->getRow($sql);
        $yingkui = sprintf("%.2f", $info['zjAmount'] - $info['betAmount']);
        $this->freshSession();
        $data['money'] = $this->user['coin'];
        $data['yingkui'] = $yingkui;
        $this->outputData(0, $data);
    }

    // 加载历史开奖数据
    public final function getHistoryDataLeft($type) {
        $this->type = intval($type);
        $this->display('index/inc_data_history_left.php');
    }



    //websocket
    public final function jnd28() {
        $type = 55;
        $sql = "select defaultodds from {$this->prename}member_odds where gameid =8 and uid = {$this->user['uid']} order by id desc";
        $userProp = $this->getRow($sql);
        $sql = "select id from {$this->prename}played_group where type =8 and enable = 1 order by sort";
        $data = $this->getRows($sql);
        $result = array();
        foreach ($data as $key => $val) {
            $sql = "select id,name,selectNum,groupId,numinfo,simpleInfo,bonusProp, bonusPropBase,bonusPropProportion,betCountFun from {$this->prename}played where  groupId= ? and enable = 1 ";
            $tmp = $this->getRows($sql, $val['id']);
            foreach ($tmp as $k => $v) {
                $propInfo = explode(".",$v['bonusProp']);
                if(isset($propInfo[1])) {
                    
                    if($propInfo[1] == '00') {
                        $v['money'] = round($userProp['defaultodds'] * $v['bonusPropProportion']);
                    } else if($propInfo[1] == '95') {
                        $v['money'] = sprintf("%.2f", $userProp['defaultodds'] * $v['bonusPropProportion']);
                    }else {
                        $v['money'] =  sprintf("%.1f", $userProp['defaultodds'] * $v['bonusPropProportion']);
                    }
                    
                }
                $result[$val['id']][] = $v;
            }
        }
        $no = '';
        $info28['number'] = $no;
        $this->info28 = $info28;
        $this->ftype = $type;
        $this->pageTitle = "加拿大28";
        $this->result = $result;
        $this->display('newplay/index.php');
    }

    //websocket
    public final function bj28() {
        $type = 54;
        $sql = "select defaultodds from {$this->prename}member_odds where gameid =8 and uid = {$this->user['uid']} order by id desc";
        $userProp = $this->getRow($sql);
        $sql = "select id from {$this->prename}played_group where type =8 and enable = 1 order by sort";
        $data = $this->getRows($sql);
        $result = array();
        foreach ($data as $key => $val) {
            $sql = "select id,name,selectNum,groupId,numinfo,simpleInfo,bonusProp, bonusPropBase,bonusPropProportion,betCountFun from {$this->prename}played where  groupId= ? and enable = 1 ";
            $tmp = $this->getRows($sql, $val['id']);
            foreach ($tmp as $k => $v) {
                $propInfo = explode(".",$v['bonusProp']);
                if(isset($propInfo[1])) {
                    
                    if($propInfo[1] == '00') {
                        $v['money'] = round($userProp['defaultodds'] * $v['bonusPropProportion']);
                    } else if($propInfo[1] == '95') {
                        $v['money'] = sprintf("%.2f", $userProp['defaultodds'] * $v['bonusPropProportion']);
                    }else {
                        $v['money'] =  sprintf("%.1f", $userProp['defaultodds'] * $v['bonusPropProportion']);
                    }
                    
                }
                 
                
                $result[$val['id']][] = $v;
            }
        }
        $no = '';
        $info28['number'] = $no;
        $this->info28 = $info28;
        $this->ftype = $type;
        $this->pageTitle = "北京28";
        $this->result = $result;
        $this->display('newplay/index.php');
    }

}
