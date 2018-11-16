<pre>
<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
require("password.php");
require_once "../src/bootstrap.php";

$config = $em->getRepository("WChart\Entity\Item")->findAll();
//warframe.market
$market = new WChart\DataSource\Market($config);
$market->collectData(new WChart\Factory\StatisticsMarketFactory());

//We don't need that anymore
unset($config);
//Array to produce static files for site from
$full_file_array = [
  "buy" => [],
  "sell" => []
];

//Loop trough buy and sell type
foreach ($market->statistics as $type => $arr) {
  //Loop trough invidual items
  foreach ($arr as $key => $item) {
    if(count($item->getSource()) > 0) {
      $em->persist($item);
      $em->flush();
    }

    //Save to file
    //Returns the static data
    $base = $item->getItem()->jsonSerialize();
    $base["orders"] = $item->getSource();
    //Platforms for loop
    $platforms = ["pc", "ps4", "xbox"];
    $base["min"] = [];
    $base["avg"] = [];
    $base["median"] = [];
    $base["mode"] = [];

    foreach ($platforms as $key => $value) {
      $base[$value."_min"] = $item->getMin($value);
      $base[$value."_avg"] = $item->getAvg($value);
      $base[$value."_median"] = $item->getMedian($value);
      $base[$value."_mode"] = $item->getMode($value);
    }
    //add to array
    $full_file_array[$type][] = $base;
  }
}
//save to file
function saveToFile($path, $data) {
  $file = fopen($path, "w");
  fwrite($file, $data);
  fclose($file);
}
//each type
foreach ($full_file_array as $type => $data) {
  saveToFile("../json/current_market_".$type.".json", json_encode($data));
}
$html = new WChart\Storage\File\Html\Statistics($full_file_array, "../nojs/", ["pc", "ps4", "xbox"]);
$html->save();

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo "Process Time: {$time} <br>";
echo "Memory: ".(memory_get_peak_usage(true)/1024/1024)." MB";
