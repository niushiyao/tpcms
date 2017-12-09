/**
*添加按钮操作
*@author niushiyao
*/
$("#button-add").click(function(){
	var url = SCOPE.add_url;
	window.location.href=url;	
});

/**
*提交form表单的添加操作
*@author niushiyao
*/
$("#singcms-button-submit").click(function(){
	var postData = $("form").serialize();
	//ajax提交
	var url = SCOPE.save_url;
	var jump_url = SCOPE.jump_url;
	$.post(url,postData,function(result){
		if(result.status)
		{
			//成功
			return dialog.success(result.message,jump_url);
		}else{
			//失败
			return dialog.error(result.message);
		}
	},'JSON');
})

/**
*提交form表单的编辑操作
*@author niushiyao
*/
$(".singcms-table #singcms-edit").click(function(){
	var id = $(this).attr("attr-id");
	var url = SCOPE.edit_url + "&id=" + id;
	window.location.href = url;
});

/**
*提交form表单的删除操作
*@author niushiyao
*/
$(".singcms-table #singcms-delete").click(function(){
	var id = $(this).attr("attr-id");
	var a = $(this).attr("attr-a");
	var message = $(this).attr("attr-message");
	var url = SCOPE.set_status_url;
	
	//状态数据
	data = {};
	data['id'] = id;
	data['status'] = -1;
	
	return dialog.deleteinfo(url,data,message,'');
});

/**
*更新排序号操作
*@author niushiyao
*@date  2016-09-22
*/
$("input[name=listorder]").blur(function(){
	var order = $(this).val();
	var id = $(this).parent().parent().find("td span").attr("attr-id");
	
	var url = SCOPE.listorder_url;
	var postData = { listorder: order, id: id };
	$.post(url,postData,function(result){
		if(result.status)
		{
			//成功
			return dialog.toconfirm(result.message);
		}else{
			//失败
			return dialog.toconfirm(result.message);
		}
	},'JSON');
});

/**
* 将文章推送到推荐位
* @author niushiyao
*/
$("#sub_position").click(function(){
	var position_id = $("#position_id").val();
	var news_ids = [];
	$("input[name=news_ids]:checked").each(function(i){
		news_ids[i] = $(this).val();
	});
	var postData = { position_id: position_id, news_ids: news_ids };
	var url = SCOPE.push_url;
	$.post(url,postData,function(result){
		if(result.status)
		{
			//成功
			return dialog.toconfirm(result.message);
		}else{
			//失败
			return dialog.toconfirm(result.message);
		}
	},'JSON');	
})


