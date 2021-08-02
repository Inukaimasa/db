<!-- http://localhost/insert/input.php -->

<?php
session_start();
require 'validatation.php';
header("X-Frame-Options: DENY");
// tmlspecialchars($str, ENT_QUOTES, 'UTF-8');でxssの攻撃を防ぐ script
// CSRF 偽物input.php 偽物のページを作ってデータを抜き取る  対策はsession_start <?php bin2hex(random_bytes(32)); と画面入力の所に追加する暗号化される

// DB名 books  ユーザ名 user パスワードがpass


// 簡単なフォーム方法
// if (!empty($_GET['your_name'])) {
//   echo $_GET['your_name'];
// }

if (!empty($_POST)) {
  echo '<pre>';
  var_dump($_POST);
  echo '</pre>';
}

// ページを表示する
// if (!empty($_SESSION)) {
//   echo '<pre>';
//   var_dump($_SESSION);
//   echo '</pre>';
// }
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 入力、確認、完了　input.php confirm.php thanks.php
$pageFlge = 0;


// validation,phpから値をもってくる変数を追加する 判定した結果をいれる validationメソッドの呼び出し スーパーグローバル変数で値をもってくる
$errors = validation($_POST);



if (!empty($_POST['btn_confirm']) && empty($errors)) {
  $pageFlge = 1;
}
if (!empty($_POST['btn_submit'])) {
  $pageFlge = 2;
}
?>




<!DOCTYPE html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <title>私は仕事が大好きです。</title>
</head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>

<body>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->

  <?php if ($pageFlge === 1) : ?>
    <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
      確認画面
      <form action="input.php" method="post">
        氏名
        <?php echo h($_POST['your_name']); ?>
        メールアドレス
        <?php echo h($_POST['email']); ?>
        <br>
        ホームページ
        <?php echo h($_POST['url']); ?>
        <br>
        性別
        <?php
        if ($_POST['gender'] === '0') {
          echo '男性';
        }
        if ($_POST['gender'] === '1') {
          echo '女性';
        }
        ?>
        <br>
        年齢
        <?php
        if ($_POST['age'] === '1') {
          echo '~19歳';
        }
        if ($_POST['age'] === '2') {
          echo '20歳~29歳';
        }
        if ($_POST['age'] === '3') {
          echo '30歳~39歳';
        }
        if ($_POST['age'] === '4') {
          echo '40歳~49歳';
        }
        if ($_POST['age'] === '5') {
          echo '50歳~59歳';
        }
        if ($_POST['age'] === '6') {
          echo '60歳~69歳';
        }

        ?>
        <br>
        お問い合わせ
        <?php echo h($_POST['url']); ?>
        <br>
        <input type="submit" name="back" value="戻る">
        <input type="submit" name="btn_submit" value="送信する">
        <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
        <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
        <input type="hidden" name="url" value="<?php echo h($_POST['url']); ?>">
        <input type="hidden" name="gender" value="<?php echo h($_POST['gender']); ?>">
        <input type="hidden" name="age" value="<?php echo h($_POST['age']); ?>">
        <input type="hidden" name="contact" value="<?php echo h($_POST['contact']); ?>">
        <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">

        <!-- 値を消さないように,hiddenを設定する 送信フォームの値を保持する-->
        <br>
      </form>
    <?php endif; ?>
  <?php endif; ?>

  <?php if ($pageFlge === 2) : ?>
    <!-- 合言葉があっていたか、確認する -->
    <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
      <?php require './mainte/insert.php';

      insertContact($_POST);
      ?>

      送信が完了
      <?php unset($_SESSION['csrfToken']); ?>
    <?php endif; ?>
  <?php endif; ?>




  <?php if ($pageFlge === 0) : ?>
    <?php
    // isset設定されてなかったら

    if (!isset($_SESSION['csrfToken'])) {
      $csrfToken = (bin2hex(random_bytes(32)));
      $_SESSION['csrfToken'] = $csrfToken;
    }
    $token = $_SESSION['csrfToken'];
    ?>


    <!-- バリデーションをかける条件 -->
    <?php if (!empty($errors) && !empty($_POST['btn_confirm'])) : ?>
      <?php ' <ul>'; ?>

      <!-- バリデーションからもってきた処理を連想で回す -->
      <?php foreach ($errors as $error) {
        echo '<li>' . $error . '</li>';
      } ?>
      <?php ' </ul>'; ?>

    <?php endif; ?>


    <div class="container">
      入力画面
      <div class="row">
        <div class="col-md-6">


          <form action="input.php" method="post">
            <div class="form-group">
              <!-- nameが値 送信する時に使う -->
              <!-- labelのyour_nameとinputのID合わせる -->

              <label for="your_name">氏名</label>
              <input type="text" class="form-control" id="your_name" name="your_name" value="<?php if (!empty($_POST['your_name'])) {
                                                                                                echo h($_POST['your_name']);
                                                                                              } ?>">

            </div>


            <!-- バリデーションテスト方法 <input type="text">に変更してバリデーションが発生するか？ -->
            <div class="form-group">

              <label for="email">メールアドレス</label>
              <input type="email" class="form-control" name="email" id="email" value="<?php if (!empty($_POST['email'])) {
                                                                                        echo h($_POST['email']);
                                                                                      } ?>"><br>
              <!-- バリデーションテスト方法 <input type="text">に変更してバリデーションが発生するか？ -->
            </div>
            <div class="form-group">

              <label for="url">ホームページ</label>
              <input type="url" class="form-control" name="url" id="url" value="<?php if (!empty($_POST['url'])) {
                                                                                  echo h($_POST['url']);
                                                                                } ?>"><br>
            </div>
            性別

            <div class="form-check form-check-inline">

              <!-- checkedの php文を追加する -->
              <input type="radio" class="form-check-input" name="gender" value="0" id="gender1">
              <label class="form-check-label" for="gender1">男</label>

              <input type="radio" name="gender" value="1" id="gender2">
              <label class="form-check-label" for="gender2">女</label>
              <br>

            </div>
            <div class="form-group">
              <lavel for="age">年齢
                <select class="form-control" id="age" name="age">
                  <option value="" selected>選択してください</option>
                  <option value="1">~19歳</option>
                  <option value="2">20歳~29歳</option>
                  <option value="3">30歳~39歳</option>
                  <option value="4">40歳~49歳</option>
                  <option value="5">50歳~59歳</option>
                  <option value="6">60歳~69歳</option>
                </select>
              </lavel>
            </div>
            <br>

            <div class="form-group">
              <lavel for="contact"> お問い合わせ内容</lavel>



              <textarea class="form-control" id="contact" name="contact" rows="3">
      <?php if (!empty($_POST['contact'])) {
        echo h($_POST['contact']);
      } ?>
      </textarea>
            </div>
            <br>

            <div class="form-check">

              <input class="form-check-input" id="caution" type="checkbox" name="caution" value="1">
              <lavel class="form-check-label" for="caution">注意事項チェック</lavel>

            </div>
            <br>
            <input class="btn brn-info" type="submit" name="btn_confirm" value="確認する">
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <br>
          </form>
        </div>
      </div>
    </div>
  <?php endif; ?>

</body>

</html>
