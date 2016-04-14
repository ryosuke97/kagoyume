<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// ログイン状態の確認
$login_state = isset($_SESSION['login_state']) ? $_SESSION['login_state'] : "";
// アクセスルート固定のためGET値がある場合のみ表示
if(!isset($_GET['code'])){
  echo '不正なリクエストです<br>';
}else{
 ?>

  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>商品詳細_kagoyume</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
  <?php
    // 特定された商品idを格納
    $item_code = $_GET['code'];
    // 特定された商品idのurlを格納
    $url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$item_code";
    // サーバーからの情報を配列化
    $xml = simplexml_load_file($url);
    if ($xml ["totalResultsReturned"] != 0) { // 検索件数が0件でない場合,変数$hitsに検索結果を格納します。
      $hits = $xml->Result->Hit;
    }
    foreach($hits as $hit) {
      $name  = h($hit->Name);
      $price = h($hit->Price);
      $image = h($hit->Image->Small);
  ?>

    <div id="wrapper" class="w90 mCenter" style="overflow:hidden;">
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
      <form action="<?php echo ADD; ?>" method="POST">
        <div class="contentBox">
          <div class="itemImgInContentBox">
            <img src="<?php echo h($hit->Image->Small); ?>">
          </div>

          <div class="itemDetailInContentBox">
              <h1><?php echo h($hit->Name); ?></h1>
              <p><?php echo h($hit->Headline); ?></p>
              <p style="text-align:right; font-size:15px;"><?php echo h($hit->Price)."円"; ?></p>
          </div>
            <input type="hidden" name="item_code" value="<?php echo $item_code; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="image" value="<?php echo $image; ?>">
            <input type="hidden" name="mode" value="add">
            <?php } ?>
            <br><br>
        </div>
          <div class="cartInsert">
              <?php
                if ($login_state) {
                  echo '<input class="submit" type="submit" name="btnSubmit" value="カートに追加" style="margin-bottom: 50px;">';
                }else{
                  echo '<p style="margin-bottom:50px; color: #f33;">カートへの追加にはログインが必要です</p>';
                } ?>
          </div>
      </form>
      <!-- /form -->
    </div>
    <!-- /wrapper -->

<?php
}
echo return_top();
 ?>

<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105" height="17" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->

<footer>
  <p>Copyright &copy; KagoYume, Inc. All Rights Reserved.</p>
</footer>
<!-- /footer -->

<script src="js/jquery.js"></script>
<script src="js/index.js"></script>
</body>
</html>