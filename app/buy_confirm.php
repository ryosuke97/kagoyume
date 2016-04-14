<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
session_start();
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がbuy_confirmの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="buy_confirm"){
  echo '不正なリクエストです<br>';
}else{
  // アクセス回数を格納する変数を用意
  $access_num = '';
  // 合計金額を初期値として0にする
  $total_price = 0;

  // 各クッキーの存在チェック　値があればその値を格納
  $code = check_cookie_val('code');
  $name = check_cookie_val('name');
  $price = check_cookie_val('price');
  $image = check_cookie_val('image');
  $access_cnt = check_cookie_val('access_cnt');
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
  // カートに追加した順に商品を表示する
  for($i=0; $i<$access_cnt; $i++){
    if(isset($name[$i]) && $access_num != $i){ ?>
      <img src="<?php echo $image[$i]; ?>" alt="">
      <p><?php echo $name[$i]; ?></p>
      <p><?php echo $price[$i].'円'?></p>
  <?php
      // 購入額を足していき合計金額を出していく
      $total_price += $price[$i];
      }
  } ?>
  <form action="<?php echo BUY_COMPLETE; ?>" method="POST">
    発送方法:<br><br>
    &nbsp;&nbsp;通常配送<input type="radio" name="type" value="1" checked><br><br>
    &nbsp;&nbsp;お急ぎ便<input type="radio" name="type" value="2" ><br>
    <p>合計 <?php echo $total_price; ?>円</p>
    <br><br>
    <input type="submit" name="btnSubmit" value="購入">
    <input type="hidden" name="total" value="<?php echo $total_price;?>">
    <input type="hidden" name="userID" value="<?php if(isset($_SESSION['userID'])){ echo $_SESSION['userID']; } ?>">
    <input type="hidden" name="mode" value="buy_complete">
  </form>
  <form action="<?php echo CART; ?>" ><input type="submit" name="btnSubmit" value="カートへ戻る"></form>

<?php
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
