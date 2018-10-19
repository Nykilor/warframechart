<?php
namespace WChart\DataSource;
/**
 * [Class for all public api endpoints of warframe.market
 * docs.google.com/document/d/1121cjBNN4BeZdMBGil6Qbuqse-sWpEXPpitQH5fb_Fo/edit#heading=h.irwashnbboeo
 * ]
 */
class WarframeMarket {
    public const URL = "https://api.warframe.market/v1";

    public $platform;
    public $lang;
    public $curlsPerCall = 3;
    public $toFetch = [];

    /**
     * [Pass in the platforms it should fetch for and the lanugage]
     * @param string  $platform [The platforms to fetch for]
     * @param string $lang     [The language to fetch ]
     */
    public function __construct(string $platform = "pc", string $lang = "en") {
      $this->platform = $platform;
      $this->lang = $lang;
    }

    public function getItemNames(?array $items = null) : void {
      if(is_null($items)) {
        $this->toFetch[] = $this->createUrl("items");
      } else {
        $this->addToFetch("items", $items);
      }
    }

    public function getItemOrders(array $items) : void {
      $this->addToFetch("items", $items, "orders");
    }

    public function getItemStatistics(array $items) : void {
      $this->addToFetch("items", $items, "statistics");
    }

    public function getProfiles(array $profiles) : void {
      $this->addToFetch("profile", $profiles, null, false);
    }

    public function getProfilesOrders(array $profiles) : void {
      $this->addToFetch("profile", $profiles, "orders", false);
    }

    public function getProfilesStatistics(array $profiles) : void {
      $this->addToFetch("profile", $profiles, "statistics", false);
    }

    public function getProfilesReviews(array $profiles) : void {
      $this->addToFetch("profile", $profiles, "reviews", false);
    }

    public function getMostRecentOrders() {
      $this->toFetch[] = $this->createUrl("most_recent");
    }

    public function fetch() : array {
      $curl_resources = [];
      $max = count($this->toFetch);
      $result = [];
      foreach ($this->toFetch as $key => $url) {
        $curl_resources[] = $this->setCurl($url);
        if(($key % $this->curlsPerCall) === 0) {
          $result = array_merge($result, $this->fetchCurl($curl_resources));
          $curl_resources = [];
        } else if(($key+1) === $max) {
          $result = array_merge($result, $this->fetchCurl($curl_resources));
          $curl_resources = [];
        }
      }
      $this->toFetch = [];

      return $result;
    }

    private function addToFetch(string $end_point_prefix, array $what, ?string $end_point_suffix = null, bool $transform_string = true) {
      if(!is_null($end_point_suffix)) {
        foreach ($what as $key => $add) {
          $this->toFetch[] = $this->createUrl($end_point_prefix, $add, $transform_string)."/".$end_point_suffix;
        }
      } else {
        foreach ($what as $key => $add) {
          $this->toFetch[] = $this->createUrl($end_point_prefix, $add, $transform_string);
        }
      }

    }

    private function createUrl(string $end_point, ?string $item_name = null, bool $transform_string = true) : string {
        if(is_null($item_name)) {
          return self::URL."/".$end_point;
        } else {
          $redone_item_name = ($transform_string)? strtolower(str_replace([" ", "&"], ["_", "and"], $item_name)) : $item_name;
          return self::URL."/".$end_point."/".$redone_item_name;
        }
    }

    private function setCurl(string $url) {
      $header_platform = "platform: ".$this->platform;
      $header_lang = "language: ".$this->lang;

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 40);
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
          $header_platform,
          $header_lang
      ]);

      return $curl;
    }

    public function fetchCurl(array $curl_resources) : array {
      $mh = curl_multi_init();
      $to_return = [];
      //add to handler
      foreach ($curl_resources as $resource) {
        curl_multi_add_handle($mh, $resource);
      }
      //execute
      $running = null;
      do {
        curl_multi_exec($mh, $running);
      } while($running > 0);
      //iter trough results
      foreach ($curl_resources as $key => $resource) {
        $result = curl_multi_getcontent($resource);
        $http_code = curl_getinfo($resource, CURLINFO_HTTP_CODE);
        $url = curl_getinfo($resource, CURLINFO_EFFECTIVE_URL);

        $to_return[$url] = ["code" => $http_code, "response" => $result];
      }

      return $to_return;
    }
}
