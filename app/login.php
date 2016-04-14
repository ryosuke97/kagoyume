<?php
//ログインページ
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

<?php
  // $mode値があり　かつ　'ログアウト'の時はセッションとクッキーのカート内商品を削除する
  if (isset($_POST['mode']) && $_POST['mode'] == 'logout') {
    // セッション情報の削除
    logout_sess();
    // カート内データの削除
    delete_cookie();
?>
    <div class="tCenter">
      <p style="color: #f33;">ログアウトしました</p>
      <p style="color: #f33;">トップページへお戻りください</p>
      <a href="<?php echo ROOT_URL; ?>">トップページへ戻る</a><br><br>
    </div>
<?php
  }else{
    // POST値に名前とパスワードが存在し　かつ　名前とパスワードが一致した場合ログイン
    if(isset($_POST['user_name']) && isset($_POST['password'])) {
      // 名前とパスワードでヒットした登録者の情報を配列として格納
      $result = serch_profiles($_POST ['user_name'], $_POST['password']);
      if ($_POST['user_name'] == $result[0]['name'] && $_POST['password'] == $result [0]['password']) {
          // 各セッション情報に配列からの値を格納
          $_SESSION['userID'] = $result[0]['userID'];
          $_SESSION["login_state"] = 'login'; // ログインできる状態にする
          $_SESSION["user_name"] = $result[0]['name'];
          echo '<div class="tCenter">ログインしました。<br><br>下記リンクから前のページにお戻りください<br><br></div>';
          // とんできたページへ戻る
          echo '<div class="tCenter"><a href="' . $_POST['before_page'] . '">前のページへ戻る</a></div>';
      }else{
        echo '<div class="tCenter">
                ユーザー名またはパスワードが違います<br>
                <a href="'.LOGIN.'">ログイン画面へ戻る</a>
              </div>';
      }
    }else{ ?>

    <div class="tCenter">
      <p style="margin-bottom: 35px"><a href="<?php echo REGISTRATION; ?>">新規会員登録</a></p>
      <form action="login.php" method="POST">
        <p>ユーザー名:<br><input type="text" name="user_name"></p>
        <p>パスワード:<br><input type="text" name="password"></p>
        <input type="hidden" name="before_page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
        <input class="submit" type="submit" name="btnSubmit" value="ログイン" style="margin: 30px 0;">
      </form>
    </div>
<?php
    }
  }
?>

  </div>
  <!-- /wrapper -->

<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
<a href="http://developer.yahoo.co.jp/about">
<img src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105" height="17" title="Webサービス by Yahoo! JAPAN" alt="Webサービス by Yahoo! JAPAN" border="0" style="margin:15px 15px 15px 15px"></a>
<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->

<script src="js/jquery.js"></script>
<script src="js/index.js"></script>
</body>
</html>