<?php
ini_set('max_execution_time', 0);
require("password.php");
require_once "../src/bootstrap.php";

$get = $_GET["name"];
$to_insert = explode(",", $get);

foreach ($to_insert as $value) {
  $ent = new WChart\Entity\Item();
  $ent->setName($value);

  $em->persist($ent);
  $em->flush();
}
