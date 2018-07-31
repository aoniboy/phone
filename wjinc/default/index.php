<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->display('inc_skin.php',0,'首页'); ?>
<!--title></title-->
<link href="/skin/main/home.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
        $(document).ready(function () {
            $(".phbtbl").each(function () {
                $(this).find('tr:even').addClass("phbtbl_color");
            });
            $(".phbtbl td span:eq(0)").html("&nbsp;").addClass("jp");
            $(".phbtbl td span:eq(1)").html("&nbsp;").addClass("yp");
            $(".phbtbl td span:eq(2)").html("&nbsp;").addClass("tp");
            $(".phbtbl td span").css("backgroundColor", "#d70002");

            $(".tipstxt:first").css("display", "block");
            $("ul.tipslist li a").click(
              function toggle() {
                  $(".tipstxt").css("display", "none");
                  $(this).parent().find("span").css("display", "block")
              });
            var _length=$(".tipstxt").length;
            var _height = 250 - (_length - 1) * 25;
            $(".tipstxt").css("height", _height);
        })
</script>
</head>
<body ondrag="return false;">
<div id="mainbody">
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
<div class="homelayout">
  <div class="homelist">
    <ul class="clist">
      <li><a href="/index.php/index/game/1/2"> <img alt="" src="/images/index/c1.png"><span>重庆时时彩</span></a></li>
      <li><a href="/index.php/index/game/14/59"> <img alt="" src="/images/index/c1.png"><span>幸运300秒</span></a></li>
        <li><a href="/index.php/index/game/12/2"> <img alt="" src="/images/index/c1.png"><span>新疆时时彩</span></a></li>
<!--      <li><a href="/index.php/index/game/27/59"> <img alt="" src="/images/index/c1.png"><span>三分时时彩</span></a></li>-->
<!--      <li><a href="/index.php/index/game/26/59"> <img alt="" src="/images/index/c1.png"><span>二分时时彩</span></a></li>-->
<!--      <li><a href="/index.php/index/game/5/59"> <img alt="" src="/images/index/c1.png"><span>极速分分彩</span></a></li>-->
      <li><a href="/index.php/index/game/6/10"> <img alt="" src="/images/index/c4.png"><span>广东11选5</span></a></li>
      <li><a href="/index.php/index/game/7/10"> <img alt="" src="/images/index/c4.png"><span>山东11选5</span></a></li>
      <li><a href="/index.php/index/game/16/10"> <img alt="" src="/images/index/c4.png"><span>江西多乐彩</span></a></li>
      <li><a href="/index.php/index/game/25/39"> <img alt="" src="/images/index/c3.png"><span>江苏快三</span></a></li>
      <li><a href="/index.php/index/game/52/39"> <img alt="" src="/images/index/c3.png"><span>广西快三</span></a></li>
      <li><a href="/index.php/index/game/50/39"> <img alt="" src="/images/index/c3.png"><span>湖北快三</span></a></li>
      <li><a href="/index.php/index/game/9/16"> <img alt="" src="/images/index/c5.png"><span>福彩3D</span></a></li>
      <li><a href="/index.php/index/game/10/16"> <img alt="" src="/images/index/c6.png"><span>体彩P3</span></a></li>
      <li><a href="/index.php/index/game/20/26"> <img alt="" src="/images/index/c8.png"><span>北京PK10</span></a></li>
<!--       <li><a href="/index.php/index/game/30/81"> <img alt="" src="/images/index/c88.png"><span>天天六合彩</span></a></li>-->
    </ul>
    <div class="clear"></div>
  </div>
  <div class="homebox">
    <?php if($this->settings['paihang']==1){?>
    <div class="homeboxleft">
      <div class="hometitle" id="phb">即时中奖排行榜</div>
      <div id="andyscroll">
        <div id="scrollmessage"> </div>
      </div>
      <script type="text/javascript">
var stopscroll = false;
var scrollElem = document.getElementById("andyscroll");
var marqueesHeight = scrollElem.style.height;
scrollElem.onmouseover = new Function('stopscroll = true');
scrollElem.onmouseout  = new Function('stopscroll = false');
var preTop = 0;
var currentTop = 0;
var stoptime = 0;
var leftElem = document.getElementById("scrollmessage"); 
scrollElem.appendChild(leftElem.cloneNode(true));
init_srolltext();
function init_srolltext(){
    scrollElem.scrollTop = 0;
    setInterval('scrollUp()', 100);//确定滚动速度的, 数值越小, 速度越快
}
function scrollUp(){
    if(stopscroll) return;
    currentTop += 2; //设为1, 可以实现间歇式的滚动; 设为2, 则是连续滚动
    if(currentTop == 19) {
        stoptime += 1;
        currentTop -= 1;
        if(stoptime == 180) {
            currentTop = 0;
            stoptime = 0;
        }
    }else{
        preTop = scrollElem.scrollTop;
        scrollElem.scrollTop += 1;
        if(preTop == scrollElem.scrollTop){
            scrollElem.scrollTop = 0;
            scrollElem.scrollTop += 1;
        }
    }
}
</script>
      <style type="text/css">
<!--
ul{
margin:0px;
padding:0px;
list-style:none;
}
#andyscroll {
    overflow: hidden;
    padding: 0 13px;
    text-align:left;
    line-height:3em;
    width:440px;
    height:277px;
    overflow:hidden;
}
-->
</style>
    </div>
    <div class="homeboxright">
      <?}else{?>
      <div class="homeboxright" style="width:950px;">
        <?}?>
        <!--div class="hometitle" id="tips">通知公告<a href="/index.php/notice/info">更多...</a></div>
  <ul class="tipslist">
  <?php
            $data=$this->getRows("select id,title,content,addtime from {$this->prename}content where nodeId=1 and enable=1 order by id desc limit 4");
            if($data) foreach($data as $var){ 
            echo "<li><a href=\"#\">{$var['title']}</a><em>".date('Y/m/d h:i:s',$var['addtime'])."</em><span class=\"tipstxt\">{$var['content']}</span></li>";
            } 
  ?>
  </ul>
            </div--> 
        
      </div>
    </div>
    <?php $this->display('inc_footer.php'); ?>
  </div>
  <div class="pagebottom"></div>
</div>
<?php $this->display('inc_chat.php'); ?>
</body>
</html>