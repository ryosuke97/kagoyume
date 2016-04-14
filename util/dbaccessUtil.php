<?php
//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=kagoyume_db;charset=utf8','root');
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}
// user_tにレコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_user_profiles($name, $password, $mail, $address){
    //db接続を確立
    $insert_db = connect2MySQL();
    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t(name,password,mail,address,newDate)"
            . "VALUES(:name,:password,:mail,:address,:newDate)";
    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);
    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':password',$password);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$date);
    //SQLを実行
    try{
      $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }
    $insert_db=null;
    return null;
}

// buy_tにレコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_buy_record($userid, $total_price, $type){
  //db接続を確立
  $insert_db = connect2MySQL();
  //DBに全項目のある1レコードを登録するSQL
  $insert_sql = "INSERT INTO buy_t(userID,total,type,buyDate)"
      . "VALUES(:userID,:total,:type,:buyDate)";
      //現在時をdatetime型で取得
      $datetime =new DateTime();
      $date = $datetime->format('Y-m-d H:i:s');
      //クエリとして用意
      $insert_query = $insert_db->prepare($insert_sql);
      //SQL文にセッションから受け取った値＆現在時をバインド
      $insert_query->bindValue(':userID',$userid);
      $insert_query->bindValue(':total',$total_price);
      $insert_query->bindValue(':type',$type);
      $insert_query->bindValue(':buyDate',$date);
      //SQLを実行
      try{
        $insert_query->execute();
      } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
      }
      $insert_db=null;
      return null;
}

//ユーザーの総購入金額を参照
function serch_users_total($userID){
  //db接続を確立
  $search_db = connect2MySQL();
  $search_sql = "select total from user_t where userID=:userID";
  //クエリとして用意
  $seatch_query = $search_db->prepare($search_sql);
  $seatch_query->bindValue(':userID',$userID);
  //SQLを実行
  try{
    $seatch_query->execute();
  } catch (PDOException $e) {
    $seatch_query=null;
    return $e->getMessage();
  }
  //全レコードを連想配列として返却
  return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

// 購入金額の総和をuser_tへ更新
function update_price($total_price,$userID){
  $update_db = connect2MySQL();
  $update_sql = "UPDATE user_t SET total=:total where userID=:userID";
  //クエリとして用意
  $update_query = $update_db->prepare($update_sql);
  $update_query->bindValue(':total',$total_price);
  $update_query->bindValue(':userID',$userID);
  //SQLを実行
  try{
    $update_query->execute();
  } catch (PDOException $e) {
    $update_query=null;
    return $e->getMessage();
  }
}

// user_tからレコードを取得する
function serch_profiles($name,$password){
    //db接続を確立
    $search_db = connect2MySQL();

    //SQL文を用意
    $search_sql = "SELECT * FROM user_t";
    if(isset($name) && isset($password)){
        $search_sql .= " WHERE name = :name AND password = :password";
    }
    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);
    //対応するwhere句があるなら値をバインドする
    if(isset($name)){
        $seatch_query->bindValue(':name',$name);
      if(isset($password)){
          $seatch_query->bindValue(':password',$password);
      }
    }
    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }
    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}
//レコードの更新を行う。失敗した場合はエラー文を返却する
function update_profile($id, $name, $password, $mail, $address){
    //db接続を確立
    $update_db = connect2MySQL();
    //DBに全項目のある1レコードを登録するSQL
    $update_sql = "UPDATE user_t SET name = :name, password = :password, mail = :mail,"
            . " address = :address, newDate = :newDate WHERE userID = :id";
    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');
    //クエリとして用意
    $update_query = $update_db->prepare($update_sql);
    //SQL文に受け取った値＆現在時をバインド
    $update_query->bindValue(':id',$id);
    $update_query->bindValue(':name',$name);
    $update_query->bindValue(':password',$password);
    $update_query->bindValue(':mail',$mail);
    $update_query->bindValue(':address',$address);
    $update_query->bindValue(':newDate',$date);
    //SQLを実行
    try{
        $update_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $update_db=null;
        return $e->getMessage();
    }
    $update_db=null;
    return null;
}

//buy_tからユーザーのtotalを引き出す
function serch_buy_total($userID){
  //db接続を確立
  $search_db = connect2MySQL();
  $search_sql = "select total from buy_t where userID=:userID";
  //クエリとして用意
  $seatch_query = $search_db->prepare($search_sql);
  $seatch_query->bindValue(':userID',$userID);
  //SQLを実行
  try{
    $seatch_query->execute();
  } catch (PDOException $e) {
    $seatch_query=null;
    return $e->getMessage();
  }
  //全レコードを連想配列として返却
  return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

// user_tに登録されたレコードを削除する
function delete_profile($id){
    //db接続を確立
    $delete_db = connect2MySQL();
    $delete_sql = "DELETE FROM user_t WHERE userID=:id";
    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);
    $delete_query->bindValue(':id',$id);
    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_query=null;
        return $e->getMessage();
    }
    return null;
}

// 指定したuserIDに該当する登録者のレコードを取得する
function profile_detail($id){
  //db接続を確立
  $detail_db = connect2MySQL();
  $detail_sql = "SELECT * FROM user_t WHERE userID=:id";
  //クエリとして用意
  $detail_query = $detail_db->prepare($detail_sql);
  $detail_query->bindValue(':id',$id);
  //SQLを実行
  try{
    $detail_query->execute();
  } catch (PDOException $e) {
    $detail_query=null;
    return $e->getMessage();
  }
  //レコードを連想配列として返却
  return $detail_query->fetchAll(PDO::FETCH_ASSOC);
}