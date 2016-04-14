<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
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

<form action="<?php echo REGISTRATION_CONFIRM; ?>" method="POST">
  ユーザー名:
  <input type="text" name="name" value="<?php echo form_value('name'); ?>">
  <br><br>
  メールアドレス:
  <input type="text" name="mail" value="<?php echo form_value('mail'); ?>">
  <br><br>
  パスワード:
  <input type="password" name="pass">
  <br><br>
  パスワード(確認用):
  <input type="password" name="pass_confirm">
  <br><br>
  住所:
  <input type="text" name="address" value="<?php echo form_value('address'); ?>">
  <br><br>

  <input type="hidden" name="mode" value="regi_confirm">
  <input type="submit" name="btnSubmit" value="登録確認画面へ">
</form>


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
