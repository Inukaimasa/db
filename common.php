<?php

function sanitize($before)
{
  foreach ($before as $key => $value) {

    // htmlspecialchars( 変換対象, 変換パターン, 文字コード )

    $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'utf-8');
  }
  return $after;
}
