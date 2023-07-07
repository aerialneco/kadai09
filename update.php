<?php

ini_set('display_errors', 1);

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「admin.php」に変更

$organization = $_POST['organization'];
$name = $_POST['name'];
$kana = $_POST['kana'];
$certification = $_POST['certification'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$website = $_POST['website'];
$address = $_POST['address'];
$details = $_POST['details'];
$id = $_POST['id'];

// DB接続します
//*** function化する！  *****************
try {
    $db_name = 'kadai08_db'; //データベース名
    $db_id   = 'root'; //アカウント名
    $db_pw   = ''; //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

// データ登録SQL作成
//UPDATE テーブル名 SET カラム1 = １に保存したいもの、 カラム２ = ２に保存したいもの.....WHERE 条件id = 送られてきたid
$stmt = $pdo->prepare('UPDATE kadai08_table 
                        SET organization = :organization,
                            name = :name,
                            kana = :kana,
                            certification = :certification,
                            email = :email,
                            tel = :tel,
                            website = :website,
                            address = :address,
                            details = :details,
                            datetime = sysdate()
                        WHERE id = :id;');
$stmt->bindValue(':organization', $organization, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':kana', $kana, PDO::PARAM_STR);
$stmt->bindValue(':certification', $certification, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':tel', $tel, PDO::PARAM_STR);
$stmt->bindValue(':website', $website, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':details', $details, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: admin.php');
    exit();
}


