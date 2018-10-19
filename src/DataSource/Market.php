<?php //TODO all the API bindings in one class
namespace WChart\DataSource;
use WChart\Factory as F;
use WChart\Entity as E;

/**
 * Create statistics for item from "Warframe Market"
 * https://docs.google.com/document/d/1121cjBNN4BeZdMBGil6Qbuqse-sWpEXPpitQH5fb_Fo/edit#heading=h.irwashnbboeo
 * Execution time: about 60-120s ( for 355 items, and doing 6 curls at time )
 */
class Market {

    public $toFetch;
    public $date;
    public $statistics = [
        "buy" => [],
        "sell" => []
    ];
    public $curlAmount = 2; // 3 = 9 calls, 2 = 6 calls etc. ( 3 gave 502 code)
    public const PLATFORMS = ["pc", "ps4", "xbox"];

    public function __construct(array $items) {
            $this->toFetch = $items;
            $this->date = new \DateTime();
    }

    //Creates urls from names, inits the curl and creates the stats
    public function collectData(F\FromApiFactoryInterface $factory) {
        $curl_resources_array = [];
        $amout_to_fetch = count($this->toFetch); //Because in some cases the last would not be fetched.

        foreach ($this->toFetch as $key => $ent) {
            $iter = $key+1;

            $curl_resources_array[$ent->getName()] = $this->setCurl($ent, "orders");
            //Fetch the data, create the entities to save
            if(($iter % $this->curlAmount) === 0 || $this->curlAmount <= 1 || $iter === $amout_to_fetch) {
              $result = $this->fetchCurl($curl_resources_array);
              //clear it because of reasons
              $curl_resources_array = [];

              foreach ($result as $value) {
                $entity = $factory->create($value["result"], $this->date, $value["entity"]);

                $this->statistics["buy"][] = $entity["buy"];
                $this->statistics["sell"][] = $entity["sell"];
              }
            }
        }
    }

    //Ash Prime Set => ash_prime_set => https://api.warframe.market/v1/items/ash_prime_set/
    private function createUrl(string $one_item) : string {
        $redone_item_name = strtolower(str_replace([" ", "&"], ["_", "and"], $one_item));
        return 'https://api.warframe.market/v1/items/'.$redone_item_name."/";
    }

    private function setCurl(E\Item $ent, string $suffix = "") : array {
      $curl_resources = [];
      $ent_name = $ent->getName();
      $item_url = $this->createUrl($ent_name);
      $endpoint = $item_url.$suffix;

      foreach (self::PLATFORMS as $key) {
        $curl = curl_init($endpoint);
        $header_platform = "platform: ".$key;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 40);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            $header_platform
        ]);
        $curl_resources["curl"][] = $curl;
      }

      $curl_resources["entity"] = $ent;

      return $curl_resources;
    }
    //["ash" => [1,2,3], "ben" => [1,2,3]]
    private function fetchCurl(array $curls) : array {
      $mh = curl_multi_init();
      $to_return = [];
      //add to handler
      foreach ($curls as $item) {
        foreach ($item["curl"] as $resource) {
          curl_multi_add_handle($mh, $resource);
        }
      }
      //execute
      $running = null;
      do {
        curl_multi_exec($mh, $running);
      } while($running > 0);
      //iter trough results
      foreach ($curls as $key => $array) {
        $data = [
          "payload" => [
            "orders" => []
          ],
          "error" => []
        ];
        foreach ($array["curl"] as $resource) {
          $result = curl_multi_getcontent($resource);
          $http_code = curl_getinfo($resource, CURLINFO_HTTP_CODE);
          //Join stuff
          if($http_code === 200) {
            if (empty($data)) {
              $data = json_decode($result, true);
            } else {
              $new_data = json_decode($result, true);

              if(array_key_exists("payload", $new_data)) {
                $orders = array_merge($data["payload"]["orders"], $new_data["payload"]["orders"]);
                $data["payload"]["orders"] = $orders;
              } else {
                $data["error"][] = $new_data["error"];
              }
            }
          } else if($http_code === 404) {
              $msg = "Could not fetch data for ".$key." platform.";
          } else if($http_code === 408) {
              $msg = "Request timeout for ".$key." platform.";
          } else {
              $msg = "Undefined error ocured for ".$key." platform I.e.: '".$http_code." code'";
          }

          //error msg
          if(isset($msg)) {
            $data["error"][] = $msg;
          }
          curl_multi_remove_handle($mh, $resource);
        }

        $to_return[$key]["result"] = $data;
        $to_return[$key]["entity"] = $array["entity"];
      }
      curl_multi_close($mh);

      return $to_return;
    }

}
