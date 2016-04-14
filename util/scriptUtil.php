<?php
//TOPページへのリンクを表示
function return_top(){
  return "<a href='".ROOT_URL."'>トップへ戻る</a>";
}

// ログイン状態によるheaderの表示の分岐
function login_state(){
  if(isset($_SESSION['login_state']) && $_SESSION['login_state']=='login'){ // セッションが'login'状態ならリンクつき名前とログアウトボタンを表示
    return '
    <form action="login.php" method="POST" style="display:inline-block;">
        ようこそ<a href=' . MY_DATA . '>' . $_SESSION['user_name'] . '</a>さん
        <input class="loginBtn" type="submit" name="logout" value="ログアウト">
        <input type="hidden" name="mode" value="logout">
      </form>';
  } else { // セッションが'login'状態でないならログインと会員登録のリンクを設置
    return '<a class="loginBtn" href=' . LOGIN . '>ログイン</a>
            <a class="loginBtn" href=' . REGISTRATION . '>会員登録</a>';
  }
}

// ログアウト時のセッション内の情報のリセット
function logout_sess(){
  session_unset();
  if (isset($_COOKIE['PHPSESSID'])) {
    // セッションの情報を初期化する
    setcookie('PHPSESSID', '', time() - 1800, '/');
  }
  // セッションに登録されたデータを全て破棄
  session_destroy();
}

// カート内の情報の削除
function delete_cookie(){
  for($i=0; $i<$_COOKIE['access_cnt']; $i++){
    setcookie("item_code[$i]", '', time() - 1800); // 商品コードの削除
    setcookie("name[$i]", '', time() - 1800); // 商品名の削除
    setcookie("price[$i]",'', time() - 1800); // 商品価格の削除
    setcookie("image[$i]",'', time() - 1800); // 商品画像の削除
  }
}

// cookieの値チェックをして返す
function check_cookie_val($key){
  if(!empty($_COOKIE["$key"])){ return $_COOKIE["$key"];}
}

// フォームに値が入力されていればセッションから同じ値を返す
function form_value($name){
  if(isset($_POST['mode']) && $_POST['mode']=='REINPUT'){
    if(isset($_SESSION[$name])){
      return $_SESSION[$name];
    }
  }
}

// ポストの値チェックをしてからセッションに格納する
//二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する
function bind_p2s($name){
  if(!empty($_POST[$name])){
    $_SESSION[$name] = $_POST[$name];
    return $_POST[$name];
  }else{
    $_SESSION[$name] = null;
    return null;
  }
}

// セッションのチェックにかかわらずセッションの更新
function update_session($key,$var){
  if(empty($_SESSION[$key])){
    $_SESSION[$key] = $var;
  }else{
    $_SESSION[$key] = $var;
  }
}

  /**
   * @brief アプリケーションID
   *
   * @var string
   */
  $appid = "dj0zaiZpPXd6V29mSlE2QmRveiZzPWNvbnN1bWVyc2VjcmV0Jng9YTE-";//取得したアプリケーションIDを設定

  /**
   * @brief カテゴリーID一覧
   *
   * 商品カテゴリの一覧です。
   * キーにカテゴリID、値にカテゴリ名が入っています。
   * @var array
   */
  $categories = array(
                      "1" => "すべてのカテゴリから",
                      "13457"=> "ファッション",
                      "2498"=> "食品",
                      "2500"=> "ダイエット、健康",
                      "2501"=> "コスメ、香水",
                      "2502"=> "パソコン、周辺機器",
                      "2504"=> "AV機器、カメラ",
                      "2505"=> "家電",
                      "2506"=> "家具、インテリア",
                      "2507"=> "花、ガーデニング",
                      "2508"=> "キッチン、生活雑貨、日用品",
                      "2503"=> "DIY、工具、文具",
                      "2509"=> "ペット用品、生き物",
                      "2510"=> "楽器、趣味、学習",
                      "2511"=> "ゲーム、おもちゃ",
                      "2497"=> "ベビー、キッズ、マタニティ",
                      "2512"=> "スポーツ",
                      "2513"=> "レジャー、アウトドア",
                      "2514"=> "自転車、車、バイク用品",
                      "2516"=> "CD、音楽ソフト",
                      "2517"=> "DVD、映像ソフト",
                      "10002"=> "本、雑誌、コミック"
                      );
  /**
   * @brief ソート方法一覧
   *
   * 検索結果のソート方法の一覧です。
   * キーに検索用パラメータ、値にソート方法が入っています。
   * @access private
   * @var array
   *
   */
  $sortOrder = array(
                     "-score" => "おすすめ順",
                     "+price" => "商品価格が安い順",
                     "-price" => "商品価格が高い順",
                     "+name" => "ストア名昇順",
                     "-name" => "ストア名降順",
                     "-sold" => "売れ筋順"
                     );

  /**
   * @brief 特殊文字を HTML エンティティに変換する
   *
   * これは、htmlspecialchars()を使いやすくするための関数です。
   * htmlspecialchars() http://jp.php.net/htmlspecialcharsより
   *   文字の中には HTML において特殊な意味を持つものがあり、
   *   それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。
   *   この関数は、これらの変換を行った結果の文字列を返します。
   *
   *   '&' (アンパサンド) は '&amp;' になります。
   *   ENT_QUOTES が設定されている場合のみ、 ''' (シングルクオート) は '&#039;'になります。
   *   '<' (小なり) は '&lt;' になります。
   *   '>' (大なり) は '&gt;' になります。
   *   ''' (シングルクオート) は '&#039;'になります。
   *
   * echo h("<>&'\""); //&lt;&gt;&amp;&#039;&quotと出力します。
   *
   * @param string $str 変換したい文字列
   *
   * @return string html用に変換した文字列
   *
   */
  function h($str)
  {
      return htmlspecialchars($str, ENT_QUOTES);
  }
  ?>