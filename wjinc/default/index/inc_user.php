<?php $this->freshSession(); 
		//更新级别
		$ngrade=$this->getValue("select max(level) from {$this->prename}member_level where minScore <= {$this->user['scoreTotal']}");
		if($ngrade>$this->user['grade']){
			$sql="update ssc_members set grade={$ngrade} where uid=?";
			$this->update($sql, $this->user['uid']);
		}else{$ngrade=$this->user['grade'];}
		
		$date=strtotime('00:00:00');
?>
	<div class="bodytop">
    <div id="money">
        <tr>
        <td>昵称：<em><?=$this->user['nickname']?></em></td>
        <td>余额：</td>
        <td><strong>￥<?=$this->user['coin']?><a href="#"  onclick="reloadMemberInfo()"><img src="/images/common/ref.png" alt="刷新余额"></a></strong></td>

        <td><!--消息：
        <strong class="msgnum">
        <a href="/">0</a>
        </strong-->
        <a onclick="boekf();">充值</a>
        <a href="/index.php/cash/toCash">提款</a>
<!--        <a href="http://www.chinacqcp.com/kf.html" target="_blank">客服</a>-->
            <a onclick="boekf();" title="联系" style="">客服</a>
        <a href="/index.php/user/logout">退出</a>
        </td>
        </tr>
	</div>
</div>



<script type='text/javascript'>
    function boekf(){
        <?php if($this->settings['kefuStatus']){ ?>
        var iTop = (window.screen.availHeight-30-570)/2; //获得窗口的垂直位置;
        var iLeft = (window.screen.availWidth-10-750)/2; //获得窗口的水平位置;
        var url = '<?=$this->settings['kefuGG']?>';
        var winOption = "height=570,width=750,top="+iTop+",left="+iLeft+",toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,fullscreen=1";
        var newWin = window.open(url,window, winOption);
        <?php }else{?>
        alert("客服系统正在维护，程序猿在拼命打代码，请稍后访问！");
        <?php }?>
        return false;
    }
</script>
