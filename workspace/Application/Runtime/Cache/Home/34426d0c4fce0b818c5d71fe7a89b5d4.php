<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo ($basic_info["title"]); ?></title>
  <meta name="description" content="<?php echo ($basic_info["description"]); ?>">
  <meta name="Keywords" content="<?php echo ($basic_info["keywords"]); ?>">
  <link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="/Public/css/home/main.css" type="text/css" />
</head>
<body>
<header id="header">
  <div class="navbar-inverse">
    <div class="container">
      <div class="navbar-header">
        <a href="">
          <img src="/Public/images/logo.png" alt="" width="107" height="66">
        </a>
      </div>
      <ul class="nav navbar-nav navbar-left">
        <li><a href="/" <?php if($_GET['id']== ''): ?>class="curr"<?php endif; ?>>首页</a></li>
        <?php if(is_array($menus)): foreach($menus as $key=>$menu): ?><li><a href="/?c=Index&a=catlist&id=<?php echo ($menu["menu_id"]); ?>" <?php if($_GET['id']== $menu['menu_id']): ?>class="curr"<?php endif; ?>><?php echo ($menu["name"]); ?></a></li><?php endforeach; endif; ?>
      </ul>
    </div>
  </div>
</header>
<section>
    <div class="container">
        <H1 style="color:red"><?php echo ($message); ?></H1>
        <h3 id="location">系统将在<span style="color: #2b542c"><?php echo ($t_time); ?></span>秒后自动跳转</h3>
    </div>
    <input type="hidden" name="t_url" value="<?php echo ($t_url); ?>">
</section>
<script src="/Public/js/jquery.js"></script>
<script type="text/javascript">
    var surl = $("input[name=t_url]").val();//要跳转的Url
    var stime = $("#location span").html();
    setInterval("refer()",1000);
    function refer(){
        if(stime == 0)
        {
            location.href = surl;
        }
        $("#location span").html(stime);
        stime--;
    }
</script>
</body>
</html>