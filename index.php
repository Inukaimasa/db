<!-- データべース、入力ありなし ありはinput系なしはそのまま表示 -->

<?php

require 'db_conection.php';

// ユーザ入力なし query  sql文が決まっている場合
// https://www.php.net/manual/ja/class.pdostatement.php
// $sql = 'select * from contacts where id=4';
// $stmt = $pdo->query($sql);
// $result = $stmt->fetchAll();

// echo '<pre>';
// var_dump($result);
// echo '</pre>';

// ユーザ入力あり、prepare,bind,excute inputタグの時に使う
// id=4の所がid=:idになる id=4を id=:idに変更したこれをプレイスホルダーという

// $result = $stmt->fetchAll();
// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// トランザクション まとまって処理 銀行 残高確認→引き落とし→Bさんに戻る この処理をまとめて

$pdo->beginTransaction();
try {
  $sql = 'select * from contacts where id=:id'; //プレースホルダー IDがかわるのでこのような書き方
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue('id', 3, PDO::PARAM_INT); //ひもづけ 3番目のテーブルにいれる
  $stmt->execute(); //実行
  $pdo->commit(); //まとめて実行
} catch (PDOException $e) {


  $pdo->rollBack();
}
