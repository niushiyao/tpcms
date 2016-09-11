/**
*前端登录业务类
*@author niushiyao
*@date 2016-09-11
*/
var login = {
	check : function(){
		//获取登录页面的用户和密码
		var username = $("input[name=username]").val();
		var password = $("input[name=password]").val();
		if(!username)
		{
			dialog.error("用户名不能为空");
		}
		if(!password)
		{
			dialog.error("密码不能为空");
		}
		
		//执行ajax异步请求
		var url = "/index.php?m=admin&c=login&a=check";
		var data = {"username":username,"password":password};
		$.post(url,data,function(result){
			
		});
	}
}