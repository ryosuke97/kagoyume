<?php
require_once("../util/defineUtil.php");
require_once("../util/scriptUtil.php");
require_once("../util/dbaccessUtil.php");
session_start();

// ユーザーのレコードを参照
$result = profile_detail($_SESSION['userID']);

// 各セッションの値の上書き
update_session('name', $result[0]['name']);
update_session('password', $result[0]['password']);
update_session('mail', $result[0]['mail']);
update_session('address', $result[0]['address']);
update_session('total', $result[0]['total']);
update_session('newDate', $result[0]['newDate']);
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

<a href="<?php echo CART; ?>">カートへ</a>
<br>
<b>ユーザー登録情報</b>
<br>
<br>
ユーザー名: <?php echo $result[0]['name']; ?><br>
メールアドレス: <?php echo $result[0]['mail']; ?><br>
住所: <?php echo $result[0]['address']; ?><br>
<br>
<?php
echo '購入額履歴'."<br/>";
// 購入金額データをすべて取得する
$result2 = serch_buy_total($_SESSION['userID']);
// 合計を出すために$total_priceを0に初期化
$total_price = 0;
// 購入額を取り出し合計として表示する
foreach ($result2 as $key => $val){
    foreach($val as $val){
        echo $val."円<br><br>";
        $total_price += $val;
    }
}
  echo "<p>合計".$total_price."円です</p>";
?>
<br>
<br>
    <form action="<?php echo MY_UPDATE; ?>" method="POST">
    <input type="submit" name="btnSubmit" value="ユーザー情報を変更する">
    <input type="hidden" name="mode" value="my_update">
    </form>
    <form action="<?php echo DELETE; // todo:機能の実装 ?>" method="POST">
    <input type="submit" name="btnSubmit" value="ユーザー情報を削除する">
    <input type="hidden" name="mode" value="delete">
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
