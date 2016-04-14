<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がregi_resultの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="regi_result"){
  echo '不正なリクエストです<br>';
}else{
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
  // セッションの値を用いてuser_tにレコードの登録
  $result = insert_user_profiles($_SESSION['name'],$_SESSION['pass'],$_SESSION['mail'],$_SESSION['address']);
  if(!isset($result)){
    echo '<p>ユーザー名:'.$_SESSION['name']."</p>";
    echo '<p>パスワード:'.$_SESSION['pass']."</p>";
    echo '<p>メールアドレス:'.$_SESSION['mail']."</p>";
    echo '<p>住所:'.$_SESSION['address']."</p><br><br>";
    echo "<p>上記の内容で登録しました</p><br><br>";
  }else{
    echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
  }
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

</body>
</html>
