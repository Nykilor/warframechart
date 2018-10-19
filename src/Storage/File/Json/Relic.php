<?php
namespace WChart\Storage\File\Json;

/**
 * Store Relic/s in json format file
 */
class Relic extends \WChart\Storage\AbstractFile {

    public $data;
    public $path;
    public $callback;
    public $result;

    public function __construct(array $data, string $path) {
        $this->data = $data;
        $this->path = $path;
    }

    //Set a function to be called by each iteration of entities array
    public function setCallback($modif) {
      $this->callback = $modif;
    }

    public function save() : void {
        $full_json_array = [];
        //check if is function
        if(is_callable($this->callback)) {
          $to_call = $this->callback;
          $to_call($this->data);
        }

        $full_json_array = $this->data;

        $f_name = "relicByRelic.json";
        $this->createFileIfNotExists($this->path, $f_name);
        $this->saveToFile($this->path.$f_name, json_encode($full_json_array));
    }
}
