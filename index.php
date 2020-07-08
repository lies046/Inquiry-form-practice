<?php
  
  session_start();

  require 'validation.php';
  header('X-FRAME-OPTIONS:DENY');
  function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";
  $pageFlag = 0;
  $error = validation($_POST);
  
  if(!empty($_POST['btn-confirm']) && empty($error)){
    $pageFlag = 1;
    
  }

  if(!empty($_POST['btn-submit'])){
    $pageFlag = 2;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
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

      <?php if(!empty($_POST['btn-confirm']) && !empty($error)) : ?>
      <ul>
        <?php foreach($error as $value) :?>
        <li><?php echo $value ; ?></li>
        <?php endforeach ; ?>
      </ul>
      <?php endif ;?>
      
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <form method="POST" action="index.php">
              <div class="form-group">
                <label for="your_name">氏名</label>
                <input type="text" class="form-control" id="your_name" name="your_name" value="<?php echo h($_POST['your_name']) ; ?>" required>
              </div> 
              <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo h($_POST['email']) ; ?>" required>
              </div>

              <div class="form-group">
                <label for="url">ホームページ</label>
                <input type="url" class="form-control" id="url" name="url" value="<?php echo h($_POST['url']) ; ?>">
              </div>

              <div class="form-check form-check-inline">性別
                <input class="form-check-input" id="gender1" type="radio" name="gender" value="male">
                <label class="form-check-label" for="gender1">男性</label>
                <input class="form-check-input" id="gender2" type="radio" name="gender" value="female">
                <label class="form-check-label" for="gender2">女性</label>
              </div>
            
              <div class="form-group">
                <label for="age">年齢</label>
                <select class="form-control" id="age" name="age">
                  <option value="">選択してください</option>
                  <option value="1">~19歳</option>
                  <option value="2">20歳~29歳</option>
                  <option value="3">30歳~39歳</option>
                  <option value="4">40歳~49歳</option>
                  <option value="5">50歳~59歳</option>
                  <option value="6">60歳~69歳</option> 
                </select>
              </div>
              
              <div class="form-group">
                <label for="contact">お問い合わせ内容</label>
                <textarea class="form-control" id="contact" name="contact" value="<?php echo h($_POST['contact']) ; ?>"></textarea>
              </div>
              
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="caution">
                <label class="form-check-label" for="caution">注意事項に同意する</label>
              </div>

              <input class="btn btn-info" type="submit" name="btn-confirm" value="確認する">
              <input type="hidden" name="csrf" value="<?php echo $token ?>">
            </form>
          </div>
        </div>
     </div>
    <?php endif; ?>

    <?php if($pageFlag === 1) : ?>
      <?php if($_POST['csrf'] === $_SESSION['csrfToken']) : ?> 
        <form method="POST" action="index.php">
          名前
          <?php echo h($_POST['your_name']) ; ?>
          <br>
          メールアドレス
          <?php echo h($_POST['email']); ?>
          <br>
          ホームページ
          <?php echo h($_POST['url']); ?>
          <br>
          性別
          <?php if($_POST['gender'] === '0'){echo '男性';}
                if($_POST['gender'] === '1'){echo '女性';}
          ?>
          <br>
          年齢
          <?php if($_POST['age'] === '1'){echo '~19歳';}
          elseif($_POST['age'] === '2'){echo '20歳~29歳';}
          elseif($_POST['age'] === '3'){echo '30歳~39歳';}
          elseif($_POST['age'] === '4'){echo '40歳~49歳';}
          elseif($_POST['age'] === '5'){echo '50歳~59歳';}
          elseif($_POST['age'] === '6'){echo '60歳~69歳';}
          ?>
          <br>
          お問い合わせ内容
          <?php echo h($_POST['contact']) ; ?>
          <br>
            <input type="submit" name="back" value="戻る">
            <input type="submit" name="btn-submit" value="送信する">
            <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']) ; ?>">
            <input type="hidden" name="email" value="<?php echo h($_POST['email']) ; ?>">
            <input type="hidden" name="url" value="<?php echo h($_POST['url']) ; ?>">
            <input type="hidden" name="gender" value="<?php echo h($_POST['gender']) ; ?>">
            <input type="hidden" name="age" value="<?php echo h($_POST['age']) ; ?>">
            <input type="hidden" name="contact" value="<?php echo h($_POST['contact']) ; ?>">

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

    <body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
