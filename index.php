<?php
  
  session_start();
  header('X-FRAME-OPTIONS:DENY');
  function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  var_dump($_SESSION);
  $pageFlag = 0;
  if(!empty($_POST['btn-confirm'])){
    $pageFlag = 1;
    
  }

  if(!empty($_POST['btn-submit'])){
    $pageFlag = 2;
  }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php if($pageFlag === 0) : ?>
<?php
  if(!isset($_SESSION['csrfToken'])){
  $csrfToken = bin2hex(random_bytes(32));
  $_SESSION['csrfToken'] = $csrfToken;
  }
  $token = $_SESSION['csrfToken'];

?>
  <form method="POST" action="index.php">
  名前
    <input type="text" name="your_name" value="<?php echo h($_POST['your_name']) ; ?>">
    <br>
  メールアドレス
    <input type="email" name="email" value="<?php echo h($_POST['email']) ; ?>">

    <input type="submit" name="btn-confirm" value="確認する">
    <input type="hidden" name="csrf" value="<?php echo $token ?>">
  </form>
<?php endif; ?>

<?php if($pageFlag === 1) : ?>
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) : ?> 
  <form method="POST" action="index.php">
  名前
  <?php echo h($_POST['your_name']) ; ?>
    <br>
  メールアドレス
  <?php echo h($_POST['email']) ; ?>
    <input type="submit" name="back" value="戻る">
    <input type="submit" name="btn-submit" value="送信する">
    <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']) ; ?>">
    <input type="hidden" name="email" value="<?php echo h($_POST['email']) ; ?>">
    <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']) ; ?>">

  </form>
  <?php endif; ?>
<?php endif; ?>

<?php if($pageFlag === 2) : ?>
  <?php if($_POST['csrf'] === $_SESSION['csrfToken']) : ?> 
    <?php unset($_SESSION['csrfToken']) ?>
  完了
  <?php endif; ?>
<?php endif; ?>


</body>
</html>
