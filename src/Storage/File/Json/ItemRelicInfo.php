<?php
namespace Storage\File\Json;

/**
 * Store Relic/s in json format file
 */
class ItemRelicInfo extends \Storage\AbstractFile {

    public $data;
    public $path;

    public function __construct(array $data, string $path) {
        $this->data = $data;
        $this->path = $path;
    }

    public function save() : void {
        $full_json_array = [];
        foreach ($this->data as $value) {
            $item = $value->jsonSerialize();
            $item_name = $item["item"]." ".$item["part"];
            unset($item["item"]);
            unset($item["part"]);
            
            if(!isset($full_json_array[$item_name])) {
                $full_json_array[$item_name] = $item;
            } else {
                $full_json_array[$item_name]["relic"] = $full_json_array[$item_name]["relic"].",".$item["relic"];
            }

        }

        $f_name = "itemRelicInfo.json";

        $this->createFileIfNotExists($this->path, $f_name);
        $this->saveToFile($this->path.$f_name, json_encode($full_json_array));
    }
}
