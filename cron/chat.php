<?php
ini_set('max_execution_time', 0);
require("password.php");
require_once "../src/bootstrap.php";

$config = $em->getRepository("WChart\Entity\Item")->findAll();
// nexus-stats.com
$chat = new WChart\DataSource\Chat($config);
$chat->collectData(new WChart\Factory\StatisticsChatFactory());
//We don't need that anymore
unset($config);

//Array to produce static files for site from
$full_file_array = [
  "buy" => [],
  "sell" => []
];
//Loop trough buy and sell type
foreach ($chat->statistics as $type => $arr) {
  //Loop trough invidual items
  foreach ($arr as $key => $item) {
    //Save to DB
    $em->persist($item);
    $em->flush();

    //Save to file
    //Returns the static data
    $base = $item->getItem()->jsonSerialize();
    $base["min"] = $item->getMin();
    $base["max"] = $item->getMax();
    $base["avg"] = $item->getAvg();
    $base["median"] = $item->getMedian();
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

foreach ($full_file_array as $type => $data) {
  saveToFile("../json/current_chat_".$type.".json", json_encode($data));
}
