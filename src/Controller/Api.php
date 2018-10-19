<?php
namespace WChart\Controller;
use \WChart\Response;
/**
 * Chart data
 */
class Api {

  public $data;
  public $path;
  public $em;

  public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
    $this->route();
  }

  public function route() {
    $url = str_replace('/warframechart/api/', "", strtok($_SERVER["REQUEST_URI"],'?'));
    if(strlen($url) > 1) {
      $parts = explode("/", $url);
      $this->path = $parts[0];
      array_shift($parts);
      $parts = array_filter($parts);
      $this->data = $parts;
      $class = $this->checkIfExists($this->path, true);
      if($class === false) {
        echo "Nothing here";
      } else {
        if(!empty($this->data)) {
          echo json_encode($class->route($this->data, $this->em));
        } else {
          echo json_encode(Response::create(null, 400));
        }

      }
    } else {
      $this->showDoc();
    }
  }

  public function showDoc() {
    echo "I should show you some stuff here.";
  }

  public function checkIfExists(string $class_name, bool $return = false) {
    $class_name = preg_replace('/[^ \w]+/', '', $class_name);
    $class_name = "WChart\Controller\API\\".ucfirst($class_name);
    if(class_exists($class_name)) {
      if($return) {
        return new $class_name();
      } else {
        return true;
      }
    } else {
      return false;
    }
  }

}
