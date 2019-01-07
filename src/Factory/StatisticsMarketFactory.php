<?php
namespace WChart\Factory;
use WChart\Entity as E;
/**
 * Creates Statistics entity
 */
class StatisticsMarketFactory implements FromApiFactoryInterface {

    public $raw;
    public $entity;
    public $ent;
    public $date;

    public function create(array $raw, \DateTime $date, $ent) : array {
        $this->raw = $raw;
        $this->date = $date;
        $this->ent = $ent;
        $this->addToStatistics($raw);

        return $this->entity;
    }

    private function addToStatistics(array $data) : void {
        if(!isset($data["payload"])) {
            $this->entity["buy"] = $this->getErrorDefault($data["error"], "buy");
            $this->entity["sell"] = $this->getErrorDefault($data["error"], "sell");
        } else {
            $values = $this->createListAndStatisticValues($data["payload"]);
            foreach ($values as $type => $value) {
                //No idea why there's no string names
                $the_prices = $value["values"];
                $ent = new E\MarketStatistic();

                foreach ($the_prices as $platform => $prices) {
                  if(count($prices) > 0) {
                    $min[$platform] = min($prices);
                    $avg[$platform] = intval(array_sum($prices) / count($prices));
                    $median[$platform] = self::calculateMedian($prices);
                    //MODE
                    //happens that some float values get into the array
                    $prices = array_map("intval", $prices);
                    $frequency_of_numbers = array_count_values($prices);
                    $mode[$platform] = array_search(max($frequency_of_numbers), $frequency_of_numbers);
                  } else {
                    $min[$platform] = $avg[$platform] = $median[$platform] = $mode[$platform] = 0;
                  }

                  $ent->setMin($platform, $min[$platform]);
                  $ent->setAvg($platform, $avg[$platform]);
                  $ent->setMedian($platform, $median[$platform]);
                  $ent->setMode($platform, $mode[$platform]);
                }

                $ent->setItem($this->ent);
                $ent->setType($type);
                $ent->setDate($this->date);
                $ent->setSource($value["orders"]);
                $this->entity[$type] = $ent;
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
            if($order["user"]["status"] === "ingame" && $order["region"] === "en") {
                $values[$order["order_type"]]["values"][$order["platform"]][] = $order["platinum"];
                $player_order = [];
                $player_order["price"] = $order["platinum"];
                $player_order["platform"] = $order["platform"];
                $player_order["reputation"] = $order["user"]["reputation"];
                if(isset($order["mod_rank"])) {
                    $player_order["mod_rank"] = $order["mod_rank"];
                }
                $values[$order["order_type"]]["orders"][$order["user"]["ingame_name"]] = $player_order;
            }
        }

        foreach ($values as $type => $value) {
          //Sorts by: first value of array or/and integre value. From min to max.
          $sorting = function($a,$b) {
              $a = $a["price"];
              $b = $b["price"];
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

    //Returns the object of Entity\MarketStatistic
    public function getErrorDefault(array $error, string $type) : E\MarketStatistic {
        $ent = new E\MarketStatistic();
        $ent->setItem($this->ent);
        $ent->setType($type);
        $ent->setDate($this->date);
        $ent->setSource(json_encode($error));
        return $ent;
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
