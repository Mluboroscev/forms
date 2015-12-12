<?php
function send_mime_mail(
  $from,         # отправитель
  $to,           # получатель
  $cc,           # копия письма
  $bcc,          # скрытая копия письма
  $data_charset, # кодировка переданных данных
  $send_charset, # кодировка письма
  $subject,      # тема письма
  $body,         # текст письма
  $html          # письмо в виде html или обычного текста
) {
  
  $from =  mime_header_encode($from['name'], $data_charset, $send_charset) .' <' . $from['email'] . '>';
  $to = mime_header_encode($to['name'], $data_charset, $send_charset) . ' <' . $to['email'] . '>';
  
  $subject = mime_header_encode($subject, $data_charset, $send_charset);
  
  if($data_charset != $send_charset) {
    $body = iconv($data_charset, $send_charset, $body);
  }
  
  $type = ($html) ? 'html' : 'plain';
  
  $headers = "Mime-Version: 1.0\r\n";
  $headers .= "Content-type: text/" . $type . "; charset=" . $send_charset . "\r\n";
  
  $headers .= "From: " . $from . "\r\n";
  
  if ($cc != '') $headers .= "Cc: " . $cc . "\r\n";
  if ($bcc != '') $headers .= "Bcc: " . $bcc . "\r\n";
  
  return mail ($to, $subject, $body, $headers);

}

function mime_header_encode($str, $data_charset, $send_charset) {
  
  if($data_charset != $send_charset) {
    
    $str = iconv($data_charset, $send_charset, $str);
    
  }
  
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}
?>
