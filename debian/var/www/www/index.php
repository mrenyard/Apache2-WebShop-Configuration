<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <title>Index of websites hosted on <?=getenv('HOSTNAME'); ?></title>
    <style>

* {
  margin: 0; padding: 0; border: 0;
  zoom: 1; /* FIX: IE hasLayout */
}
html { overflow-y: scroll; }
article, aside, footer, header, label, nav, pre, section { display: block; }
html { background-color: green; }
body {
  position: relative;
  margin: 0 auto;
  padding: 30px;
  max-width: 960px;
  background-color: #FFFFFF;
}

.bookmarklet {
  padding: .2em;
  border: dashed 1px #333;
  background-color: #999;
}

    </style>
  </head>
  <body>
    <header role="banner">
<!-- include header -->
    </header>
    <div id="main" role="main">
      <h1>Index of websites</h1>
      <h2><?=getenv('HOSTNAME'); ?></h2>
<?php
if ($handle = opendir('../')) {

  while (false !== ($entry = readdir($handle))) {

    if (
      (is_link('../' . $entry)) &&
      (!(strpos ($entry, 'style') === 0)) &&
      (!(strpos ($entry, 'func') === 0)) &&
      (!(strpos ($entry, 'media') === 0)) &&
      (!(strpos ($entry, 'dev') === 0))
    ) {
      $domain = $entry . '.' . getenv('HOSTNAME') . '.lan';
?>
      <article style="min-height:80px;"><a href="//<?=$domain; ?>" style="text-decoration:none;color:inherit;">
        <img src="//<?=$domain; ?>/apple-touch-icon-precomposed.png" style="float:left;margin-right:5px;" />
        <h1><?=$entry; ?></h1>
        </a><a href="//dev.<?=$domain; ?>">Development Version</a>
      </article>
<?php
      }
    }
    closedir($handle);
}
?>
    </div>
  </body>
</html>
