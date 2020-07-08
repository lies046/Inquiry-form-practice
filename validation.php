<?php

function validation($data){

  $error = [];

  if(empty($data['your_name']) || 20 < mb_strlen($data['your_name'])){
    $error[] = '「氏名」は20文字以内で入力してください。';
  }

  if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
    $error[] = '「メールアドレス」は正しい形式で入力してください。';
  }

  if(!empty($data['url'])){
    if(!filter_var($data['url'], FILTER_VALIDATE_URL)){
      $error[] = '「ホームページ」は正しい形式で入力してください。';
    }
  }

  if(!isset($data['gender'])){
    $error[] = '性別は必ず入力してください。';
  }

  if(empty($data['age']) || 6 < $data['age']){
    $error[] = '年齢は必ず入力してください。';
  }



  if(empty($data['contact']) || 200 < mb_strlen($data['contact'])){
    $error[] = '「お問い合わせ内容」は200文字以内で入力してください。';
  }

  if($data['caution'] !== '1'){
    $error[] = '「注意事項」をご確認ください。';
  }


  return $error;
}