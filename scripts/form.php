<?php
session_start();

require_once (__DIR__ . '/lib/mail.php');
require_once (__DIR__ . '/lib/validates.php');

$post = (!empty($_POST)) ? true : false;

if ($post) {
  
  $json = array();
  
  preg_match("/^([a-zA-Z0-9]+)_([a-zA-Z0-9]+)_([a-zA-Z0-9]+)$/", $_POST['form'], $matches);

  ## Массив используемой формы
  $form = array();
  $form['id'] = $matches[1];
  $form['name'] = $matches[2];

  ## Описание форм, которые обрабатывает скрипт
  $forms = array(
    'otzivy' => array(
      'fields' => array(
        'name' => 1,
        'text' => 1,
        'captcha' => 1
      ),
      'mail' => array(
        'active' => 1,
        'subject' => 'Отзыв на сайте ' . $_SERVER["HTTP_HOST"],
        'body' => "Дата: <date>\nИмя: <name>\nОтзыв: <text>",
        'from' => array(
          'name' => 'Максим',
          'email' => 'mluboroscev@me.com'
        ),
        'to' => array(
          'name' => 'Максим',
          'email' => 'mluboroscev@me.com'
        ),
        'cc' => '',
        'bcc' => ''
      ),
      'note' => 'Ваш отзыв успешно отправлен'
    ),
    'registration' => array(
      'fields' => array(
        'name' => 1,
        'email' => 1,
        'phone' => 1,
        'password' => 1,
        'password_repeat' => 1,
        'terms' => 0,
        'subscribe' => 0,
        'captcha' => 1
      ),
      'mail' => array(
        'active' => 1,
        'subject' => 'Реистрация на сайте ' . $_SERVER["HTTP_HOST"],
        'body' => "Дата: " . date("d-m-Y H:i:s") . "\nИмя: <name>\nПочта: <email>\nТелефон: <phone>\nПароль: <password>\n",
        'from' => array(
          'name' => 'Максим',
          'email' => 'mluboroscev@me.com'
        ),
        'to' => array(
          'name' => 'Максим',
          'email' => 'mluboroscev@me.com'
        ),
        'cc' => '',
        'bcc' => ''
      ),
      'note' => 'Ваша регистрация прошла успешно'
    )
  );
  
  $js_status = array();
  
  if (isset($forms[$form['name']]['fields'])) {
    
    foreach ($forms[$form['name']]['fields'] as $key => $value) {
      
      $$key = htmlspecialchars(trim($_POST[$key]));
      $required = $value;
            
      unset($status);
      
      switch ($key) {
        
        case 'name':
          $status = validate_name($name, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
        break;
        
        case 'email':
          $status = validate_email($email, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
        break;
        
        case 'phone':
          $status = validate_phone($phone, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
        break;
        
        case 'password_repeat':
          
          $status = false;
          
          $status_1 = validate_password($password, $required);
          $status_2 = validate_password($password_repeat, $required);
          
          if ( $status_1 == true &&
               $status_2 == true &&
               $password == $password_repeat ) {
            
            $status = true;
            
          }
          
          $js_status = js_status ('password', $status, $js_status, $form['id']);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
          
        break;
                
        case 'terms':
        
          $status = validate_terms($terms, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
          
        break;
        
        case 'subscribe':
        
          $status = validate_subscribe($subscribe, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
          
        break;
        
        case 'captcha':
          
          $captcha = strtolower($captcha);
          
          $status = validate_captcha($captcha, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
                    
        break;
        
        case 'text':
          
          $status = validate_text($text, $required);
          $js_status = js_status ($key, $status, $js_status, $form['id']);
          
        break;
        
      }
            
    }
    
  } else {
    
    $js_status['errors'] ++;
    
  }
  
  if (!$js_status['errors']) {
    
    ## Здесь можно описать блок MySQL
    ## $query = "";
    ## $result = mysql_query($query);
    
    ## Если по форме надо отправить письмо
    if ($forms[$form['name']]['mail']['active']) {
      
      foreach ($forms[$form['name']]['fields'] as $key => $value) {
        
        $forms[$form['name']]['mail']['body'] = preg_replace("/<" . $key . ">/", $$key, $forms[$form['name']]['mail']['body']);
        
      }
      
      $forms[$form['name']]['mail']['body'] = preg_replace("/<date>/", date("d-m-Y H:i:s"), $forms[$form['name']]['mail']['body']);      
      
      ## Блок будет полезен для тестирования в бою,
      ## если письма Вы получаете не один
      #
      # if (preg_match("/@devops.myhc.ru$/", $email)) {
      #   
      #   $forms[$form['name']]['mail']['to']['name'] = 'Максим';
      #   $forms[$form['name']]['mail']['to']['email'] = 'mluboroscev@me.com';
      #   
      # }
      
      send_mime_mail(
        $forms[$form['name']]['mail']['from'],    # отправитель
        $forms[$form['name']]['mail']['to'],      # получатель
        $forms[$form['name']]['mail']['cc'],      # копия письма
        $forms[$form['name']]['mail']['bcc'],     # скрытая копия письма
        'UTF-8',                                  # кодировка переданных данных
        'KOI8-R',                                 # кодировка письма
        $forms[$form['name']]['mail']['subject'], # тема письма
        $forms[$form['name']]['mail']['body'],    # текст письма
        false                                     # письмо в виде html или обычного текста
      );
            
    }
    
    $json['note'] = $forms[$form['name']]['note'];
    
    $json['result'] = 'OK';
    
  } else {
    
    $json['result'] .= '<script type="text/javascript">';
    
    foreach ($forms[$form['name']]['fields'] as $key => $value) {
      
      $json['result'] .= "\$('#" . $form['id'] . "_" . $key . "').css('background-color', '#fff');";
      $json['result'] .= "\$('#" . $form['id'] . "_" . $key . "_d').removeClass('has-error');";
      
    }
    
    $json['result'] .= $js_status['has-error'];
    $json['result'] .= $js_status['has-success']; 
    
    $json['result'] .= '</script>';
    
  }
  
}

echo json_encode($json);
?>
