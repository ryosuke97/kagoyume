<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// ログイン状態の判別
$login_state = isset($_SESSION['login_state']) ? $_SESSION['login_state'] : "";
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がaddの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="add"){
  echo '不正なリクエストです<br>';
}else{
  // 2回目以降のアクセスはカウントに反映
  if(!empty($_COOKIE['access_cnt'])){
    $cnt = $_COOKIE['access_cnt'];
  }else{
    setcookie('access_cnt',"1");//notice回避の為に初期値は1
    $cnt = 0;
  }
  // 何度目のカートへの追加したのかがわかるように$cntと紐付けた商品情報をクッキーへ格納
  setcookie("code[$cnt]",$_POST['item_code']);
  setcookie("image[$cnt]",$_POST['image']);
  setcookie("name[$cnt]",$_POST['name']);
  setcookie("price[$cnt]",$_POST['price']);
  // アクセスした回数がかぶらないようにカウントアップ
  $cnt++;
  // アクセスした回数をクッキーに格納
  setcookie('access_cnt',$cnt);
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
    <div id="wrapper" class="w90 mCenter" style="overflow:hidden;">
      <header style="margin-bottom:100px;">
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

      <div class="tCenter">
        <form action="<?php echo SEARCH; ?>" class="Search" method="GET" style="margin-bottom:50px;">
        <a href="<?php echo CART; ?>"><p class="submit btn">カートの中を見る</p></a>
        <h2 style="margin: 50px 0;">カートに追加しました</h2>
      </form>
    </div>
  </div>
  <!-- /wrapper -->
<?php
}
?>
  <div><p class="tCenter"><?php echo return_top(); ?></p></div>

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