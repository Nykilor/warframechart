<?php
namespace Storage\File\Json;

/**
 * Store Relic/s in json format file
 */
class DucatPrices extends \Storage\AbstractFile {

    public $data;
    public $path;

    public function __construct(array $data, string $path) {
        $this->data = $data;
        $this->path = $path;
    }

    public function save() : void {
        $full_json_array = $this->data;

        $f_name = "DucatPrices.json";

        $this->createFileIfNotExists($this->path, $f_name);
        $this->saveToFile($this->path.$f_name, json_encode($full_json_array));
    }
}
