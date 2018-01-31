<?php
namespace DataSource;
use Factory as F;

/**
 * Create statistics for item from "Warframe Market"
 */
class Market {

    public $to_fetch;
    public $statistics = [
        "buy" => [],
        "sell" => []
    ];

    public function __construct(array $items) {
            $this->to_fetch = $items;
    }

    //Creates urls from names, inits the curl and creates the stats
    public function collectData(F\FromApiFactoryInterface $factory) {
        foreach ($this->to_fetch as $item) {
            $item_url = $this->createUrl($item);
            $result = $this->fetchDataFrom($item_url, "orders");

            $entity = $factory->create($result, $item);

            $this->statistics["buy"][] = $entity["buy"];
            $this->statistics["sell"][] = $entity["sell"];
        }
    }

    //Ash Prime Set => ash_prime_set => https://api.warframe.market/v1/items/ash_prime_set/
    private function createUrl(string $one_item) : string {
        $redone_item_name = strtolower(str_replace([" ", "&"], ["_", "and"], $one_item));
        return 'https://api.warframe.market/v1/items/'.$redone_item_name."/";
    }

    //Fetches the data from url
    private function fetchDataFrom(string $url, string $suffix = "") : array {
        $init = curl_init($url.$suffix);
        $platforms = ["pc", "ps4", "xbox"];
        $data = [];

        foreach ($platforms as $key) {
            $header_platform = "platform: ".$key;
            curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($init, CURLOPT_CONNECTTIMEOUT, 40);
            curl_setopt($init, CURLOPT_HTTPHEADER, [
                $header_platform
            ]);

            $result = curl_exec($init);

            $http_code = curl_getinfo($init, CURLINFO_HTTP_CODE);

            if($http_code === 200) {
                if($key === "pc") {
                    $data = json_decode($result, true);
                } else {
                    $new_data = json_decode($result, true);
                    $orders = array_merge($data["payload"]["orders"], $new_data["payload"]["orders"]);
                    $data["payload"]["orders"] = $orders;
                }
            } else if($http_code === 404) {
                $msg = "Could not fetch data for ".$key." platform.";

            } else if($http_code === 408) {
                $msg = "Request timeout for ".$key." platform.";

            } else {
                $msg = "Undefined error ocured for ".$key." platform I.e.: '".$result["error"]."'";
            }

            //error msg
            if(isset($msg)) {
                if($key === "pc") {
                    $data["error"] = [$msg];
                } else {
                    $data["error"][] = $msg;
                }
            }
        }

        return $data;
    }

}
