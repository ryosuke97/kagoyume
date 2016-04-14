<?php
session_start();
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がmy_update_resultの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="my_update_result"){
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

  <div class="mCenter">
      <p>ユーザー名:<?php echo $_SESSION['name']; ?></p>
      <br><br>
      <p>メールアドレス:<?php echo $_SESSION['mail']; ?></p>
      <br><br>
      <p>パスワード:<?php echo $_SESSION['password']; ?></p>
      <br><br>
      <p>住所:<?php echo $_SESSION['address']; ?></p>
      <br><br>
      <p>上記の通り更新しました</p>>
  </div>

<?php
}
echo return_top();
 ?>


