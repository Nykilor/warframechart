<?php
namespace Storage\File\Json;

/**
 * Store Relic/s in json format file
 */
class Relic extends \Storage\AbstractFile {

    public $data;
    public $path;
    public $callback;

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
        foreach ($this->data as $value) {
          //check if is function
          if(is_callable($this->callback)) {
            $to_call = $this->callback;
            //call function
            $to_save = $to_call($value->jsonSerialize());
            //if array returned by function has a "index" key save to that index
            if(array_key_exists("index", $to_save)) {
              $index = $to_save["index"];
              unset($to_save["index"]);
              //if array retruned by function has "save" key add to array of values
              if(array_key_exists("save", $to_save)) {
                $full_json_array[$index][] = $to_save["save"];
              } else {
                //else add whole variable to that key
                $full_json_array[$index] = $to_save;
              }

            } else {
              $full_json_array[] = $to_save;
            }

          } else {
            $full_json_array[] = $value->jsonSerialize();
          }
        }
        $f_name = "relicByRelic.json";

        $this->createFileIfNotExists($this->path, $f_name);
        $this->saveToFile($this->path.$f_name, json_encode($full_json_array));
    }
}
