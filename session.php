<?php
session_start();
?>


<html>

<head>
</head>

<body>

</body>

</html>
<?php
if (!isset($_SESSION['visited'])) {
  echo '初回設定';

  $_SESSION['visited'] = 1;
  $_SESSION['date'] = date('c');
} else {
  $visited = $_SESSION['visited'];
  $visited++;
  $_SESSION['visited'] = $visited;

  echo $_SESSION['visited'] . '回目の訪問です<br>';
  if (isset($_SESSION['date'])) {
    echo '前回訪問は' . $_SESSION['date'] . 'です';
    $_SESSION['date'] = date('c');
  }
}
