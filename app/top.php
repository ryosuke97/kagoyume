<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
session_start();;
 ?>

<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>KAGOYUME</title>
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
  <div class="inner">
    <div id="siteId">
      <h1><a href="<?php echo ROOT_URL; ?>"><img src="../img/logo.png" alt="KAGOYUME"></a></h1>
      <p>スキなものを、スキなだけ</p>
    </div>
    <!-- /siteId -->
    <ul>
      <li><?php echo login_state(); ?></li>
    </ul>
  </div>
</header>
<!-- /header -->

<div id="mainVisual">
  <div id="mainVisual-text">
    <img src="../img/mainVisualText.png" alt="">
  </div>
</div>
<!-- /mainVisual -->

<nav>
  <div class="inner">
    <ul>
    <li class="current"><a href="#">HOME <span>ホーム</span></a></li>
      <li><a href="#">ABOUT <span>アバウト</span></a></li>
      <li><a href="#">RECOMMEND <span>おすすめ</span></a></li>
      <li><a href="#">COMPANY <span>会社概要</span></a></li>
      <li><a href="#">CONTACT <span>お問い合わせ</span></a></li>
    </ul>
  </div>
</nav>
<!-- /nav -->

<div id="container">
  <div id="contentsLeft">
    <h2>CONTENTS</h2>
    <ul>
      <li><a href="#">アバウト</a></li>
    </ul>
    <ul>
      <li><a href="#">実績一覧</a></li>
      <li><a href="#">CM</a></li>
      <li><a href="#">ショートフィルム</a></li>
    </ul>
    <ul>
      <li><a href="#">ニュース</a></li>
      <li><a href="#">採用情報</a></li>
      <li><a href="#">お問い合わせ</a></li>
    </ul>

    <div id="news">
      <h2>NEWS</h2>
      <dl>
        <dt>2016.04.14</dt>
        <dd><a href="#">Webサイトをリニューアルしました。</a></dd>
        <dt>2016.04.14</dt>
        <dd><a href="#">Webサイトをリニューアルしました。</a></dd>
      </dl>
      <p><a href="#">ニュース一覧</a></p>
    </div>
    <!-- /news -->
  </div>
  <!-- /contentsLeft -->

  <div id="main">
    <div>
      <form action="<?php echo SEARCH; ?>" class="Search" method="GET">
        表示順序:
        <select name="sort">
        <?php foreach ($sortOrder as $key => $value) { ?>
        <option value="<?php echo h($key); ?>" <?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo h($value);?></option>
        <?php } ?>
        </select>
        キーワード検索：
        <select name="category_id">
        <?php foreach ($categories as $id => $name) { ?>
        <option value="<?php echo h($id); ?>" <?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo h($name);?></option>
        <?php } ?>
        </select>
        <input type="text" name="query" value="<?php echo h($query); ?>"/>
        <input type="submit" value="Yahooショッピングで検索"/>
      </form>
    </div>
    <!-- /form -->

    <div id="recommend">
      <h2>RECOMMEND</h2>
      <!-- reccommend01ここから -->
      <div id="recommend01">
        <img src="../img/ph_recommend01.jpg" alt="">
        <h3>クロスバイク / スポーツ</h3>
      </div>
      <!-- /recommend01 -->

      <div id="recommend02">
        <img src="../img/ph_recommend02.jpg" alt="">
        <h3>RainBus / アート</h3>
      </div>
      <!-- /recommend02 -->

      <p class="tRight" style="margin-top:20px; width:585px;"><a href="#">おすすめ一覧</a></p>
    </div>
    <!-- /recommends -->
  </div>
  <!-- /main -->
</div>
<!-- /container -->

<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105" height="17" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->

<footer>
  <p>Copyright &copy; KagoYume, Inc. All Rights Reserved.</p>
</footer>
<!-- /footer -->

</body>
</html>
