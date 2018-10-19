<?php
namespace WChart\Controller\API;

use \WChart\Response;

/**
 * Chart data
 */
class Data {
  use \WChart\Controller\HelperTrait;

  public $em;
  /**
   * [Checks if method exists in this class.]
   * @param  array $data Strutured like array[0 => path, 1 => somevar, 2 => somevar...]
   * @param  \Doctrine\ORM\EntityManager $em
   * @return [array] [Resposne::create() array]
   */
  public function route(array $data, \Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
    if(!in_array($data[0], ["route", "errorMethod"]) && method_exists($this, $data[0])) {
      try {
        return $this->{$data[0]}($data);
      } catch (\Exception $e) {
        return Response::create(["error" => "Bad request."], 400);
      }
    } else {
      return Response::create(null, 405);
    }
  }

  public function chart(array $data) {
    if(isset($data[1])) {

      $id = $this->getFromGlobalGetIfExist("id");
      $start = $this->getFromGlobalGetIfExist("start");
      if($start !== null) {
        $start = $this->tryCreatingDateTime($start);
        if(gettype($start) === "array") {
          return $start;
        }
      }

      $end = $this->getFromGlobalGetIfExist("end");
      if($end !== null) {
        $end = $this->tryCreatingDateTime($end);
        if(gettype($end) === "array") {
          return $end;
        }
      }

      $type = $this->getFromGlobalGetIfExist("type");
      $platform = $this->getFromGlobalGetIfExist("platform");
      $show_id = $this->getFromGlobalGetIfExist("show_id");
      $show_source = $this->getFromGlobalGetIfExist("show_source");

      //If the key exits and creating an array succeds the function will return one,
      //On fail it will return implementation of errorMethod(),
      //If key dosn't exist at all NULL will be returned
      $create_array_or_exit = function($key) {
        $arr = $this->getFromGlobalGetIfExist($key);
        if($arr !== null) {
          $arr = $this->tryCreatingArrayFromString($arr);
          if(isset($platform["response"])) {
            return $arr;
            exit();
          } else {
            return $arr;
          }
        } else {
          return $arr;
        }
      };

      switch ($data[1]) {
        case 'market':
          $additional = [
            "platform" => $platform,
            "type" => $type,
            "show_source" => $show_source,
            "show_id" => $show_id
          ];
          //Remove all key => null pairs
          $additional = array_filter($additional);

          if($id !== null && $start !== null && $end !== null) {
            $source = new \WChart\Repository\MarketData($this->em);
            $result = $source->getMarketTimeChartData($id, $start, $end, $additional);
          }

          if(!isset($source)) {
            return Response::create(["error" => "Not enough parameters."], 400);
          } else {
            return Response::create($result);
          }

          break;
        case 'chat':
          if($id !== null && $start !== null && $end !== null) {
            $source = new \WChart\Repository\ChatData($this->em);
            if(!is_null($type)) {
              $result = $source->getChatTimeChartData($id, $start, $end, $type);
            } else {
              $result = $source->getChatTimeChartData($id, $start, $end);
            }
          }

          if(!isset($source)) {
            return Response::create(["error" => "Not enough parameters."], 400);
          } else {
            return Response::create($result);
          }
          break;
        default:
          return Response::create(["error" => "Either chat or market data is avaliable."], 400);
          break;
      }
    } else {
      return Response::create(["error" => "No data selected."], 400);
    }
  }

  public function player(array $data) {
    if(isset($data[1]) && isset($data[2])) {
      $repo = new \WChart\Repository\User($this->em);
      $result = $repo->getUser($data[2], $data[1]);

      return Response::create($result);
    } else {
      return Response::create();
    }
  }

  private function errorMethod($data, $code) {
    return Response::create($data, $code);
  }
}
