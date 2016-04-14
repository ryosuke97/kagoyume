<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();
// ログイン状態の確認
$login_state = isset($_SESSION['login_state']) ? $_SESSION['login_state'] : "";

// アクセスした回数を記録する変数を用意
$access_num = '';

// 削除ボタンが押された時に商品の各値を削除する
if(isset($_POST['delete'])){
    $access_num = $_POST['delete'];
    setcookie("code[$access_num]", '', time() - 1800);
    setcookie("name[$access_num]",'', time() - 1800);
    setcookie("price[$access_num]",'', time() - 1800);
    setcookie("image[$access_num]",'', time() - 1800);
}

// クッキーの値が空でないかチェックする　空でない場合はその値を受け取る
$code = check_cookie_val('code');
$name = check_cookie_val('name');
$price = check_cookie_val('price');
$image = check_cookie_val('image');
$access_cnt = check_cookie_val('access_cnt');
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>カート_kagoyume</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div id="wrapper" class="w90 mCenter">
    <header style="margin-bottom: 50px;">
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
// ユーザーが購入した都度の商品を表示する　削除ボタンつき
for ($i=0; $i<$access_cnt; $i++){

    if(isset($name[$i]) && $access_num != $i){ ?>
      <h2><a href="<?php echo ITEM . '?code=' . $code[$i] ?>"><?php echo $name[$i]; ?></a></h2>
      <p><a href="<?php echo ITEM . '?code=' . code[$i] ?>"><img src="<?php echo $image[$i]; ?>"></a></p>
      <p><?php echo $price[$i] . '円'?></p><br><br>
      <form action="<?php echo CART; ?>" method="POST">
        <input type="hidden" name="delete" value="<?php echo $i;?>">
        <input class="deleteBtn" type="submit" value="削除">
      </form>
<?php
    }
}
?>
    <form action="<?php echo BUY_CONFIRM; ?>" method="POST">
      <input type="hidden" name="mode" value="buy_confirm">
      <input type="submit" name="btnSubmit" value="購入確認画面へ進む">
    </form>
    <br><br>

<?php
echo return_top();
?>


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

<script src="js/jquery.js"></script>
<script src="js/index.js"></script>
</body>
</html>