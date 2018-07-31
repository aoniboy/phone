// JavaScript Document
jQuery(document).ready(function() { 
$("input[id]").bind("focus",function () { 
if($(this).attr("id")=='username'||$(this).attr("id")=='password'|| $(this).attr("id")=='code') 
$(this).select(); 
}); 
$("#vcode").bind("click",function () { 
$("#vcode").attr("src","checkCode.php?r="+Math.random()); 
}); 


$("#submit").bind("click", function() { 
if (valid()) {
$(this).attr("value","正在登录...");
$(this).button('refresh');
$(this).button('disable'); 
$.ajax({ 
type: "POST", 
url: "login.php", 
data: $("form#loginform").serialize(), 
success: function(msg){
if(msg.indexOf('0')>0 || msg=='0'){ 
$.mobile.changePage("/main.html","slidedown", true, true); 
}else{
$("#submit").val("登录");	
$("#submit").button('refresh');
$("#submit").button('enable');	 
$("#error1").html(msg);
$("#error1").popup();
$("#error1").popup("open");
} 
} 
}); 
} 
}); 
});

function valid(){ 
if($("#username").val()==''||$("#password").val()=='' || $("#code").val().length!==6) { 
$("#info").popup();
$("#info").popup("open");
return false; 
} 
return true; 
}
window.onerror=function(){return true;}