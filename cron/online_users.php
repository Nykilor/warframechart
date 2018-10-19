<pre>
<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
require("password.php");
require_once "../src/bootstrap.php";

// $query = $em->createQuery('SELECT u FROM WChart\Entity\User u WHERE u.name = ?1 AND u.platform = ?2')->setMaxResults(1);
// $query->setParameter(1, "A013452353");
// $query->setParameter(2, "PC");
// var_dump($query->getResult());
// exit();

$user_repo = $em->getRepository("WChart\Entity\User");
$users = [];

$market_repo = new WChart\Repository\MarketData($em);
$sources = $market_repo->getThisWeekSource();
$generation_date = new DateTime();
//TODO THIS DOSNT WORK GOOD SOMETHING IS WORNG WITH THE HOURS CALCULATION MAKES IT OMMIT F.I. Hour 14 for player A013452353
foreach ($sources as $key => $value) {
  $source = $value["source"];
  $source_period = intval($value["date"]->format("H"));
  $source_day = intval($value["date"]->format("j"));

  //If no source just continue
  if(!is_null($source)) {
    foreach ($source as $platform_player => $price) {
      //If the entity is created in $users just grab it
      if(array_key_exists($platform_player, $users)) {
        $entity = $users[$platform_player]["entity"];
      } else {
        $colon_pos = strpos($platform_player, ":");
        $player = substr($platform_player, $colon_pos+1);
        $platform = substr($platform_player, 0, $colon_pos);
        //Check if maybe the player is already in db (takes more time but less memory)
        $from_db_user = $user_repo->findBy(["name" => $player, "platform" => $platform]);
        //Less time but more memory
        // $query = $em->createQuery('SELECT u FROM WChart\Entity\User u WHERE u.name = ?1 AND u.platform = ?2')->setMaxResults(1);
        // $query->setParameter(1, $player);
        // $query->setParameter(2, $platform);
        // $from_db_user = $query->getResult();

        //If not create a new entity
        if(empty($from_db_user)) {
          $entity = new WChart\Entity\User();
          $entity->setName($player);
          $entity->setPlatform($platform);
          //Else grab it and reset periods to 0
        } else {
          $entity = $from_db_user[0];
          $entity->setSource([]);
        }

        $entity->setDate(new \DateTime());
      }
      //Set array for checkinf if we already got a peroid of this day
      if(!array_key_exists($platform_player, $users)) {
        $users[$platform_player]["day"] = [];
      }

      if(!array_key_exists($source_day ,$users[$platform_player]["day"])) {
        $users[$platform_player]["day"][$source_day] = [];
      }

      if(!in_array($source_period, $users[$platform_player]["day"][$source_day])) {
        $users[$platform_player]["day"][$source_day][] = $source_period;
        $entity_source_days = $entity->getSource();
        $entity_source_days[] = $value["date"];
        $entity->setSource($entity_source_days);
      }


      $users[$platform_player]["entity"] = $entity;
    }
  }
}

//Iterate trough them and add to DB
$batchSize = 20;
$iter = 0;
foreach($users as $key => $user) {
  $entity = $user["entity"];
  if(is_null($entity->getId())) {
    $em->persist($entity);
  } else {
    $em->merge($entity);
  }
  //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/batch-processing.html
  if (($iter % $batchSize) === 0) {
       $em->flush();
       $em->clear(); // Detaches all objects from Doctrine!
   }
   $iter++;
}
$em->flush(); //Persist objects that did not make up an entire batch
$em->clear();

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo "Process Time: {$time} <br>";
echo "Memory: ".(memory_get_peak_usage(true)/1024/1024)." MB";
