<pre>
<?php
ini_set('max_execution_time', 0);
require("password.php");
require_once "../src/bootstrap.php";

//DUCATS
$ducats = new WChart\DataSource\WarframeWikia();
$ducats->setUrl("Ducats/Prices/All");
$ducats->collectData(new \WChart\Factory\WarframeWikia\Ducats\Prices());
//DROP_LOCATION
$rel = new WChart\DataSource\WarframeWikia();
$rel->setUrl("Void_Relic/ByRewards/SimpleTable");
$rel->collectData(new \WChart\Factory\WarframeWikia\VoidRelic\ByRewards());
//ALL TOGETHER
$merged = array_merge_recursive($ducats->result, $rel->result);
//The entities to update
$config = $em->getRepository("WChart\Entity\Item")->findAll();

//Sets the value for each $entity by the $data key and value
$check = function($entity, $data, Doctrine\ORM\EntityManager $em) {
  //Set a value for each key where i.e."drop_location" will be used as "setDropLocation"
  foreach ($data as $key => $value) {
    $key = str_replace("_", "", ucwords($key, "_"));
    $set = "set".$key;
    $entity->{$set}($value);
  }
  $em->persist($entity);
  $em->flush();
};

foreach ($config as $entity) {
  $name = $entity->getName();
  //Only if there's an key in the $merged.
  if(array_key_exists($name, $merged)) {
    $check($entity, $merged[$name], $em);
  }
}
//relicByRelic
$rel = new WChart\DataSource\WarframeWikia();
$rel->setUrl("Void_Relic/ByRelic");
$rel->collectData();
$rel_s = new WChart\Storage\File\Json\Relic($rel->result, __DIR__."/../json/worldState/");

$cb = function(&$val){
  foreach ($val as $key => $value) {
    $val[$key] = array_keys($value);
  }
};

$rel_s->setCallback($cb);
$rel_s->save();
