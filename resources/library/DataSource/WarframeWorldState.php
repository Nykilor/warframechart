<?php
namespace DataSource;
/**
 * get Warframe official worldstate, and fetch needed data from it
 */
class WarframeWorldState {

    public $data;
    public $platforms;

    public function getUrlContent($platforms = ['pc', 'xb1', 'ps4']) {
        $this->platforms = $platforms;
        foreach ($platforms as $key => $value) {
            if($value === 'pc') {
                $this->data[$value] = json_decode(file_get_contents("http://content.warframe.com/dynamic/worldState.php"), true);
            } else {
                $this->data[$value] = json_decode(file_get_contents("http://content.".$value.".warframe.com/dynamic/worldState.php"), true);
            }
        }
    }

    public function selectedDataToFile($array_node) {
        foreach ($this->platforms as $key => $plat) {
            $full_file_path = __DIR__."/../json/worldState/".$array_node.$plat.".json";

            //if just one do it once, if array loop
            if(is_array($array_node)) {
                foreach ($array_node as $key => $value) {
                    if(array_key_exists($value, $this->data[$plat])) {
                        $full_file = fopen($full_file_path, "w");
                        fwrite($full_file, json_encode($this->data[$plat][$value]));
                    } else {
                        throw new Exception("No such key in array", 1);
                    }
                }
            } else {
                if(array_key_exists($array_node, $this->data[$plat])) {
                    $full_file = fopen($full_file_path, "w");
                    fwrite($full_file, json_encode($this->data[$plat][$array_node]));
                } else {
                    throw new Exception("No such key in array", 1);
                }
            }
        }
    }
}
