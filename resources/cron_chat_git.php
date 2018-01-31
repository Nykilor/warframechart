<?php
   require("autoload.php");
   $config = require_once("config.php");

   //nexus-stats.com
   $chat = new DataSource\Chat($config);
   $chat->collectData(new Factory\StatisticsChatFactory());

   $chat_storage = new Storage\File\Json\Statistics($chat->statistics, __DIR__."/json/chat/");
   $chat_storage->save();
