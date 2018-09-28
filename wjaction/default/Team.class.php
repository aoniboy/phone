<?php

class Team extends WebLoginBase {

    public $pageSize = 20;

    public function getMyUserCount1() {
        $this->getSystemSettings();
        $minFanDian = $this->user['fanDian'] - 10 * $this->settings['fanDianDiff'];
        $sql = "select count(*) registerUserCount, fanDian from {$this->prename}members where parentId={$this->user['uid']} and fanDian>=$minFanDian and fanDian<{$this->user['fanDian']} group by fanDian order by fanDian desc";
        $data = $this->getRows($sql);

        $ret = array();
        $fanDian = $this->user['fanDian'];
        $i = 0;
        $set = explode(',', $this->settings['fanDianUserCount']);

        while (($fanDian -= $this->settings['fanDianDiff']) && ($fanDian >= $minFanDian)) {
            $arr = array();
            if ($data[0]['fanDian'] == $fanDian) {
                $arr = array_shift($data);
            } else {
                $arr['fanDian'] = $fanDian;
                $arr['registerUserCount'] = 0;
            }

            $arr['setting'] = $set[$i];
            //var_dump($fanDian);
            $ret["$fanDian"] = $arr;

            $i++;
        }

        return ($ret);
    }

    public function getMyUserCount() {
        if (!$set = $this->settings['fanDianUserCount'])
            return array();
        $set = explode(',', $set);

        foreach ($set as $key => $var) {
            $set[$key] = explode('|', $var);
        }

        foreach ($set as $var) {
            if ($this->user['fanDian'] >= $var[1])
                break;
            array_shift($set);
        }
    }

    /* 游戏记录 */

    public final function gameRecord() {
        $this->getTypes();
        $this->getPlayeds();
        $this->action = 'searchGameRecord';
        $this->display('newsafe/dl_game.php');
    }

    public final function searchGameRecord() {

        $this->getTypes();
        $this->getPlayeds();
        $this->page = empty($_GET['page']) ? 1 : $_GET['page'];
        $data = $this->fetch('team/record-list.php');
        $this->outputData(0, $data);
    }

    /* 游戏记录 结束 */

    /* 团队报表 */

    public final function report() {

        $this->action = 'searchReport';
        $this->display('newsafe/dl_yingkui.php');
    }

    public final function searchReport() {

        $data = $this->fetch('team/report-list.php');
        $this->outputData(0, $data);
    }

    /* 团队报表 结束 */

    /* 帐变列表 */

    public final function coin() {
        $this->action = 'searchCoin';
        $this->display('newsafe/dl_zhangbian.php');
    }

    public final function searchCoin() {
        $this->page = empty($_GET['page']) ? 1 : $_GET['page'];
        $data = $this->fetch('team/coin-log.php');
        $this->outputData(0, $data);
    }

    /* 帐变列表 结束 */

    public final function coinall() {
        $this->freshSession();
        $this->display('newsafe/dl_team.php');
    }

    public final function addMember() {
        $sql = "select id,domain from ssc_domain sd WHERE id not in (SELECT domain_id from  ssc_agency_domain sad where sad.enable=1) and  sd.enable=1 ";
        $domainAgencyInfo = $this->getRows($sql);
        if(empty($domainAgencyInfo)) {
            $domainAgencyInfo[] = array('id'=>0,'domain'=>'暂无可用域名');
        }
        $this->domainInfo = $domainAgencyInfo;
        $this->display('newsafe/dl_member_add.php');
    }

    public final function userUpdate($id) {
        $this->display('newsafe/dl_member_edit.php', 0, intval($id));
    }

    public final function userUpdate2($id) {
        $this->display('team/menber-recharge.php', 0, intval($id));
    }

    public final function memberList() {
        $this->display('newsafe/dl_member.php');
    }

    public final function cashRecord() {
        $this->display('newsafe/dl_tixian_list.php');
    }

    public final function searchCashRecord() {
        $this->display('team/cash-record-list.php');
    }

    public final function addLink() {
        $this->display('newsafe/dl_tuiguang_add.php');
    }

    public final function linkDelete($lid) {
        $this->id = intval($lid);
        $data = $this->fetch('team/delete-link.php', 0, intval($lid));
        $this->outputData(0, $data);
    }

    public final function linkList() {
        $this->display('newsafe/dl_tuiguang.php');
    }

    public final function getLinkCode($id) {
        $this->id = intval($id);
        $data = $this->fetch('team/get-linkcode.php', 0, intval($id), $this->user['uid'], $this->urlPasswordKey);
        $this->outputData(0, $data);
    }

    public final function advLink() {
        $this->display('team/link-list.php');
    }

    public final function insertLink() {
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
        $urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
        $urlcheck = substr($urlshang, 7, strlen($urldan));
        if ($urlcheck <> $urldan)
            $this->outputData(1, array(), '数据包被非法篡改，请重新操作');

        if (!$_POST)
            $this->outputData(1, array(), '提交数据出错，请重新操作');

        $update['uid'] = intval($_POST['uid']);
        $update['type'] = intval($_POST['type']);
        $update['fanDian'] = floatval($_POST['fanDian']);
        $update['fanDianBdw'] = floatval($_POST['fanDianBdw']);
        $update['regIP'] = $this->ip(true);
        $update['regTime'] = $this->time;

        if ($update['fanDian'] < 0)
            $this->outputData(1, array(), '返点不能小于0');
        if ($update['fanDianBdw'] < 0)
            $this->outputData(1, array(), '不定位返点不能小于0');
        if ($update['fanDian'] > $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '返点不能大于' . $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']));
        if ($update['fanDianBdw'] > $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '不定位返点不能大于' . $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']));
        if ($update['type'] != 0 && $update['type'] != 1)
            $this->outputData(1, array(), '类型出错，请重新操作');
        if ($update['uid'] != $this->user['uid'])
            $this->outputData(1, array(), '只能增加自己的推广链接!');

        // 查检返点设置
        if ($update['fanDian']) {
            $this->getSystemSettings();
            if ($update['fanDian'] % $this->settings['fanDianDiff'])
                $this->outputData(1, array(), sprintf('返点只能是%.1f%的倍数', $this->settings['fanDianDiff']));
        }else {
            $update['fanDian'] = 0.0;
        }

        $this->beginTransaction();
        try {
            $sql = "select fanDian from {$this->prename}links where uid={$update['uid']} and fanDian=? ";

            if ($this->getValue($sql, $update['fanDian']))
                $this->outputData(1, array(), '此链接已经存在');
            if ($this->insertRow($this->prename . 'links', $update)) {
                $id = $this->lastInsertId();
                $this->commit();
                $this->outputData(0, array(), '添加链接成功');
            } else {
                $this->outputData(1, array(), '添加链接失败');
            }
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    /* 编辑注册链接 */

    public final function linkUpdate($id) {
        $this->id = intval($id);
        $data = $this->fetch('team/update-link.php', 0, intval($id));
        $this->outputData(0, $data);
    }

    public final function linkUpdateed() {
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
        $urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
        $urlcheck = substr($urlshang, 7, strlen($urldan));
        if ($urlcheck <> $urldan)
            $this->outputData(1, array(), '数据包被非法篡改，请重新操作');

        if (!$_POST)
            $this->outputData(1, array(), '提交数据出错，请重新操作');

        $update['lid'] = intval($_POST['lid']);
        $update['fanDian'] = floatval($_POST['fanDian']);
        $update['fanDianBdw'] = floatval($_POST['fanDianBdw']);
        $lid = $update['lid'];

        if ($update['fanDian'] < 0)
            $this->outputData(1, array(), '返点不能小于0');
        if ($update['fanDianBdw'] < 0)
            $this->outputData(1, array(), '不定位返点不能小于0');
        if ($update['fanDian'] > $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '返点不能大于' . $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']));
        if ($update['fanDianBdw'] > $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '不定位返点不能大于' . $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']));
        if ($uid = $this->getvalue("select uid from {$this->prename}links where lid=?", $lid)) {
            if ($uid != $this->user['uid'])
                $this->outputData(1, array(), '只能修改自己的推广链接!');
        }else {
            $this->outputData(1, array(), '此注册链接不存在');
        }

        if (!$_POST['fanDian']) {
            unset($_POST['fanDian']);
            unset($update['fanDian']);
        }
        if (!$_POST['fanDianBdw']) {
            unset($_POST['fanDianBdw']);
            unset($update['fanDianBdw']);
        }
        if ($update['fanDian'] == 0)
            $update['fanDian'] = 0.0;
        if ($update['fanDianBdw'] == 0)
            $update['fanDianBdw'] = 0.0;

        if ($this->updateRowss($this->prename . 'links', $update, "lid=$lid")) {
            $this->outputData(0, array(), '修改成功');
        } else {
            $this->outputData(1, array(), '未知出错');
        }
    }

    /* 删除注册链接 */

    public final function linkDeleteed($lid) {
        $lid = intval($lid);
        if ($uid = $this->getvalue("select uid from {$this->prename}links where lid=?", $lid)) {
            if ($uid != $this->user['uid'])
                $this->outputData(1, array(), '只能删除自己的推广链接!');
        }else {
            $this->outputData(1, array(), '此注册链接不存在');
        }
        $sql = "delete from {$this->prename}links where lid=?";
        if ($this->delete($sql, $lid)) {
            $this->outputData(0, array(), '删除成功');
        } else {
            $this->outputData(1, array(), '未知出错');
        }
    }

    public final function searchMember() {
        $this->page = empty($_GET['page']) ? 1 : $_GET['page'];
        $data = $this->fetch('team/member-search-list.php');
        $this->outputData(0, $data);
    }

    public final function searchMemberDetail() {
        $this->display('newsafe/dl_member_detail.php', 0, intval($id));
    }

    public final function insertMember() {
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
        $urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
        $urlcheck = substr($urlshang, 7, strlen($urldan));
        if ($urlcheck <> $urldan)
            $this->outputData(1, array(), '数据包被篡改，请重新操作');

        if (!$_POST)
            $this->outputData(1, array(), '提交数据出错，请重新操作');

        //过滤未知字段
        $update['username'] = wjStrFilter($_POST['username']);
        $update['qq'] = wjStrFilter($_POST['qq']);
        $update['fanDian'] = floatval($_POST['fanDian']);
        $update['fanDianBdw'] = floatval($_POST['fanDianBdw']);
        $update['password'] = $_POST['password'];
        $update['type'] = intval($_POST['type']);
        if (empty($this->user['parentId'])) {
            $domain_id = intval($_POST['domain']);
            if(empty($domain_id)) {
                $this->outputData(1, array(), '二级代理域名为空。');
            }
        }
        //接收参数检查
        if ($update['fanDian'] < 0)
            $this->outputData(1, array(), '返点不能小于0');
        if ($update['fanDianBdw'] < 0)
            $this->outputData(1, array(), '不定位不能小于0');
        if ($update['fanDian'] > $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] <= 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '返点不能大于' . $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']));
        if ($update['fanDianBdw'] > $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] <= 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '不定位返点不能大于' . $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']));
        if (!$update['username'])
            $this->outputData(1, array(), '用户名不能为空，请重新操作');
        if ($update['type'] != 0 && $update['type'] != 1)
            $this->outputData(1, array(), '类型出错，请重新操作');

        if (!ctype_alnum($update['username']))
            $this->outputData(1, array(), '用户名包含非法字符,请重新输入');
//		if(!ctype_digit($update['qq'])) $this->outputData(1,array(),'QQ包含非法字符');

        $userlen = strlen($update['username']);
        $passlen = strlen($update['password']);
        $qqlen = strlen($update['qq']);

        if ($userlen < 4 || $userlen > 16)
            $this->outputData(1, array(), '用户名长度不正确,请重新输入');
        if ($passlen < 6)
            $this->outputData(1, array(), '密码至少六位,请重新输入');
//		if($qqlen<4 || $qqlen>13) $this->outputData(1,array(),'QQ号为4-12位,请重新输入');

        $update['parentId'] = $this->user['uid'];
        $update['parents'] = $this->user['parents'];
        $update['password'] = md5($update['password']);

        $update['regIP'] = $this->ip(true);
        $update['regTime'] = $this->time;

        if (!$_POST['nickname'])
            $update['nickname'] = '未设昵称';
        if (!$_POST['name'])
            $update['name'] = $update['username'];

        //$subCount=$this->getValue("select count(*) from {$this->prename}members where parentId=?", $this->user['uid']);
        //$this->outputData(1,array(),$subCount);
        //if($subCount>=$this->user['subCount']) $this->outputData(1,array(),'您的会员人数已经达到上限');
        // 查检返点设置
        if ($update['fanDian']) {
            $this->getSystemSettings();
            if ($update['fanDian'] % $this->settings['fanDianDiff'])
                $this->outputData(1, array(), sprintf('返点只能是%.1f%的倍数', $this->settings['fanDianDiff']));

            $count = $this->getMyUserCount();
            $sql = "select userCount, (select count(*) from {$this->prename}members m where m.parentId={$this->user['uid']} and m.fanDian=s.fanDian) registerCount from {$this->prename}params_fandianset s where s.fanDian={$update['fanDian']}";
            $count = $this->getRow($sql);
            //$this->outputData(1,array(),$sql);
            //$this->outputData(1,array(),sprintf('注册人数：%d，总人数：%d', $count['registerCount'], $count['userCount']));

            if ($count && $count['registerCount'] >= $count['userCount'])
                $this->outputData(1, array(), sprintf('对不起返点为%.1f的下级人数已经达到上限', $update['fanDian']));
        }else {
            $update['fanDian'] = 0.0;
        }

        $this->beginTransaction();
        try {
            $sql = "select username from {$this->prename}members where username=?";
            if ($this->getValue($sql, $update['username']))
                $this->outputData(1, array(), '用户“' . $update['username'] . '”已经存在');
            if ($this->insertRow($this->prename . 'members', $update)) {
                $id = $this->lastInsertId();
                $sql = "update {$this->prename}members set parents=concat(parents, ',', $id) where `uid`=$id";
                $this->update($sql);
                if (empty($this->user['parentId'])) {
                    $domain_id = intval($_POST['domain']);
                    $sql = "insert into {$this->prename}agency_domain (`enable`,`uid`,`domain_id`) values(1,$id,$domain_id)";
                    if (!$this->sexec($sql)) {
                        $this->outputData(1, array(), '添加会员失败,域名已经被使用，请刷新获取最新有效域名');
                        $this->rollBack();
                    }
                    $sql = "CREATE TABLE `ssc_data_$id` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `type` tinyint(3) unsigned NOT NULL COMMENT '时时彩种类，对应ssc_type.id',
                        `time` int(11) NOT NULL COMMENT '开奖时间',
                        `number` varchar(32) NOT NULL COMMENT '期号(场次)',
                        `data` varchar(80) NOT NULL COMMENT '开奖号码，半角逗号分开',
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `type` (`type`,`number`),
                        KEY `time` (`time`) USING BTREE,
                        KEY `data` (`data`)
                      ) ENGINE=MyISAM AUTO_INCREMENT=2693 DEFAULT CHARSET=latin1 COMMENT='开奖数据'";
                    if (!$this->insert($sql)) {
                        $this->outputData(1, array(), '添加会员失败,创建代理开奖数据失败');
                        $this->rollBack();
                    }
                }
                $this->commit();

                $this->outputData(0, array(), '添加会员成功');
            } else {
                $this->outputData(1, array(), '添加会员失败');
            }
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public final function userUpdateed() {
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
        $urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
        $urlcheck = substr($urlshang, 7, strlen($urldan));
        if ($urlcheck <> $urldan)
            $this->outputData(1, array(), '数据包被非法篡改，请重新操作');

        if (!$_POST)
            $this->outputData(1, array(), '提交数据出错，请重新操作');

        //过滤未知字段
        $update['type'] = intval($_POST['type']);
        $update['uid'] = intval($_POST['uid']);
        $update['fanDian'] = floatval($_POST['fanDian']);
        $update['fanDianBdw'] = floatval($_POST['fanDianBdw']);
        $uid = $update['uid'];

        if ($update['fanDian'] < 0)
            $this->outputData(1, array(), '分成不能小于0');
        if ($update['fanDianBdw'] < 0)
            $this->outputData(1, array(), '不定位不能小于0');
        $fandian = $this->getvalue("select fanDian from {$this->prename}members where uid=?", $update['uid']);
        $fanDianBdw = $this->getvalue("select fanDianBdw from {$this->prename}members where uid=?", $update['uid']);
        if ($update['fanDian'] < $fandian)
            $this->outputData(1, array(), '返点不能降低!');
        if ($update['fanDianBdw'] < $fanDianBdw)
            $this->outputData(1, array(), '不定位返点不能降低!');
        if ($update['fanDian'] > $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '分成不能大于' . $this->iff($this->user['fanDian'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDian'] - $this->settings['fanDianDiff']));
        if ($update['fanDianBdw'] > $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']))
            $this->outputData(1, array(), '不定位返点不能大于' . $this->iff($this->user['fanDianBdw'] - $this->settings['fanDianDiff'] < 0, 0, $this->user['fanDianBdw'] - $this->settings['fanDianDiff']));
        if ($update['type'] != 0 && $update['type'] != 1)
            $this->outputData(1, array(), '类型出错，请重新操作');

        if ($uid == $this->user['uid'])
            $this->outputData(1, array(), '不能修改自己的返点');
        if (!$parentId = $this->getvalue("select parentId from {$this->prename}members where uid=?", $uid))
            $this->outputData(1, array(), '此会员不存在!');
        if ($parentId != $this->user['uid'])
            $this->outputData(1, array(), '此会员不是你的直属下线，无法修改');

        if (!$_POST['fanDian']) {
            unset($_POST['fanDian']);
            unset($update['fanDian']);
        }
        if (!$_POST['fanDianBdw']) {
            unset($_POST['fanDianBdw']);
            unset($update['fanDianBdw']);
        }
        if ($update['fanDian'] == 0)
            $update['fanDian'] = 0.0;
        if ($update['fanDianBdw'] == 0)
            $update['fanDianBdw'] = 0.0;

        $update['tctype'] = intval($_POST['tctype']);
        $update['tcpoint'] = ($update['tctype'] ? floatval($_POST['tcpoint']) : 0);
        if ($update['tctype'] == 1) {
            if ($update['tcpoint'] < 0)
                $this->outputData(1, array(), '分成不能小于0');
            $tcpoint = $this->getvalue("select tcpoint from {$this->prename}members where uid=?", $update['uid']);
            if ($update['tcpoint'] < $tcpoint)
                $this->outputData(1, array(), '分成不能降低!');
            if ($update['tcpoint'] > $this->iff($this->user['tcpoint'] - $this->settings['tcpointDiff'] < 0, 0, $this->user['tcpoint'] - $this->settings['tcpointDiff']))
                $this->outputData(1, array(), '分成不能大于' . $this->iff($this->user['tcpoint'] - $this->settings['tcpointDiff'] < 0, 0, $this->user['tcpoint'] - $this->settings['tcpointDiff']));
        }

        if ($this->updateRowss($this->prename . 'members', $update, "uid=$uid")) {
            $this->outputData(0, array(), '修改成功');
        } else {
            $this->outputData(1, array(), '未知出错');
        }
    }

    /* 额度转移 */

    public final function userUpdateed2() {
        $urlshang = $_SERVER['HTTP_REFERER']; //上一页URL
        $urldan = $_SERVER['HTTP_X_REAL_HOST']; //本站域名
        $urlcheck = substr($urlshang, 7, strlen($urldan));
        if ($urlcheck <> $urldan)
            $this->outputData(1, array(), '数据包被非法篡改，请重新操作');

        if (!$para = $_POST)
            $this->outputData(1, array(), '提交数据出错，请重新操作');

        if ($this->settings['recharge'] == 1) {
            $uid = intval($para['uid']);
            $uid2 = $this->user['uid'];
            $para['coin'] = floatval($para['coin']);
            if ($para['coin'] < 1 || $para['coin'] > 10000)
                $this->outputData(1, array(), '只能充值1-10000元');
            if (!$para['coin'])
                unset($para['coin']);

            $this->beginTransaction();
            try {
                $sql = "select * from {$this->prename}members where uid=?";
                $userData = $this->getRow($sql, $uid2);
                if (!$userData2 = $this->getRow($sql, $uid))
                    $this->outputData(1, array(), '此会员不存在!');

                if ($userData2['parentId'] != $uid2)
                    $this->outputData(1, array(), '此会员不是的你的直属会员，请重新选择！');
                if (!$userData2['enable'])
                    $this->outputData(1, array(), '此会员已被冻结，无法转移！');
                if ($userData['coin'] <= 0)
                    $this->outputData(1, array(), '余额不足，请先充值！');
                if ($userData['coin'] < $para['coin'])
                    $this->outputData(1, array(), '可用余额小于充值金额，请先充值！');
                $abc['coin'] = $userData['coin'] - $para['coin'];
                $def['coin'] = $userData2['coin'] + $para['coin'];

                $this->addCoin(array(
                    'uid' => $uid2,
                    'coin' => -$para['coin'],
                    'liqType' => 110,
                    //'extfield0'=>$id,
                    'extfield0' => 0,
                    'extfield1' => 0,
                    'info' => '给下级' . $userData2['username'] . '充值扣款金额'
                )); //上级充值成功扣款结束
                $this->addCoin(array(
                    'uid' => $uid,
                    'coin' => $para['coin'],
                    'liqType' => 109,
                    //'extfield0'=>$id,
                    'extfield0' => 0,
                    'extfield1' => 0,
                    'info' => '上级' . $userData['username'] . '充值金额'
                )); //上级充值结束

                $this->commit();
                $this->outputData(0, array(), '充值成功');
                unset($uid2);
                unset($uid);
                unset($abc['coin']);
                unset($def['coin']);
                unset($userData);
                unset($userData2);
            } catch (Exception $e) {
                $this->rollBack();
                throw $e;
            }
        } else {
            $this->outputData(1, array(), '上级充值功能已经关闭！');
        }
    }

}
