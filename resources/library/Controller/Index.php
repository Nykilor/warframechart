<?php

namespace Controller;

/**
 * Basic controller to print out js variable for index
 */
class Index implements \JsonSerializable {

  public $options;

  public function __construct($get) {
    $this->options = $get;
  }

  public function printJSVar() {
    print("var get = ".json_encode($this->jsonSerialize()));
  }

  public function jsonSerialize() {
      return get_object_vars($this);
  }
}
