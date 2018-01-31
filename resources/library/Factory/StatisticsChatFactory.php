<?php
namespace Factory;
use Entity as E;
/**
 * Creates Statistics entity
 */
class StatisticsChatFactory implements FromApiFactoryInterface {

    public $raw;
    public $name;
    public $entity = [
        "buy" => [],
        "sell" => []
    ];

    public function create(array $raw, string $name) : array {
        $this->raw = $raw;
        $this->name = $name;

        $this->addToStatistics($raw);

        return $this->entity;
    }

    private function addToStatistics(array $data) : void {
            if(count($data['components']) === 1) {
                $no_join = true;
            } else {
                $no_join = false;
            }

            foreach ($data['components'] as $ckey => $cvalue) {
                  if($no_join) {
                   $name = $this->name;
                  } else {
                   $name = $this->name." ".$cvalue['name'];
                  }

                  $this->entity["buy"][] = new E\Statistics(
                      $name,
                      floor($cvalue["buying"]["min"]),
                      floor($cvalue["buying"]["max"]),
                      floor($cvalue["buying"]["avg"]),
                      floor($cvalue["buying"]["median"]),
                      0,
                      null
                  );

                  $this->entity["sell"][] = new E\Statistics(
                      $name,
                      floor($cvalue["selling"]["min"]),
                      floor($cvalue["selling"]["max"]),
                      floor($cvalue["selling"]["avg"]),
                      floor($cvalue["selling"]["median"]),
                      0,
                      null
                  );
            }
    }

    public function getErrorDefault(array $error, string $item_name) : E\Statistics {

        return new E\Statistics($item_name, 0, 0, 0, 0, 0, ["undefined" => 0], $error);

    }

}


?>
