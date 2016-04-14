<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がregi_confirmの場合のみ表示
if(!isset($_POST['mode']) || !$_POST['mode']=="regi_confirm"){
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
  //ポストの存在チェックとセッションに値を格納しつつ、連想配列にポストされた値を格納
  $confirm_values = array(
      'name'    => bind_p2s('name'),
      'mail'    => bind_p2s('mail'),
      'pass'    => bind_p2s('pass'),
      'pass_confirm'   =>bind_p2s('pass_confirm'),
      'address' => bind_p2s('address'),
  );

  if($_POST['pass'] != $_POST['pass_confirm']){ //パスワードの確認機能
  ?>    <h1>パスワードに誤りがあります</h1><br>
      再度入力を行ってください<br>
      <form action="<?php echo REGISTRATION; ?>" method="POST">
        <input type="hidden" name="mode" value="REINPUT" >
        <input type="submit" name="no" value="登録画面に戻る">
      </form>
  <?php
  } else {
       // 1つでも未入力項目があったら表示しない
       if(!in_array(null,$confirm_values, true)){
  ?>
         ユーザー名:<?php echo $confirm_values['name'];?><br>
         パスワード:<?php echo mb_strlen($confirm_values['pass']).'文字のパスワード';?><br>
         メールアドレス:<?php echo $confirm_values['mail'];?><br>
         住所:<?php echo $confirm_values['address'];?><br>
         上記の内容で登録します。よろしいですか？

          <form action="<?php echo REGISTRATION_COMPLETE; ?>" method="POST">
            <input type="hidden" name="mode" value="regi_result" >
            <input type="submit" name="yes" value="はい">
          </form>
  <?php
       }else{
  ?>
          <h1>入力項目が不完全です</h1><br>
          再度入力を行ってください<br>
          <h3>不完全な項目</h3>
          <?php
          //連想配列内の未入力項目を検出して表示
          foreach ($confirm_values as $key => $value){
            if($value == null){
              if($key == 'name'){
                echo '名前';
              }
              if($key == 'mail'){
                echo 'メールアドレス';
              }
              if($key == 'address'){
                echo '住所';
              }
              if($key == 'pass'){
                echo 'パスワード';
              }
              if($key == 'pass_confirm'){
                break;
              }
              echo 'が未記入です<br>';
            }
          }
        }
          ?>
          <form action="<?php echo REGISTRATION; ?>" method="POST">
            <input type="hidden" name="mode" value="REINPUT" >
            <input type="submit" name="no" value="登録画面に戻る">
          </form>
<?php
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
