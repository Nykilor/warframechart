<?php
namespace WChart;

class Response {

  public static function create($data = null, $code = null) {
    if($code === null) {
      if($data === null) {
        $response = ["code" => 400];
      } else if(empty($data)) {
        $response = ["code" => 204];
      } else if(!empty($data)) {
        $response = ["code" => 200, "response" => $data];
      } else {
        $response = ["code" => 400];
      }
    } else if($data === null) {
      $response = ["code" => $code];
    } else {
      $response = ["code" => $code, "response" => $data];
    }

    http_response_code($response["code"]);
    return $response;
  }
}
