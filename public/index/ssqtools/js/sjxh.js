  var isCorrect=false;
  var isTrue=false;
  var lianha=false;
  var iMilliSeconds=800;
  var iAt=0;
  var iMax=6;
  var numberStr=null;
  var aryNo=null;
  var breaki=0;
  var number_hz=0;
  var blue=0; 
  
  var not_BH2=document.getElementById('not_BH2');
  var not_BH1=document.getElementById('not_BH1'); 
  var BH2=document.getElementById('BH2');   
  var BH1=document.getElementById('BH1');    
  var divAC=document.getElementById('divAC');
  var divBlue=document.getElementById('divBlue');
  var divToDo=document.getElementById('divToDo');
  var divNo_0=document.getElementById('divNo_0');
  var divNo_1=document.getElementById('divNo_1');
  var divNo_2=document.getElementById('divNo_2');
  var divNo_3=document.getElementById('divNo_3');
  var divNo_4=document.getElementById('divNo_4');
  var divNo_5=document.getElementById('divNo_5');
  var divHZ=document.getElementById('divHZ');
  var B_is=document.getElementById('B_is');
  var B_is_J=document.getElementById('B_is_J');
  var B_is_D=document.getElementById('B_is_D');
  var JO=document.getElementById('JO');
  var DX=document.getElementById('DX');
  var searchStart=document.getElementById('searchStart');
  var searchEnd=document.getElementById('searchEnd');
  var lianhao=document.getElementById('lianhao');
  //divToDo.innerHTML="请选择执行条件！如果条件太苛刻，要等待一个相对较长的时间。"
  divNo_0.innerHTML=""
  divNo_1.innerHTML=""
  divNo_2.innerHTML=""
  divNo_3.innerHTML=""
  divNo_4.innerHTML=""
  divNo_5.innerHTML=""
  divHZ.innerHTML=""
  var ary1=new Array(7);
  ary1[0]=21;ary1[1]=32;ary1[2]=45;ary1[3]=60;ary1[4]=77;ary1[5]=96;ary1[6]=117;
  var ary2=new Array(7);
  ary2[0]=81;ary2[1]=103;ary2[2]=123;ary2[3]=140;ary2[4]=157;ary2[5]=171;ary2[6]=183;
  
function getAll(){
   clearAll()

    //蓝球条件
  
  var b_jo_sj=false
  var b_jo=true
  var b_dx_sj=false
  var b_dx=true
  if(B_is.value==100){//这种情况下是产生的号码随机
     b_jo_sj=true;
     b_dx_sj=true;
  
  }else{
      b_jo_sj=false;
      b_dx_sj=false;
  }

  if(B_is_J.value==2){
          b_jo_sj=true;
          b_jo=true;
   }
      
  if(B_is_J.value==1){
          b_jo_sj=true;
          b_jo=false;
      }      
   if(B_is_J.value==0){
          b_jo_sj=false;
          b_jo=false;
      }          
   if(B_is_D.value==2){
          b_dx_sj=true;
          b_dx=true;
       }
   if(B_is_D.value==1){
          b_dx_sj=true;
          b_dx=false;
   }
   if(B_is_D.value==0){
          b_dx_sj=false;
          b_dx=false;
   }
      
  if(B_is.value==100){//这种情况下是产生的号码随机         
     blue =getBlur(b_jo_sj,b_jo,b_dx_sj,b_dx);
  }else{
     blue=B_is.value;
  }
  if(blue<10){
    blue="0"+blue
        //alert(blue)
  }      
  
   var jo_=JO.value;
   var jo_sj=false; 
   if(jo_!=100){ jo_sj=true; }             
   var dx_=DX.value;
   var dx_sj=false;
   if(dx_!=100){dx_sj=true;}      
  //判断范围
   var fw_x=searchStart.value;       
   var fw_d=searchEnd.value;
   if(fw_x==""){
      fw_x=21;
   }
   if(fw_d==""){
      fw_d=183;
   }
   var fw_sj=false;
   if(!isNum(fw_x)||!isNum(fw_d)){          
     alert("请输入合法的范围！");
     return false;
  }
   if(fw_x!=21||fw_d!=183){
      fw_sj=true;
   }
   if(fw_x<21||fw_d<21){
    alert("最小范围不能比21小！");
    return false;
   }
   if(fw_d>183||fw_x>183){
     alert("最大范围不能比183大！");
     return false;
   }
   if(fw_sj&&dx_!=100&&checkDX_fw(dx_,fw_x,fw_d)){       
      return false;
   }
        
   //判断连号
  var lh_sj=false;
  var lh_;
  for(var i=0;i<2;i++){
    if(document.getElementById("lianhao"+i).checked==true){
        lh_=document.getElementById("lianhao"+i).value;
    }
    
   }       
   if(lh_==2){
      lh_sj=false;         
   }else{
      lh_sj=true;
      if(lh_==0){             
        lianha=true;
      }else{
         lianha=false;            
         }
   }

   //包含号码
   var bh_1=new Array();
   var bh1_=BH1.value;
   var bh2_=BH2.value;
   var bh_sj=false;
   if(bh1_!=100||bh2_!=100){
      bh_sj=true;
   }
    if((bh1_!=100&&bh2_!=100)&&(bh1_==bh2_)){
      alert("在一注号码中不能出现两个相同的数！");
      return false;
   }
   if(bh1_!=100&&bh2_!=100){
      bh_1=new Array(2);
      bh_1[0]=bh1_;
      bh_1[1]=bh2_;
   }
   if(bh1_!=100&&bh2_==100){
     bh_1=new Array(1);
      bh_1[0]=bh1_;
   }
   if(bh2_!=100&&bh1_==100){
     bh_1=new Array(1);
      bh_1[0]=bh2_;
   }
   
   //判断是否连号是否和包含冲突 
if(lh_sj&&(!lianha)&&bh_sj&&(bh_1.length>1)){     
  if((bh_1[0]==(bh_1[1]-1))){
   alert("出错，号码中出现连号与条件不符！");
   return false;
 }
  if((bh_1[1]==(bh_1[0]-1))){
   alert("出错，号码中出现连号与条件不符！");
   return false;
 }

}
   //不包含号码
   var bh_2=new Array();
   var notbh1_=not_BH1.value;
   var notbh2_=not_BH2.value;
   var notbh_sj=false;
   if(notbh1_!=100||notbh2_!=100){
      notbh_sj=true;
   }
   if(notbh1_!=100&&notbh2_!=100){
      bh_2=new Array(2);
      bh_2[0]=notbh1_;
      bh_2[1]=notbh2_;       
   }
   if(notbh1_!=100&&notbh2_==100){
      bh_2=new Array(1);
      bh_2[0]=notbh1_;       
   }
    if(notbh1_==100&&notbh2_!=100){
      bh_2=new Array(1);
      bh_2[0]=notbh2_;       
   }
//判断jo和dx
if(bh_sj){
//jo_
var k=0;
var kd=0;
for(i=0;i<bh_1.length;i++){
   if(bh_1[i]%2==0){
     k++;
   }
   if(bh_1[i]>16){
     kd++;
   }
}
if(k>jo_){
 alert("出错，出号号码中的奇偶个数与条件奇偶比矛盾!")
 return false;
}
if(kd>dx_){
 alert("出错，出号号码中的大小个数与条件大小比矛盾!")
 return false;
}
k=0;kd=0;
}

//判断包含与不包含是否冲突
 if(bh_sj&&notbh_sj){
     for(i=0;i<bh_1.length;i++){
        for(j=0;j<bh_2.length;j++){
           if(bh_1[i]==bh_2[j]){
             alert("在包含和不包含条件中，有相同的号码"+bh_1[i]+",这是不允许的！");
             return false;
           }
        }         
     }        
}
   //不包含号码
aryNo=getRandom(33,6);
//var isCorrect=checkAll(aryNo,fw_sj,fw_x,fw_d,bh_sj,bh_1,notbh_sj,bh_2,jo_sj,jo_,dx_sj,dx_,35,lh_sj,lianha);
divToDo.style.display="";
divToDo.innerHTML="<font size=4 color=red><b>请重新选择执行条件！</b></font>"
 
isCorrect=checkAll(aryNo,fw_sj,fw_x,fw_d,bh_sj,bh_1,notbh_sj,bh_2,jo_sj,jo_,dx_sj,dx_,35,lh_sj,lianha);


while(!isCorrect){    
  aryNo=getRandom(33,6);  
  isCorrect=checkAll(aryNo,fw_sj,fw_x,fw_d,bh_sj,bh_1,notbh_sj,bh_2,jo_sj,jo_,dx_sj,dx_,35,lh_sj,lianha);
  if(breaki++>200000){
     isTrue=true;    
     break;
  }
}
  numberStr=aryPX(aryNo);
  genNo();
} 
function clearAll(){       
   isCorrect=false;
   isTrue=false;
   iAt=0;
   blue=0;
   iMax=6;
   numberStr=null;
   aryNo=null;
   divToDo.innerHTML="请选择执行条件！"
   divNo_0.innerHTML=""
   divNo_1.innerHTML=""
   divNo_2.innerHTML=""
   divNo_3.innerHTML=""
   divNo_4.innerHTML=""
   divNo_5.innerHTML=""
   divHZ.innerHTML=""
   divBlue.innerHTML=""
   breaki=0;
   number_hz=0;
   lianha=false;
   divAC.innerText="";
}
function genNo(){       
 divToDo.style.display="none";
 if(isTrue){
divToDo.style.display="";
divToDo.innerHTML="<font size=3>无此条件的出号组合，请重新选择条件！</font>"
 }else{
     number= numberStr[iAt++];
     number_hz+=number;
     if(number<10){
      numberdiv="0"+number;
     }else{
      numberdiv=""+number;
     }
     divToDo.innerHTML="";
//         divToDo.innerHTML="正在产生<font color=\"#ff0000\"> 红球 </font>第<font color=\"#ff0000\"><b> "+iAt+" </b></font>个号码..."
//         divNo.innerHTML+="<img src=\"/gj/ssqjyss/"+numberdiv+".gif\"  vspace=\"5\">"
     if(iAt==1)
     {
     divNo_0.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_0.style.display = "block";
     }
     if(iAt==2)
     {
     divNo_1.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_1.style.display = "block";
     }
     if(iAt==3)
     {
     divNo_2.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_2.style.display = "block";
     }
     if(iAt==4)
     {
     divNo_3.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_3.style.display = "block";
     }
     if(iAt==5)
     {
     divNo_4.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_4.style.display = "block";
     }
     if(iAt==6)
     {
     divNo_5.innerHTML+="<div class=\"redbutton\">"+numberdiv+"</div>";
     divNo_5.style.display = "block";
     }
 
    if(iAt<iMax){        
    window.setTimeout(genNo,iMilliSeconds)
    }else{
    divBlue.innerHTML="<div class=\"bluebutton\">"+blue+"</div>"
    divBlue.style.display = "block";
//        divBlue.innerHTML="<img src=\"/gj/ssqjyss/l/"+blue+".gif\"  vspace=\"5\">"
    divHZ.innerHTML="&nbsp;&nbsp;红球和值：<font size='2' color='FF6600'><b>"+number_hz+"</b></font>";
    divHZ.style.display = "block";
//        divToDo.innerText="号码产生完毕！"
    divAC.innerHTML="红球AC值：<font size='2' color='FF6600'><b>"+getAC(numberStr)+"</b></font>";
    divAC.style.display = "block";
    }
 }
}

function getAllArry(){
aryNo=aryPX(getRandom(33,6));
for(var ii=0;ii<aryNo.length;ii++){
document.writeln(aryNo[ii]);
}
}
//检查是否全部为数字
function isNum(str) {
  var len = 0;
  len = str.length;
  var i = 0;
  for( i=0; i< len; i++) {
      temp = str.substring(i,i+1);
      if (temp >="0" && temp<="9") {
          continue;
      }
      else {
          return false;
      }
  }
  return true;
}
//检查大小范围和选择的大小是否发生了矛盾
function checkDX_fw(n,fw_x,fw_d){
      var num=0;
      var num2=0;
      num=ary1[n];
      num2=ary2[n];                         
      if((!checkQJ(fw_x,num,num2))&&(!checkQJ(fw_d,num,num2))){
       alert("当大小比是"+n+":"+(6-n)+"时，范围值只能在 "+num+" -- "+num2+" 区间!");
       return true;
      }          
    return false;  
}

//判断范围区间是否在a1和b1之间,返回true表示在此区间
function checkQJ(number1,a1,b1){
if(number1>=a1&&number1<=b1){
 return true;
}else{
 return false;
}

}

//得到随机数
//k表示最大数范围，n表示得到几个
function getRandom(k,n){
 ary=new Array(n);
for(var i=0;i<n;){
var tmp=Math.floor(Math.random()*(k-1))+1;  
if(checkCF(ary,tmp,i)){
ary[i++]=tmp;
}
}
return ary;
}
//得到一个蓝球号码,
function getBlur(jo_sj,jo,dx_sj,dx){
 var tmp;
 tmp=Math.round(Math.random()*15)+1;
 var isCorr=false;

 if(jo_sj&&dx_sj){//要求检测奇偶和大小
    if((getJ_O(tmp)==jo)&&(getD_X(tmp)==dx)){
      return tmp;
    }else{
        isCorr=true;
        while(isCorr){
           tmp=Math.round(Math.random()*15)+1;
           if((getJ_O(tmp)==jo)&&(getD_X(tmp)==dx)){
               isCorr=false;      
           }
         }
        return tmp;
    }
  }else if(!jo_sj&&dx_sj){//只要求检测大小
     if(getD_X(tmp)==dx){
      return tmp;
    }else{
      isCorr=true;
        while(isCorr){
           tmp=Math.round(Math.random()*15)+1;
           if(getD_X(tmp)==dx){
               isCorr=false;      
           }
         }
        return tmp;
    }

 }else if(jo_sj&&!dx_sj){//只要求检测奇偶
   if(getJ_O(tmp)==jo){
      return tmp;
    }else{
        isCorr=true;
        while(isCorr){
           tmp=Math.round(Math.random()*15)+1;
           if(getJ_O(tmp)==jo){
               isCorr=false;      
           }
         }
        return tmp;
    }
 }else{     
  return tmp;
 }

}
//检测奇偶
function getJ_O(s){
 if(s%2==0){
   return true;
 }else{
   return false;
 } 
}
//检测大小
function getD_X(s){
 if(s>=8){
  return true;
 }else{
  return false;
 }
}
//检查是否重复
function checkCF(ary1,t,n){     
 for(var i=0;i<n;i++){
    if(ary1[i]==t){
      return false;        
    }
 }  
// document.writeln(t);
 return true;
}
//冒泡排序
function aryPX(str){
   var number=0;
   var length=str.length;
  for(var i=0;i<length;i++){
      for(var j=length-1;j>i;j--){
            if(str[j]<str[j-1]){
              number  = str[j];
               str[j]  = str[j-1];
               str[j-1]= number;
              }
         }
   }
     return str;
}
//检查奇偶比
function checkJO(s,o){
  var number=0;
  var n=s.length;
    for(var i=0;i<n;i++){
       if(s[i]%2==0){
             number++;
       }
    }
if(number==o){         
     return true;
    }else{
       return false;
    }
}
//检查和值的范围
function checkHZ(s,xiao,da){
    var number=0;
     for(var i=0;i<s.length;i++){
          number=number+s[i];             
     }
     if((number>=xiao&&number<=da)||(number<=xiao&&number>=da)){          
      return true;
     }else{
      return false;
     }
}
//检查连号
function checkLH(s){   
  s=aryPX(s);
  for(var i=s.length-1;i>0;i--){
      if((s[i]-1==s[i-1])||(s[i]+1==s[i-1])){
        return true;
      }
  }    
return false;
}
//检查大小比
function checkDXB(s,dxb,midd){
      var number=0;
      var mid=midd/2;
      
      for(var i=0;i<s.length;i++){
              if(s[i]>mid){
               number++;
              }
            } 
 if(number==dxb){
       return true;
     }else{
       return false;
     }
}
//是否包含这些数,如果包含这些数返回true
function checkIntInInts(s,yh){
      var length=yh.length;
      var number=0;
   for(var i=0;i<length;i++){
      for(var j=0;j<s.length;j++){
        if(yh[i]==s[j]){
          number++;
        }
      }
   }
if(number==length){
    return true;
   }else{
    return false;
   }
}
//不能包含这些数,如果包含这些数返回true
function checkIntNotInInts(s,yh){
      var length=yh.length;
      var number=0;
      for( i=0;i<length;i++){
           for( j=0;j<s.length;j++){
                if(yh[i]==s[j]){
                 number++;
              }
              }
          }
          if(number>0){
             return false;
         }else{
                return true;
            }
}
//总体检查方法 0数组 1范围，2包含，3不包含，4奇偶比，5大小比，6连号
function checkAll(s,fwY,xiao,da,bhY,yh1,bbhY,yh2,joY,o,dxbY,dxb,midd,lhY,lianha2){    

if(fwY){//如果检查和值范围
   if(!checkHZ(s,xiao,da))
    return false;
}
if(bhY){//如果要求包含
   if(!checkIntInInts(s,yh1))
    return false;
}
if(bbhY){//如果要求不包含
    if(!checkIntNotInInts(s,yh2))
    return false;     
}
if(joY){//如果要求检查奇偶比
    if(!checkJO(s,o))
    return false;
}
if(dxbY){//如果要求检查大小比
    if(!checkDXB(s,dxb,midd))
    return false;  
}
if(lhY){//连号要求    
   if(lianha2){//是连号          
      if(!checkLH(s))        
      return false;  
   }else{//不是连号           
      if(checkLH(s))          
      return false;          
   }             
}
return true;

}

//计算AC值
function getAC(s){               
                
      var length=s.length;      
      var number=new Array(36);      
      var intValue=0;
    //判断差
     if(length>1){
          for( i=0;i<length-1;i++){
              for( j=i+1;j<length;j++){        
                  //把字符串转换成int型                                
                  number[s[j]-s[i]]=1;
              } 
          }
     } 
     intValue=getNumber(number)-(length-1);
     if(intValue<0){
        intValue=0;
     }
 
    return intValue;
}
//计算有多少个不同的差值
function getNumber(number){
    var n=0;
    for(i=1;i<number.length;i++){
         if(number[i]==1){
           n++;             
         }
    
    }   
  return n;
}
//把小于10的号码前面的0去掉,必然用方法parseInt时各到的结果是0
function getOneNumber(s){
    var s1="";
    s1=s.substring(0,1);
    if(s1==0){
    
     return s.substring(1,2);
    }else{
     return s;
    }

}