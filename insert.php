<?php

// POST data 取得
$organization = $_POST['organization'];
$name = $_POST['name'];
$kana = $_POST['kana'];
$certification = $_POST['certification'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$website = $_POST['website'];
$address = $_POST['address'];
$details = $_POST['details'];

// DB接続
try {
    //ID:'root', Password: xamppは 空白 ''
    $pdo = new PDO('mysql:dbname=kadai08_db;charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
  }

// 以下data登録 SQL作成

// （１）SQL文の用意
$stmt = $pdo->prepare("INSERT INTO
                        kadai08_table(
                        id, organization, name, kana, certification, email, tel, website, address, details, datetime
                        ) VALUES (
                            NULL, :organization, :name, :kana, :certification, :email, :tel, :website, :address, :details, sysdate()
                        )");

// （２）バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':organization', $organization, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
$stmt->bindValue(':certification', $certification, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':website', $website, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':details', $details, PDO::PARAM_STR);

// （３）実行
$status = $stmt->execute();

//（４）データ登録処理後
if($status === false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:'.$error[2]);
  }else{
    //５．（登録が成功した後の処理）index.phpへのリダイレクト
    header('Location: registration.php');
  
  
  
  }

?>