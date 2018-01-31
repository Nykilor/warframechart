<?php
namespace DataSource;
use Factory as F;

class Chat {

  public $data;
  public $config;
  public $statistics = [
      "buy" => [],
      "sell" => []
  ];

  public function __construct(array $config) {
      $this->config = $config;
  }

  public function collectData(F\FromApiFactoryInterface $factory) {
      $this->data = json_decode(file_get_contents("https://api.nexus-stats.com/warframe/v1/items?data=prices"), true);
      $iter = 0;
      foreach ($this->data as $key => $item) {
          //Check if the item name is in config or not
          $is = $this->isRequestedItem($item["name"]);

          if($is) {
              $entity = $factory->create($item, $item["name"]);

              $this->statistics["buy"] = $entity["buy"];
              $this->statistics["sell"] = $entity["sell"];
          }

      }
  }

  //returns true or false if finds matches
  private function isRequestedItem(string $name) : bool {
      $input = preg_quote($name, "~");
      $is = preg_grep('~' . $input . '~', $this->config);
      $result = (count($is) > 0) ? true : false;

      return $result;
  }

}
