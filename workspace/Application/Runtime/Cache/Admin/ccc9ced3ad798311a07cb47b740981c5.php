<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>sing后台管理平台</title>
    <!-- Bootstrap Core CSS -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/Public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/css/sing/common.css" />
    <link rel="stylesheet" href="/Public/css/party/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/party/uploadify.css">

    <!-- jQuery -->
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/Public/js/party/jquery.uploadify.js"></script>

</head>

    



<body>
<div id="wrapper">

  
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    
    <a class="navbar-brand" >singcms内容管理平台</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    
    
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="/admin.php?c=admin&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
       
        <li class="divider"></li>
        <li>
          <a href="/admin.php?c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav nav_list">
     <?php if(is_array($adminMenus)): $i = 0; $__LIST__ = $adminMenus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li <?php echo (getActive($menu["c"])); ?>>
        <a href="/admin.php?c=<?php echo ($menu["c"]); if($menu["f"] != 'index'): ?>&a=<?php echo ($menu["f"]); endif; ?>"><i class="fa fa-fw fa-dashboard"></i> <?php echo ($menu["name"]); ?></a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>
  <div id="page-wrapper">

    <div class="container-fluid" >

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/admin.php?c=content">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>文章列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->
      <div >
        <button  id="button-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加 </button>
      </div>
      <div class="row">
        <form action="/admin.php" method="get">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">栏目</span>
              <select class="form-control" name="catid">
                <option value='0' <?php if($catid == 0): ?>selected<?php endif; ?>>全部分类</option>
                
                <?php if(is_array($frontMenu)): foreach($frontMenu as $key=>$menu): ?><option value="<?php echo ($menu["menu_id"]); ?>" <?php if($catid == $menu['menu_id']): ?>selected<?php endif; ?>><?php echo ($menu["name"]); ?></option><?php endforeach; endif; ?>
               
              </select>
            </div>
          </div>
          <input type="hidden" name="c" value="content"/>
          <input type="hidden" name="a" value="index"/>
          <div class="col-md-3">
            <div class="input-group">
              <input class="form-control" name="title" type="text" value="<?php echo ($title); ?>" placeholder="文章标题" />
                <span class="input-group-btn">
                  <button id="sub_data" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <h3></h3>
          <div class="table-responsive">
            <form id="singcms-listorder">
              <table class="table table-bordered table-hover singcms-table">
                <thead>
                <tr>
                  <th width="10"><input type="checkbox" id="position_all" value=""></th>
                  <th width="14">排序</th>
                  <th>id</th>
                  <th>标题</th>
                  <th>栏目</th>
                  <th>来源</th>
                  <th>封面图</th>
                  <th>时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                
                <?php if(is_array($newsList)): foreach($newsList as $key=>$new): ?><tr>
                  	<td><input type="checkbox" name="news_ids" value="<?php echo ($new["news_id"]); ?>"></td>
                    <td><input size=4 type='text' name='listorder' value="<?php echo ($new["listorder"]); ?>"/></td>
                    <td><?php echo ($new["news_id"]); ?></td>
                    <td><?php echo ($new["title"]); ?></td>
                    <td><?php echo (getCateName($frontMenu,$new["catid"])); ?></td>
                    <td><?php echo (getCopyFromById($new["copyfrom"])); ?></td>
                    <td><img src="<?php echo ($new["thumb"]); ?>" width="100" height="100"></td>
                    <td>
                      <?php echo (date('Y-m-d H:i:s',$new["create_time"])); ?>
                    </td>
                    <td><?php echo (getStatus($new["status"])); ?></td>
                    
                    <td><span class="sing_cursor glyphicon glyphicon-edit" aria-hidden="true" id="singcms-edit" attr-id="<?php echo ($new["news_id"]); ?>" ></span>
                      <a href="javascript:void(0)" id="singcms-delete"  attr-id="<?php echo ($new["news_id"]); ?>"  attr-message="删除">
                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                      </a>

                      <a href="<?php echo ($server_name); ?>?c=Index&a=detail&id=<?php echo ($new["news_id"]); ?>" target="_blank">
                        <span aria-hidden="true">预览</span>
                      </a>

                    </td>
                  </tr><?php endforeach; endif; ?>

                </tbody>
              </table>
              <nav>

	            <ul class="pagination">
	                <?php echo ($page_html); ?>
	            </ul>

            </nav>
              
            </form>

			<div class="col-md-3">
            	<div class="input-group">
              		<span class="input-group-addon">推荐位</span>
              		<select class="form-control" name="posid" id="position_id">
		                <option value='0' <?php if($posid == 0): ?>selected<?php endif; ?>>请选择</option>
		                <?php if(is_array($positionList)): foreach($positionList as $key=>$position): ?><option value="<?php echo ($position["id"]); ?>" <?php if($posid == $position['id']): ?>selected<?php endif; ?>><?php echo ($position["name"]); ?></option><?php endforeach; endif; ?>
		              </select>
            	</div>
          	</div>
		  	<button id="sub_position" type="button" class="btn btn-info">提交到推荐位</button>

          </div>
        </div>

      </div>
      <!-- /.row -->



    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script>
  var SCOPE = {
    'edit_url' : '/admin.php?c=content&a=edit',
    'add_url' : '/admin.php?c=content&a=add',
    'set_status_url' : '/admin.php?c=content&a=setStatus',
    'sing_news_view_url' : '/index.php?c=view',
    'listorder_url' : '/admin.php?c=content&a=listorder',
    'push_url' : '/admin.php?c=content&a=push',
  }
  
  //全诜，全不选
  $("#position_all").click(function(event){
	if($(this).is(':checked') == true){
		$("input[type=checkbox][name=news_ids]").prop("checked",true);
	}else{
		$("input[type=checkbox][name=news_ids]").prop("checked",false);
	}
  });
</script>
<script src="/Public/js/admin/common.js"></script>



</body>

</html>