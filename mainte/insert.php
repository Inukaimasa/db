<!-- ログインパス admin pass -->



<?php

function insertContact($request)
{

  require './db_conection.php';
  //DB接続

  //入力 DB保存 prepare ,bind,excute(配列) 文字列
  // $params = [
  //   'id' => null,
  //   'your_name' => '名前',
  //   'email' => 'test@gmail.com',
  //   'url' => 'http://test.com',
  //   'gender' => '1',
  //   'age' => '2',
  //   'contact' => 'ああああああ',
  //   'created_at' => null,
  // ];

  $params = [
    'id' => null,
    'your_name' => $request['your_name'],
    'email' =>  $request['email'],
    'url' =>  $request['url'],
    'gender' =>  $request['gender'],
    'age' =>  $request['age'],
    'contact' => $request['contact'],
    'created_at' => null,
  ];


  // 全部文字なので連想配列が可能
  $count = 0;
  $columns = '';
  $values = '';
  foreach (array_keys($params) as $key) {
    if ($count++ > 0) {
      $columns .= ',';
      $values .= ',';
    }
    $columns .= $key;
    $values .= ':' . $key;
  }

  $sql = 'insert into contacts(' . $columns . ')values(' . $values . ')';

  // var_dump($sql);
  // exit();
  $stmt = $pdo->prepare($sql); //プリペアードステートメント
  $stmt->execute($params); //実行する
}
