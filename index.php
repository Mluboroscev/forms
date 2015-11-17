<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Форма отправки данных</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/form.js" type="text/javascript"></script>
  <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
</head>

<body>
<h1>Оставить отзыв</h1>
<div id="f1_form">
  <form id="f1_otzivy_form" action="" method="POST">
    <div class="form-group" id="f1_name_d">
      <input type="text" class="form-control" name="name" id="f1_name" placeholder="Имя">
    </div>
    <div class="form-group" id="f1_text_d">
      <textarea class="form-control" name="text" id="f1_text" placeholder="Отзыв"></textarea>
    </div>
    <div class="form-group" id="f1_captcha_d">
      <img src="img/refresh.jpg" alt="" id="f1_refresh_captcha" /> <img src="scripts/captcha.php" id="f1_img_captcha" />
      <input type="text" class="form-control" name="captcha" id="f1_captcha" placeholder="Проверочный код">
    </div>
    <div class="form-group" id="f1_submit_d">
      <input type="submit" name="submit" value="Оставить отзыв" class="btn btn-primary" />
    </div>
  </form>
  <div id="f1_note" class="bg-success"></div>
</div>

<h1>Регистрация</h1>
<div id="f2_form">
  <form id="f2_registration_form" action="" method="POST">
    <div class="form-group" id="f2_name_d">
      <input type="text" class="form-control" name="name" id="f2_name" placeholder="Имя">
    </div>
    <div class="form-group" id="f2_email_d">
      <input type="text" class="form-control" name="email" id="f2_email" placeholder="E-mail">
    </div>
    <div class="form-group" id="f2_phone_d">
      <input type="text" class="form-control" name="phone" id="f2_phone" placeholder="Телефон">
    </div>
    <div class="form-group" id="f2_password_d">
      <input type="password" class="form-control" name="password" id="f2_password" placeholder="Пароль">
    </div>
    <div class="form-group" id="f2_password_repeat_d">
      <input type="password" class="form-control" name="password_repeat" id="f2_password_repeat" placeholder="Пароль еще раз">
    </div>
    <div class="form-group" id="f2_captcha_d">
      <img src="img/refresh.jpg" alt="" id="f2_refresh_captcha" /> <img src="scripts/captcha.php" id="f2_img_captcha" />
      <input type="text" class="form-control" name="captcha" id="f2_captcha" placeholder="Проверочный код">
    </div>
    <div class="form-group" id="f2_terms_d">
      <input type="checkbox" name="terms" id="f2_terms" checked> Я подтверждаю своё согласие с условиями пользовательского соглашения
    </div>
    <div class="form-group" id="f2_subscribe_d">
      <input type="checkbox" name="subscribe" id="f2_subscribe" checked> Я хочу получать информационные сообщения
    </div>
    <div class="form-group" id="f2_submit_d">
      <input type="submit" name="submit" value="Зарегистрироваться" class="btn btn-primary" />
    </div>
  </form>
  <div id="f2_note" class="bg-success"></div>
</div>

<script type="text/javascript">
jQuery(function($){
   $("#f2_phone").mask("+7 (999) 999-99-99");
});
</script>
</body>
</html>
