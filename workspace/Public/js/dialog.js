var dialog = {
    // 错误弹出层
    error: function(message) {
        layer.open({
            content:message,
            icon:2,
            title : '错误提示',
        });
    },

    //成功弹出层
    success : function(message,url) {
        layer.open({
            content : message,
            icon : 1,
            yes : function(){
                location.href=url;
            },
        });
    },

    // 确认弹出层
    confirm : function(message, url) {
        layer.open({
            content : message,
            icon:3,
            btn : ['是','否'],
            yes : function(){
                location.href=url;
            },
        });
    },

    //无需跳转到指定页面的确认弹出层
    toconfirm : function(message) {
        layer.open({
            content : message,
            icon:3,
            btn : ['确定'],
        });
    },
    
    //删除的弹出层
    deleteinfo : function(url,data,message,succ_jump_url)
    {
		layer.open({
			type : 0,
			title: '是否删除？',
			btn : ['Yes','No'],
			icon : 3,
			closeBtn : 2,
			content : '是否确定' + message + "？",
			scrollbar : true,
			yes : function(){
				//执行删除的跳转
				$.post(url,data,function(result){
					if(result.status)
					{
						return dialog.success(result.message,succ_jump_url);
					}else{
						return dialog.error(result.message);
					}
				},'JSON');
			}
			
		});
	}
}

