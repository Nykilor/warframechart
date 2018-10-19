<?php
namespace WChart\DataSource;
use WChart\Factory as F;

class Chat {

  public $to_save = [];
  public $requested_items = [];
  public $date;
  public $statistics = [
      "buy" => [],
      "sell" => []
  ];

  public function __construct(array $config) {
      $this->date = new \DateTime();
      //To get a ["name1" => ent1, "name2" => ent2, "name3" => ent3] arr for isRequestedItem grep
      foreach ($config as $key => $value) {
          $this->requested_items[] = $value->getName();
          $this->to_save[$value->getName()] = $value;
      }
  }

  public function collectData(F\FromApiFactoryInterface $factory) {
      $result = json_decode(file_get_contents("https://api.nexus-stats.com/warframe/v1/items?data=prices"), true);
      foreach ($result as $key => $item) {
          //Check if the item name is in config or not
          $is = $this->isRequestedItem($item["name"]);
          if($is) {
              if(count($is) === 1) {
                //First value of array
                $is = reset($is);
                $ent_arr[$is] = $this->to_save[$is];
              } else {
                $ent_arr = [];
                foreach ($is as $key => $name) {
                  $ent_arr[$name] = $this->to_save[$name];
                }
              }
              $entity = $factory->create($item, $this->date, $ent_arr);

              $this->statistics["buy"] = $entity["buy"];
              $this->statistics["sell"] = $entity["sell"];
          }

      }
  }

  //returns true or false if finds matches
  private function isRequestedItem(string $name) {
      $input = preg_quote($name, "~");
      $is = preg_grep('~' . $input . '~', $this->requested_items);
      $result = (count($is) > 0) ? $is : false;

      return $result;
  }

}
