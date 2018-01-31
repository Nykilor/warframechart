<?php
namespace Factory;
use Entity as E;
/**
 * Creates Statistics entity
 */
class StatisticsMarketFactory implements FromApiFactoryInterface {

    public $raw;
    public $name;
    public $entity;

    public function create(array $raw, string $name) : array {
        $this->raw = $raw;
        $this->name = $name;

        $this->addToStatistics($name, $raw);

        return $this->entity;
    }

    private function addToStatistics(string $item_name, array $data) : void {
        if(isset($data["error"]) || !isset($data["payload"])) {
            $this->entity["buy"] = $this->getErrorDefault($data["error"], $item_name);
            $this->entity["sell"] = $this->getErrorDefault($data["error"], $item_name);
        } else {
            $values = $this->createListAndStatisticValues($data["payload"]);
            foreach ($values as $type => $value) {
                //No idea why there's no string names
                $the_prices = $value["values"];

                foreach ($the_prices as $platform => $prices) {
                  if(count($prices) > 0) {
                    $min[$platform] = min($prices);
                    $max[$platform] = max($prices);
                    $avg[$platform] = intval(array_sum($prices) / count($prices));
                    $median[$platform] = self::calculateMedian($prices);
                    //MODE
                    $frequency_of_numbers = array_count_values($prices);
                    $mode[$platform] = array_search(max($frequency_of_numbers), $frequency_of_numbers);
                  } else {
                    $min[$platform] = $max[$platform] = $avg[$platform] = $median[$platform] = $mode[$platform] = 0;
                  }

                }

                $this->entity[$type] = new E\Statistics($this->name, $min, $max, $avg, $median, $mode, $value["orders"]);
            }
        }
    }

    private function createListAndStatisticValues(array $data) : array {

        $values = [
            "sell" => [
                "values" => [
                  "pc" => [],
                  "xbox" => [],
                  "ps4" => []
                ],
                "orders" => []
            ],
            "buy" => [
                "values" => [
                  "pc" => [],
                  "xbox" => [],
                  "ps4" => []
                ],
                "orders" => []
            ],
        ];

        foreach ($data["orders"] as $order) {
            if($order["user"]["status"] === "ingame") {
                $values[$order["order_type"]]["values"][$order["platform"]][] = $order["platinum"];
                if(isset($order["mod_rank"])) {
                    $values[$order["order_type"]]["orders"][self::getFrontendName($order["user"]["ingame_name"], $order["platform"])] = [$order["platinum"], $order["mod_rank"]];
                } else {
                    $values[$order["order_type"]]["orders"][self::getFrontendName($order["user"]["ingame_name"], $order["platform"])] = $order["platinum"];
                }
            }
        }

        foreach ($values as $type => $value) {
          //Sorts by: first value of array or/and integre value. From min to max.
          $sorting = function($a,$b) {
              $is_a_int = (gettype($a) === "integer")? true : false;
              $is_b_int = (gettype($b) === "integer")? true : false;
              $result = false;
              if($is_a_int && $is_b_int) {
                  $result = ($a>$b)? true : false;
              } else if($is_a_int || $is_b_int) {
                  if($is_b_int) {
                      $result = ($a[0] > $b)? true : false;
                  } else {
                      $result = ($a > $b[0])? true : false;
                  }
              } else {
                  $result = ($a[0] > $b[0])? true : false;
              }

              return $result;
          };
          uasort($values[$type]["orders"], $sorting);

          foreach ($values[$type]["values"] as $key => $val) {
            sort($values["sell"]["values"][$key]);
          }
        }

        return $values;
    }

    //Returns the object of Entity\Statistics
    public function getErrorDefault(array $error, string $item_name) : E\Statistics {

        return new E\Statistics($item_name, 0, 0, 0, 0, 0, ["undefined" => 0], $error);

    }

    public static function getFrontendName(string $name, string $platform) : string {
        if($platform === "xbox") {
            $platform = "XB1";
        }

        $platform = strtoupper($platform);

        $name = $platform.":".$name;

        return $name;
    }

    public static function calculateMedian($arr) {
       sort($arr);
       $count = count($arr); //total numbers in array
       $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
       if($count % 2) { // odd number, middle is the median
           $median = $arr[$middleval];
       } else { // even number, calculate avg of 2 medians
           $low = $arr[$middleval];
           $high = $arr[$middleval+1];
           $median = (($low+$high)/2);
       }
       return intval($median);
     }

}


?>
