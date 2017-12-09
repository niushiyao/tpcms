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
    <div class="row">
      <div class="col-sm-9 col-md-9">

        <div class="news-list">

          <?php if(is_array($articles)): foreach($articles as $key=>$article): ?><dl>
            <dt><a href="/?c=Index&a=detail&id=<?php echo ($article["news_id"]); ?>" target="_blank"><?php echo ($article["title"]); ?></a></dt>
            <dd class="news-img">
              <img src="<?php echo ($article["thumb"]); ?>" alt="" width="200" height="120">
            </dd>
            <dd class="news-intro">
              <?php echo ($article["description"]); ?>
            </dd>
            <dd class="news-info">
              <?php echo ($article["keywords"]); ?> <span><?php echo (date("Y-m-d H:i:s",$article["create_time"])); ?></span> 阅读(1万)
            </dd>
          </dl><?php endforeach; endif; ?>
        </div>
        <?php echo ($page_html); ?>
      </div>
      <div class="col-sm-3 col-md-3">
        <div class="right-title">
          <h3>文章排行</h3>
          <span>TOP ARTICLES</span>
        </div>
        <div class="right-content">
          <ul>
              <?php if(is_array($article_order)): foreach($article_order as $key=>$article): ?><li class="num<?php echo ($key+1); ?> curr">
                    <a href=""><?php echo ($article["title"]); ?></a>
                    <?php if($key == 0): ?><div class="intro">
                      <?php echo ($article["description"]); ?>...
                    </div><?php endif; ?>
                  </li><?php endforeach; endif; ?>
          </ul>
        </div>
        <?php if(is_array($ads_news_right)): foreach($ads_news_right as $key=>$ad): ?><div class="right-hot">
          <img src="<?php echo ($ad["thumb"]); ?>" alt="" width="330" height="215">
        </div><?php endforeach; endif; ?>
      </div>
    </div>
  </div>
</section>
</body>
</html>