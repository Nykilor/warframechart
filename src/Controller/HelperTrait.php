<?php
namespace WChart\Controller;

/**
 * [Helper trait for Controllers to gather data to work around]
 */
trait HelperTrait {
  /**
   * [Is beign called when the public methods run over a problem]
   * @param array $data [error info]
   * @param int $code [http_status_code]
   * @return array [Whatever you like.]
   */
  abstract function errorMethod(array $data, int $code);

  /**
   * [Tries to create a \DateTime instance of given data]
   * @param  mixed $create_from
   * @return mixed [Either \DateTime object if succeds or errorMethod() implementation]
   */
  public function tryCreatingDateTime($create_from) {
    try {
      return new \DateTime($create_from);
    } catch (\Exception $e) {
        return $this->errorMethod(["error" => "Wrong format for \DateTime"], 400);
    }
  }

  /**
   * [Tries to create array from string value by exploding it with ","]
   * @param  string $value
   * @return mixed [Either the array or the errorMethod() implementation]
   */
  public function tryCreatingArrayFromString(string $value) {
    try {
      $value = explode(",", $value);
      if(count($value) > 0 && strlen($value[0]) > 0) {
        return $value;
      } else {
        return $this->errorMethod(["error" => "Wrong formated string, only accepted as 'key=parm1,param2,param3'"], 400);
      }
    } catch (\Exception $e) {
        return $this->errorMethod(["error" => "Undefined error."], 500);
    }
  }

  /**
   * [Tries getting data by $key from $_GET]
   * @param  string $key [The key to fetch from $_GET by]
   * @return string|null
   */
  public function getFromGlobalGetIfExist(string $key) {;
    if(isset($_GET[$key])) {
      return $_GET[$key];
    } else {
      return null;
    }
  }
}
