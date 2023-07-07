<?php

ini_set('display_errors', 1);

// funcs.phpを読み込み
require_once('funcs.php');


//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=kadai08_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM kadai08_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
  // execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:" . $error[2]);
} else {
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<div class="p-2 lg:w-1/3 md:w-1/2 w-full"><div class="h-full flex items-center border-gray-200 border p-4 rounded-lg"><div class="flex-grow"><h2 class="text-gray-900 title-font font-medium">';
    $view .= h($result['organization'] );
    $view .= '</h2>';
    $view .= '<p class="text-gray-500">';
    $view .= h($result['name'], ENT_QUOTES) . '<br>' . h($result['certification']). '<br>' . 'Email:' . h($result['email']). '<br>' . h($result['website']);
    $view .= '</p>';

    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .= '<button class="inline-flex text-white bg-purple-500 border-0 py-1 px-4 my-2 focus:outline-none hover:bg-purple-600 rounded text-sm">詳細</button>';
    $view .= '</a>';

    $view .= '</div></div></div>';
  }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<title>登録カウンセラー一覧</title>
</head>

<body>
    
<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
    <a href="./index.php"><img src="./img/logo.jpg" alt="logo" width="70">
      <a href="./index.php"><span class="ml-3 text-xl">Grow</span></a>
    </a>
    <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
    <a class="mr-5 hover:text-gray-900 hover:scale-105" href="./registration.php">カウンセラー登録</a>
      <a class="mr-5 hover:text-gray-900 hover:scale-105" href="./select.php">カウンセラー一覧</a>
    </nav>
  </div>
</header>

<!-- main content starts -->
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">登録カウンセラー一覧</h1>
      <!-- <p class="lg:w-2/3 mx-auto leading-relaxed text-base">登録カウンセラーの一覧です。</p> -->
    </div>
    <div class="flex flex-wrap -m-2"><?= $view ?></div>
  </div>
</section>
<!-- main content ends -->

<!-- footer starts -->
<footer class="text-gray-600 body-font">
  <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
    <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
      <span class="ml-3 text-xl">Grow</span>
    </a>
    <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">© 2023 Grow </p>
  </div>
</footer>
<!-- footer ends -->


</body>
</html>