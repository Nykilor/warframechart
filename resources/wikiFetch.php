<?php
  ini_set('max_execution_time', 0);
  ini_set('memory_limit', '512M');
 if (isset($_GET['days']) and $_GET['days'] == "1234590317382") {
     require("autoload.php");

     $relic_info = new DataSource\WarframeWikia();
     $relic_info->setUrl("Ducats/Prices");
     $relic_info->collectData();
     $v = new Storage\File\Json\DucatPrices($relic_info->entities, __DIR__."/json/worldState/");
     $v->save();

     $ducats = new DataSource\WarframeWikia();
     $ducats->setUrl("Void_Relic/ByRewards/SimpleTable");
     $ducats->collectData(new Factory\WarframeWikia\VoidRelic\ByRewards());
     $d = new Storage\File\Json\ItemRelicInfo($ducats->entities, __DIR__."/json/worldState/");
     $d->save();

     $rel = new DataSource\WarframeWikia();
     $rel->setUrl("Void_Relic/ByRelic");
     $rel->collectData();
     $rel_s = new Storage\File\Json\Relic($rel->entities, __DIR__."/json/worldState/");

     $cb = function($serialized){
       return [
         "index" => $serialized["tier"],
         "save" => $serialized["type"]
       ];
     };

     $rel_s->setCallback($cb);
     $rel_s->save();
 }
