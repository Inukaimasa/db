<?php
// http://localhost/insert/db_conection.php


// DB名 books  ユーザ名 user パスワードがpass

const DB_HOST = 'mysql:dbname=books; host=localhost; charset=utf8';
const DB_USER = 'user';
const DB_PASSWORD = 'pass';

$pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD,
[PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC, //連想配列
PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,   //例外
PDO::ATTR_EMULATE_PREPARES =>false, //SQLインテグレーション

]

);

try {
  echo '接続が成功しました';
} catch (PDOException $e) {
  echo '接続が失敗しいました';
  echo $e->getMessage() . "\n";
  exit();
}
