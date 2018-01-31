<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
if (isset($_GET['days']) and $_GET['days'] == "1234590317382") {
   require("autoload.php");
   $config = require_once("config.php");
   
   //nexus-stats.com
   $chat = new DataSource\Chat($config);
   $chat->collectData(new Factory\StatisticsChatFactory());

   $chat_storage = new Storage\File\Json\Statistics($chat->statistics, __DIR__."/json/chat/");
   $chat_storage->save();

 }
