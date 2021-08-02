<?php

// validationの引数はわかりやすいもの postの連想配列が入る
// $errors = validation($_POST);input側はこれで呼び出されている

function validation($request)
{
  $errors = [];

  if (empty($request['your_name']) || 20 < mb_strlen($request['your_name'])) {
    $errors[] = '氏名を入力してください.20文字以内で入力してください';
  }

  if (empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = '正しいメールアドレスを入力してください';
  }
  if (empty($request['url']) || !filter_var($request['url'], FILTER_VALIDATE_URL)) {
    $errors[] = '正しい形式のURLを入力してください';
  }

  if (empty($request['contact']) || 200 < mb_strlen($request['contact'])) {
    $errors[] = 'お問い合わせ内容は.200文字以内で入力してください';
  }
  if (empty($request['caution'])) {
    $errors[] = '注意事項をご確認ください';
  }
  if (!isset($request['gender'])) {
    $errors[] = '性別は必須です';
  };
  if (empty($request['age']) || 6 < $request['age']) {
    $errors[] = '年齢は必須項目です';
  }

  return $errors;
}
