<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php $this->display('inc_skin.php', 0 , '推广链接 - 代理中心'); ?>
<!--//复制程序 flash+js-->
<script language="JavaScript">
function Alert(msg) {
	alert(msg);
}
function thisMovie(movieName) {
	 if (navigator.appName.indexOf("Microsoft") != -1) {   
		 return window[movieName];   
	 } else {   
		 return document[movieName];   
	 }   
 } 
function copyFun(ID) {
	thisMovie(ID[0]).getASVars($("#"+ID[1]).attr('value'));
}
</script>
<!--//复制程序 flash+js------end-->
</head> 
 
<body>
<div id="mainbody"> 
<?php $this->display('inc_header.php'); ?>
<div class="pagetop"></div>
<div class="pagemain">
	<div class="search">

      <input type="button" value="添加链接" class="btn" onclick="window.location='/index.php/team/addlink'">
      
    </div>
    <div class="display biao-cont">
    	<?php
	$sql="select * from {$this->prename}links where uid={$this->user['uid']}";
	
	if($_GET['uid']=$this->user['uid']) unset($_GET['uid']);
	$data=$this->getPage($sql, $this->page, $this->pageSize);
	?>
	<table width="100%" class='table_b'>
	<thead>
		<tr class="table_b_th">
			<td>编号</td>
            <td>类型</td>
			<td>返点</td>
            <td>不定位返点</td>
			<td>操作</td>
		</tr>
	</thead>
	<tbody class="table_b_tr">
	<?php if($data['data']) foreach($data['data'] as $var){ ?>
		<tr>
			<td><?=$var['lid']?></td>
			<td><?php if($var['type']){echo'代理';}else{echo '会员';}?></td>
			<td><?=$var['fanDian']?>%</td>
            <td><?=$var['fanDianBdw']?>%</td>
           
			<td><a href="/index.php/team/linkUpdate/<?=$var['lid']?>" style="color:#333;" target="modal"  width="350" title="修改注册链接" modal="true" button="确定:dataAddCode|取消:defaultCloseModal">修改</a> | <a href="/index.php/team/getLinkCode/<?=$var['lid']?>" button="取消:defaultCloseModal" modal="true" title="获取链接" width="350" target="modal"  style="color:#333;">获取链接</a> | <a  href="/index.php/team/linkDelete/<?=$var['lid']?>" button="确定删除:dataAddCode" modal="true" title="删除注册链接" width="350" target="modal"  style="color:#333;">删除</a> </td>
           
		</tr>
	<?php } ?>
	</tbody>
</table>
        <script>
            // 思路：要想复制到剪贴板，必须先选中这段文字。
            function copyNum() {
                var NumClip=document.getElementById("adv-url");
                var NValue=NumClip.value;
                var valueLength = NValue.length;
                selectText(NumClip, 0, valueLength);
                document.execCommand("Copy","false",null); // 执行浏览器复制命令
                alert("已复制,可分享给朋友啦，试试看。");
            }
            // input自带的select()方法在苹果端无法进行选择，所以需要自己去写一个类似的方法
            function selectText(obj, startIndex, stopIndex) {
                if (obj.setSelectionRange) {
                    obj.setSelectionRange(startIndex, stopIndex);
                } else if (obj.createTextRange) {
                    var range = obj.createTextRange();
                    range.collapse(true);
                    range.moveStart('character', startIndex);
                    range.moveEnd('character', stopIndex - startIndex);
                    range.select();
                }
                obj.focus();
            }
        </script>
	<?php 
        $this->display('inc_page.php',0,$data['total'],$this->pageSize, '/index.php/team/linkList-{page}');
    ?>
    </div>
<?php $this->display('inc_footer.php'); ?> 
</div>
<div class="pagebottom"></div>
</div>

</body>
</html>
  
   
 