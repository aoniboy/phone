// JavaScript Document
function ss(s1)
{var qq='';
	$("input[name='"+s1+"[]']").each(function(){
    	        if($(this).prop("checked") =='checked' || $(this).prop("checked") ==true){
            qq=qq+$(this).val();
}});
return qq;
	}

function sst(s1)
{var qq='';
	$("input[name='"+s1+"[]']").each(function(){
    	        if($(this).prop("checked") =='checked' || $(this).prop("checked") ==true){
            qq=qq+","+$(this).val();
}});
try {qq=qq.substring(1);}catch(err){}
return qq;
	}	

function combin(basenum,choosen)
{
if (basenum * choosen < 0)	return false;		
		if (!basenum && (choosen != 0))	return false;	
		if (basenum && !choosen)	return 1;
		var a,b,i;
		a = b = 1;
		for(i = 0;i < choosen;i++){
			a *= basenum - i;
			b *= choosen - i;                       
		}
		return a / b;
}
function sscsum(){
var aa=$("input[name='typeok']").val();
var check=aa.split('_')[1];
var aa0=aa.split('_')[0];
var sum=0;
if (aa0=="lhc" || aa0=="jx1" || aa0=="cqy" || aa0=="gdy" || aa0=="am1"){ 	
if ((check=="38")||(check=="48")||(check=="49")||(check=="50")||(check=="51")||(check=="52")||(check=="53"))
{sum=sst('s1').split(",").length;
}
else
{
s1=sst('s1').split(",").length;;
sum=combin(s1,check);	
	}
}
if (aa0=="ssc" || aa0=="xjc" || aa0=="hkc" || aa0=="xsc" || aa0=="plw" || aa0=="pls" || aa0=="fsd" || aa0=="ssl" || aa0=="ams"){ 	
if (check=="22" || check=="2" || check=="29"){ 
sum=0;
var s1 =ss('s1').length;
var s2 =ss('s2').length;
var s3 =ss('s3').length;
sum=sum+s1*s2*s3;
} 
else if (check=="0")
{
var s1 =ss('s1').length;
var s2 =ss('s2').length;
var s3 =ss('s3').length;	
var s4 =ss('s4').length;
var s5 =ss('s5').length;
sum=sum+s1*s2*s3*s4*s5;		
}
else if ((check=="31")||(check=="33"))
{
var s1 =ss('s1').length;
var s2 =ss('s2').length;
var s3 =ss('s3').length;	
var s4 =ss('s4').length;
sum=sum+s1*s2*s3*s4;		
}
else if (check=="21" || check=="23" || check=="1" || check=="40" || check=="3" || check=="10" || check=="13" || check=="30" || check=="32" || check=="34" || check=="35") { 
var s1=$("#textarea").val();
var reg=new RegExp("\r\n","g");
s1=s1.replace(reg,",");
s1=s1.replace(/ /g,",");
s1=s1.replace(/\n/g,",");
sum=s1.split(',').length;
}
else if (check=="24" || check=="4" || check=="36"){ 
sum=0;
var s1 =ss('s6').length;
sum=s1*s1-s1;
}
else if (check=="25" || check=="5" || check=="39"){ 
sum=0;
var s1 =ss('s6').length;
var zhushu=0;
switch (s1) {
case 3: 
  zhushu=1;
  break;
case 4:
  zhushu=4;
  break;
case 5:
  zhushu=10;
  break;
case 6:
  zhushu=20;
  break;
case 7:
  zhushu=35;
  break;
case 8:
  zhushu=56;
  break;
case 9:
  zhushu=84;
  break;
case 10:
  zhushu=120;
  break;
}
sum=zhushu;
}
else if (check=="26" || check=="6" || check=="41") { 
sum=0;
var s1 =ss('s6').length;
if (s1>0){
var s1 =sst('s6').split(",");
te="1,3,6,10,15,21,28,36,45,55,63,69,73,75,75,73,69,63,55,45,36,28,21,15,10,6,3,1";
te=te.split(",");
for (var i=0; i < s1.length; i++)
{sum=sum+parseInt(te[s1[i]]);}
}
}
else if (check=="27" || check=="7") { 
sum=0;
var s1 =ss('s6').length;
if (s1>0){
var s1 =sst('s6').split(",");
te="0,1,2,2,4,5,6,8,10,11,13,14,14,15,15,14,14,13,11,10,8,6,5,4,2,2,1,0";
te=te.split(",");
for (var i=0; i < s1.length; i++)
{sum=sum+parseInt(te[s1[i]]);}
}
}
else if  (check=="9" || check=="12" || check=="18" || check=="20" || check=="8" || check=="28" || check=="37") {
sum=0;
var s1 =ss('s1').length;
sum=sum+s1;
}
else if  (check=="50" || check=="51" || check=="52") {
sum=0;
if ($("input[name='asl']:checked").val()!="");
sum=sum+1;
}
else if  (check=="11" || check=="14" || check=="15") { 
sum=0;
var s1 =ss('s1').length;
var s2 =ss('s2').length;
sum=sum+s1*s2;
}
else if ((check=="17")||(check=="19")) { 
sum=0;
var s1 =ss('s6').length;
sum=sum+s1*(s1-1)/2;
}
else if  ((check=="16") && (aa0=="ssc" || aa0=="xjc" || aa0=="hkc" || aa0=="xsc" || aa0=="plw" || aa0=="ams")){ 
sum=0;
var s1 =ss('s1').length;
var s2 =ss('s2').length;
var s3 =ss('s3').length;
var s4 =ss('s4').length;
var s5 =ss('s5').length;
sum=sum+s1+s2+s3+s4+s5;
}
else if  ((check=="16") && (aa0=="pls" || aa0=="fsd" || aa0=="ssl" )){ 
sum=0;
var s1 =ss('s1').length;
var s2 =ss('s2').length;
var s3 =ss('s3').length;
sum=sum+s1+s2+s3;
}
}
return sum;
}