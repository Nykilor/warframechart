<?php
namespace Storage\File\Json;
/**
 * Store data in files
 */

class Statistics extends \Storage\AbstractFile {
    /** @var array */
    public $data;
    //The datetime
    public $date;
    public $full_file_array;
    public $path;
    public $join_with = [];
    public $join_key;

    function __construct(array $data, string $path) {
        $this->data = $data;
        $this->date = getdate();
        $this->path = $path;
    }

    //If there's any array submited the script will try to join those values to the in save ones by $this->join_with[$iter][$entity->name]
    public function joinWith(array $paths, string $by_key) {
      $this->join_key = $by_key;
      for ($iter=0; $iter < count($paths) ; $iter++) {
        $file_path = $paths[$iter];
        $file = json_decode(file_get_contents($file_path), true);

        $this->join_with[] = $file;
      }
    }

    public function save() : void {
        foreach ($this->data as $type => $value) {
            $type_dir_path = $this->path.$type;
            $this->createDirIfNotExists($type_dir_path);

            $this->full_file_array = [];

            foreach ($value as $item => $statistics) {
                $this->addToFullFileArray($statistics);
                //For item/graph.sjon
                $this->maintainGraphFile($statistics, $type);
            }

            //For the full file
            $this->createFullFile($type);
        }
    }

    //Creates a static file e.g. "json/$type/21_10_12_2017.json"
    private function createFullFile(string $type) : void {
        $full_file_path = $this->path.$type."/";
        $current = $full_file_path."current.json";

        $value = json_encode($this->full_file_array);

        $this->saveToFile($current, $value);
    }

    //Adds entity values to array for later json_encode
    private function addToFullFileArray(\Entity\Statistics $entity) : void {
        $entity_as_array = $entity->jsonSerialize();

        if($entity_as_array["error"] === null) unset($entity_as_array["error"]);
        if($entity_as_array["orders"] === null) unset($entity_as_array["orders"]);
        //Try to merge arrays
        if(!empty($this->join_with)) {
          $join_key = $entity_as_array[$this->join_key];
          foreach ($this->join_with as $key => $to_join) {
            if(array_key_exists($join_key, $to_join)) {
              $entity_as_array = array_merge($entity_as_array, $to_join[$join_key]);
            }
          }
        }

        $this->full_file_array[] = $entity_as_array;
    }

    //Creates or adds content to graph.json file  ("json/buy/Ash Prime Set/graph.json")
    private function maintainGraphFile(\Entity\Statistics $entity, string $type) : void {
        $dir_path = $this->path.$type."/".$entity->getName();
        $ent_a = $entity->jsonSerialize();
        //Not needed in graph TBH.
        unset($ent_a["name"]);
        unset($ent_a["orders"]);
        unset($ent_a["error"]);
        if(is_array($ent_a["min"])) {
          foreach ($ent_a["min"] as $key => $value) {
            //Stop if the value is 0
            if($value === 0) return;

            $statistic = [
              "min" => $ent_a["min"][$key],
              "max" => $ent_a["max"][$key],
              "avg" => $ent_a["avg"][$key],
              "median" => $ent_a["median"][$key],
              "mode" => $ent_a["mode"][$key]
            ];

            $this->workOnGraphFiles($statistic, $dir_path, $key."_");
          }
        } else {
          $this->workOnGraphFiles($ent_a, $dir_path, "pc_");
        }

    }

    private function workOnGraphFiles(array $statistic, $dir_path, $key) {
      $this->createDirIfNotExists($dir_path);
      $this->createFileIfNotExists($dir_path, "/".$key."graph.json");

      $graph_file_content = file_get_contents($dir_path."/".$key."graph.json");
      $graph_file = fopen($dir_path."/".$key."graph.json", "w");

      if(empty($graph_file_content)) {
        fwrite($graph_file, json_encode([$this->getFileName() => $statistic]));
      } else {
        $graph_file_key = $this->getFileName();
        $graph_file_content_decoded = json_decode($graph_file_content);
        $graph_file_content_decoded->$graph_file_key = $statistic;
        fwrite($graph_file, json_encode($graph_file_content_decoded));
      }
    }

    public function getFileName() : string {
      return $this->date["hours"]."_".$this->date["mday"]."_".$this->date["mon"]."_".$this->date["year"];
    }

    public function debug($e) {
      echo "<pre>";
              var_dump($e);
              exit();
    }

}
