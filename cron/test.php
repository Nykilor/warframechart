<?php
ini_set('max_execution_time', 0);
require_once "../src/bootstrap.php";
//f1784509@nwytg.net
//test1
$warframe_market = new WChart\DataSource\WarframeMarket();
$warframe_market->getProfiles(["Nykilor", "PLATINNUMM", "none", "vitavia00"]);
$warframe_market->getItemNames();
$result2 = $warframe_market->fetch();
var_dump($result2);
