<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がbuy_completeの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="buy_complete"){
  echo '不正なリクエストです<br>';
}else{
  if(isset($_POST['type']) && isset($_POST['total']) && isset($_SESSION['userID'])){
      $result = insert_buy_record($_SESSION['userID'], $_POST['total'], $_POST['type']);//購入情報テーブルへ追記
      $result2 = serch_users_total($_SESSION['userID']);//これまでの総購入金額を参照
      $result2[0]['total'] += $_POST['total'];
      update_price($result2[0]['total'],$_SESSION['userID']);//今回の購入を含めたtotal値で上書き
  }
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

  <header style="margin-bottom: 50px">
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

  <?php
  if(!isset($result)){
      echo "購入完了しました<br/><br/>";
      //カート情報の削除
      delete_cookie();
  }else{
      echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
  }
}
return_top();
?>


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
