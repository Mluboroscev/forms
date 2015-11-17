<?php
function validate_name ($value, $required) {
  
  if ($value != "") {
    
    return true;
    
  }
  
  return $required ? false : true;
}

function validate_email ($value, $required) {
  
  $regex = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)*\.([a-zA-Z]{2,6})$/";
  
  if ($value != "") {
    
    $string = preg_replace($regex, "", $value);
    
    return empty($string) ? true : false;
    
  }
  
  return $required ? false : true;
  
}

function validate_phone ($value, $required) {
  
  $regex = "/^\+7\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$/";
  
  if ($value != "") {
    
    $string = preg_replace($regex, "", $value);
    return empty($string) ? true : false;
    
  }
  
  return $required ? false : true;
  
}

function validate_password ($value, $required) {
    
  $regex = "/^[a-zA-Z0-9\.\-\+=_,!@\$#\*%\[\]{}]+$/";
  
  if (strlen($value) >= 6) {
    
    $string = preg_replace($regex, "", $value);
    return empty($string) ? true : false;
    
  }
  
  return $required ? false : true;
}

function validate_terms ($value, $required) {
  return $required ? false : true;
}

function validate_subscribe ($value, $required) {
  return $required ? false : true;
}

function validate_captcha ($value, $required) {
  
  if ($value != "") {
    return $_SESSION['captcha'] == $value ? true : false;
  }
  
  return $required ? false : true;
}

function validate_text ($value, $required) {
  
  if ($value != "") {
    
    return true;
    
  }
  
  return $required ? false : true;
}

function js_status ($key, $status, $output, $form_id) {
        
  if (isset($status) && !$status) {
    
    $output['has-error'] .= "\$('#" . $form_id . "_" . $key . "_d').addClass('has-error');";
    $output['has-error'] .= "\$('#" . $form_id . "_" . $key . "').css('background-color', '#ffdfdf');";
    
    $output['errors'] ++;
    
  } else {
    
    $output['has-success'] .= "\$('#" . $form_id . "_" . $key . "_d').addClass('has-success');";
    
  }
  
  return $output;
}
?>