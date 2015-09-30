<?php
/**
 * JSON валидатор
 */

class payqr_json_validator {
  /**
   * Проверка валидности строки JSON
   *
   * @param string $string JSON строка
   * @return bool
   */
  public static function validate($string)
  {
    if(!function_exists("json_last_error"))
      return true;
    json_decode($string);
    if (json_last_error() != JSON_ERROR_NONE) {
        throw new payqr_exeption("Неверная JSON строка");
    }
    return true;
  }
} 