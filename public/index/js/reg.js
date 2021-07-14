//Email获得焦点：
function EmailFocus()
{
    var tishi = document.getElementById("emailMsg");
	tishi.innerHTML = "此邮箱用来激活账号";
	tishi.className = "msg";
}
//Email失去焦点
function EmailBlur(){
	var tishi = document.getElementById("emailMsg");
	var email = document.getElementById("email").value;
	var obj = document.getElementById("email");	
	var result = email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/);
	var v1 = obj.value;
	if( v1 == "" )
	{
		//提示文字是：Email是必填项，请输入Email
		tishi.innerHTML = "<span style='color:#f00;'>邮箱是必填项</span>";
		tishi.className = "msg2";
		return false;
	}
	else if(result == null)
	{
		//提示文字是：Email格式不正确
		tishi.innerHTML = "<span style='color:#f00;'>邮箱格式不正确</span>";
		tishi.className = "msg2";
		return false;
	}
	else	//是一个正确的符合要求的Email了
	{
	   //验证邮箱是否已被注册
        var email = $('#email').val();
        $.post('/index.php/index/User/ckEmail',{email:email},function(msg){
        	$('#emailMsg').html(msg);
    	}
			
	}
}

//昵称获得焦点：
function NickFocus(){
    var tishi = document.getElementById("nickMsg");
	tishi.innerHTML = "用户名至少两个字符";
	tishi.className = "msg";
}
//昵称失去焦点
function NickBlur(){
    var tishi = document.getElementById("nickMsg");
	var obj = document.getElementsByName("username")[0];	
	var v1 = obj.value;
	if( v1.length < 2 )	
	{
		tishi.innerHTML = "<span style='color:#f00;'>用户名太短</span>";
		tishi.className = "msg2";
		return false;
	}
	else	
	{
		//出现对勾
		tishi.innerHTML = "<span style='color:#00cc00;'>用户名可以使用</span>";
		return true;
	}
}

//密码获得焦点：
function PswdFocus(){
    var tishi = document.getElementById("pwdMsg");
	tishi.innerHTML = "密码至少4位";	
	tishi.className = "msg";
}
//密码失去焦点
function PswdBlur(){
    var tishi = document.getElementById("pwdMsg");
	var obj = document.getElementById("pwd");	
	var v1 = obj.value;
	if( v1.length < 4 )	
	{
		tishi.innerHTML = "<span style='color:#f00;'>密码至少4位</span>";
		tishi.className = "msg2";
		return false;
	}
	else	
	{
		//出现对勾
		tishi.innerHTML ="<span style='color:#00cc00;'>密码合理</span>";
		return true;
	}
}

//重复密码获得焦点：
function PswdFocus2(){
    var tishi = document.getElementById("pwdMsg2");
	tishi.innerHTML = "跟上面密码一致";
	tishi.className = "msg";
}
//重复密码失去焦点
function PswdBlur2(){
    var tishi = document.getElementById("pwdMsg2");

	var v1= document.getElementById("pwd").value;
	var v2= document.getElementById("repwd").value;

	if( v2.length < 4 )
	{
		tishi.innerHTML = "<span style='color:#f00;'>密码至少4位</span>";
		tishi.className = "msg2";
		return false;
	}
	else if( v1 != v2 )	//两次输入的密码不一致
	{
		tishi.innerHTML = "<span style='color:#f00;'>两次输入的密码不一致</span>";
		tishi.className = "msg2";
		return false;
	}
	else	
	{
		//出现对勾
		tishi.innerHTML = "<span style='color:#00cc00;'>密码输入一致</span>";
		return true;
	}
}

//表单验证函数：
function chkForm()
{
	//第一项的判断：Email
	var v1 = EmailBlur();
	if( v1 == false)
	{		
		return false;
	}

	//第二项判断： 昵称
	if( NickBlur() == false )	
	{
		return false;
	}

	//密码：
	if( PswdBlur() == false )
	{
		return false;
	}

	//重复密码：
	if( PswdBlur2() == false )
	{
		return false;
	}

	return true;

}


