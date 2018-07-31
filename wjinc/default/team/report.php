<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '盈亏报表'); ?>
<script type="text/javascript">
$(function(){
	$('.search form input[name=username]')
	.focus(function(){
		if(this.value=='用户名') this.value='';
	})
	.blur(function(){
		if(this.value=='') this.value='用户名';
	})
	.keypress(function(e){
		if(e.keyCode==13) $(this).closest('form').submit();
	});

	$('.chazhao').click(function(){
		$(this).closest('form').submit();
	});

	$('.bottompage a[href]').live('click', function(){
		$('.biao-cont').load($(this).attr('href'));
		return false;
	});
});
function searchData(err, data){
	if(err){
		alert(err);
	}else{
		$('.biao-cont').html(data);
	}
}
</script>
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	<?php

	$fromTime=strtotime(date('Y-m-d 00:00:00'));
	$toTime=strtotime(date('Y-m-d 10:00:00'));
    $fromTime2=strtotime(date('Y-m-d 23:00:00'));
    $toTime2=strtotime(date('Y-m-d 23:59:59'));
    if((time()>$fromTime && time()<$toTime) || ($fromTime2<time() && $toTime2>time()))
	{

		?>
	<div class="search">
  		<form action="/index.php/team/searchReport" target="ajax" call="searchData" dataType="html">
        <input height="20" value="用户名" name="username"/>
        <input type="text" name="fromTime" class="datainput"  value="<?=$this->iff($_REQUEST['fromTime'],$_REQUEST['fromTime'],date('Y-m-d H:i:s',$GLOBALS['fromTime']))?>"/>至<input type="text" name="toTime"  class="datainput" value="<?=$this->iff($_REQUEST['toTime'],$_REQUEST['toTime'],date('Y-m-d H:i:s',$GLOBALS['toTime']))?>"/>
         
      <input type="button" value="查 询" class="btn chazhao">
  </form> 
    </div>
    <div class="display biao-cont">
    	 <!--列表-->
	    <?php

		    $this->display('team/report-list.php');
	    ?>
        <!--列表 end -->
    </div>
	<?php
	}
	else
	{
		echo '开放时间早上 23:00~10:00';
		echo '<script>alert("开放时间早上 23:00~10:00");</script>';
	}
	?>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 