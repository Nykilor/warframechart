<?php
namespace WChart\Factory;
use \WChart\Entity as E;
/**
 * Creates Statistics entity
 */
class StatisticsChatFactory implements FromApiFactoryInterface {

    public $raw;
    public $date;
    public $ent;
    public $result = [
        "buy" => [],
        "sell" => []
    ];

    public function create(array $raw, \DateTime $date, $ent_arr) : array {
        $this->raw = $raw;
        $this->date = $date;
        $this->ent = $ent_arr;
        $this->addToStatistics($raw);

        return $this->result;
    }

    private function addToStatistics(array $data) : void {
            if(count($data['components']) === 1) {
                $no_join = true;
            } else {
                $no_join = false;
            }

            foreach ($data['components'] as $ckey => $cvalue) {
                  if($no_join) {
                   $name = $data["name"];
                  } else {
                   $name = $data["name"]." ".$cvalue['name'];
                  }

                  if(!array_key_exists($name, $this->ent)) return;

                  $ent_buy = new E\ChatStatistic();
                  $ent_buy->setItem($this->ent[$name]);
                  $ent_buy->setMin(floor($cvalue["buying"]["min"]));
                  $ent_buy->setMax(floor($cvalue["buying"]["max"]));
                  $ent_buy->setAvg(floor($cvalue["buying"]["avg"]));
                  $ent_buy->setMedian(floor($cvalue["buying"]["median"]));
                  $ent_buy->setType("buy");
                  $ent_buy->setDate($this->date);

                  $ent_sell = new E\ChatStatistic();
                  $ent_sell->setItem($this->ent[$name]);
                  $ent_sell->setMin(floor($cvalue["selling"]["min"]));
                  $ent_sell->setMax(floor($cvalue["selling"]["max"]));
                  $ent_sell->setAvg(floor($cvalue["selling"]["avg"]));
                  $ent_sell->setMedian(floor($cvalue["selling"]["median"]));
                  $ent_sell->setType("sell");
                  $ent_sell->setDate($this->date);

                  $this->result["sell"][] = $ent_sell;
                  $this->result["buy"][] = $ent_buy;
            }
    }

    public function getErrorDefault(array $error, string $item_name) : E\Statistics {

        return new E\ChatStatistic($item_name, 0, 0, 0, 0, 0, ["undefined" => 0], $error);

    }

}
