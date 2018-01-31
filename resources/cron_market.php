<?php
  ini_set('max_execution_time', 0);
  ini_set('memory_limit', '512M');
 if (isset($_GET['days']) and $_GET['days'] == "1234590317382") {
     require("autoload.php");
     $config = require_once("config.php");

     //warframe.market
     $market = new DataSource\Market($config);
     $market->collectData(new Factory\StatisticsMarketFactory());

     $market_storage = new Storage\File\Json\Statistics($market->statistics, __DIR__."/json/market/");

     $join[] = __DIR__."/json/worldState/itemRelicInfo.json";
     $join[] = __DIR__."/json/worldState/DucatPrices.json";

     $market_storage->joinWith($join, "name");
     $market_storage->save();

     $html = new Storage\File\Html\Statistics($market->statistics, __DIR__."/../nojs/");
     $html->save();

 }
