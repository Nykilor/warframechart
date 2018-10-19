<pre>
<?php
require("password.php");
require_once "../src/bootstrap.php";
$config = $em->getRepository("WChart\Entity\Item")->findAll();

$add_after_loop = [];
$to_update = [];
foreach ($config as $key => $entity) {
  if(strpos($entity->getName(), "Set") >= 0) {
    $parts_list = $entity->getSetParts();
    $sum = 0;

    foreach ($parts_list as $id) {
      $part = $config[$id-1];
      $ducat = $part->getDucat();

      if($part->getDoublePart()) {
        $sum += $ducat * 2;
      } else {
        $sum += $ducat;
      }


      if($ducat === 0) {
        $add_after_loop[] = ["entity" => $key, "part" => $id];
      }

      $entity->setDucat($sum);
    }
    $to_update[$key] = $entity;
  }
}

foreach ($add_after_loop as $pairs) {
  $entity = $config[$pairs["entity"]];
  $part = $config[$pairs["part"]-1];

  $ducat = $entity->getDucat();
  $part_ducat = $part->getDucat();

  if($part->getDoublePart()) {
    $ducat += $part_ducat * 2;
  } else {
    $ducat += $part_ducat;
  }

  $entity->setDucat($ducat);

  $to_update[$pairs["entity"]] = $entity;
}

foreach ($to_update as $entity) {
  $em->persist($entity);
  $em->flush();
}
