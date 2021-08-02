<?php
// echo __FILE__;

// C:\xampp\htdocs\insert\mainte\test.php

// パスワードの暗号化
// echo '<br>';
// echo (password_hash('pass', PASSWORD_BCRYPT));
// パスワード
// $2y$10$S3OmiHKYq2Uw0wU4vfzEJePsTjBQDct5t7fgua5VHXTyWbikPAPjK

$contactFile = '.contact.dat';
// ファイルのよみこみ
$contacts = file_get_contents($contactFile);

$test = "test";
// echo $contacts; 
// 書き込み
file_put_contents($contactFile, $test, FILE_APPEND);

$allDate = file($contactFile);
foreach ($allDate as $lineDate) {
  $lines = explode(',', $lineDate);
  echo $lines[0] . '</br>';
}
