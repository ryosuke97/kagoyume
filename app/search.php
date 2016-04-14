<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
session_start();

// 検索結果の格納
$hits = array();
// GETで受け取ったqueryの値を格納
$query = !empty($_GET["query"]) ? $_GET["query"] : "";
// GETで受け取ったsortの値を格納
$sort =  !empty($_GET["sort"]) && array_key_exists($_GET["sort"], $sortOrder) ? $_GET["sort"] : "-score";
// GETで受け取ったcategory_idの値を格納
$category_id = ctype_digit($_GET["category_id"]) && array_key_exists($_GET["category_id"], $categories) ? $_GET["category_id"] : 1;

if($query != "") { // $queryが空でなければ
  $query4url = rawurlencode($query); // 次のページへ$queryを渡すためにエンコード
  $sort4url = rawurlencode($sort); // 次のページへ$sortを渡すためにエンコード
  $url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url&category_id=$category_id&sort=$sort4url";
  // サーバーからの情報を配列化
  $xml = simplexml_load_file($url);

  if($xml["totalResultsReturned"] != 0) { // 検索件数が0件でない場合,変数$hitsに検索結果を格納します。
    $hits = $xml->Result->Hit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索結果_kagoyume</title>
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

<nav>
  <div class="inner">
    <ul>
    <li class="current"><a href="#">HOME <span>ホーム</span></a></li>
      <li><a href="#">ABOUT <span>アバウト</span></a></li>
      <li><a href="#">WORKS <span>実績</span></a></li>
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
      <?php
      // 検索フォームへの入力がない場合は入力を促す表示
      if ($query == "") {
      ?>
        <p style="color: #f33; margin-bottom:30px;"><?php echo '※検索フォームを入力してください'; ?></p>
  <?php
      }else{ // 検索結果の表示 ?>
      <p style="margin-bottom:30px; font-size:30px;">"<?php echo $query; ?>"の検索結果</p>
      <p style="margin:0 0 50px 5px; font-size:25px;"><?php echo $xml["totalResultsAvailable"]; ?> 件</p>
  <?php
      } ?>
      <form action="search.php" style="margin-bottom:60px;">
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
    <!-- /form -->

      <div class="mCenter">
        <div class="w90 mCenter items">
          <?php foreach ($hits as $hit) { ?>
          <div class="item">
            <div class="itemImg">
              <a href="<?php echo ITEM; ?>?code=<?php echo h($hit->Code)?>"><img src="<?php echo h($hit->Image->Medium); ?>"></a>
            </div>
            <div class="itemDetail">
              <h2><a href="<?php echo ITEM; ?>?code=<?php echo h($hit->Code); ?>"><?php echo h($hit->Name); ?></a></h2>
              <p><span class="itmPrice">通常販売価格 <?php echo h($hit->PriceLabel->DefaultPrice); ?>円</span></p>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- /main -->
  </div>
  <!-- /wrapper -->

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