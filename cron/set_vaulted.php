<pre>
<?php
require("password.php");
require_once "../src/bootstrap.php";
$config = $em->getRepository("WChart\Entity\Item")->findAll();
$vaulted = new WChart\DataSource\WarframeWikia();
$vaulted->setUrl("Prime_Vault");
$vaulted->collectData(new WChart\Factory\WarframeWikia\PrimeVault());


foreach ($config as $key => $entity) {
  $entity->setVaulted(false);

  foreach ($vaulted->result as $name_key => $name) {
    if(is_int(strpos($entity->getName(), $name))) {
      $entity->setVaulted(true);
      break;
    }
  }

  $em->persist($entity);
  $em->flush();
}
