<pre>
<?php
//TODO THE USER ENTITY GETS SOMEHWERE WRONG UPDATE IT SO IT DOES WORK
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
require("password.php");
require_once "../src/bootstrap.php";


$user_repo = $em->getRepository("WChart\Entity\User");
$users = [];
$market_repo = new WChart\Repository\MarketData($em);
$generation_date = new DateTime();

//$days = ["monday", "tuesday", "wendnesday", "thursday", "friday", "saturday", "sunday"];
$days = ["2018-12-31", "2019-01-01", "2019-01-02", "2019-01-03", "2019-01-04", "2019-01-05", "2019-01-06"];
foreach ($days as $day) {
  $day_of_week = $day; //$day_of_week = date("Y-m-d", strtotime("$day this week"));
  $source = $market_repo->getDaySource($day);

  foreach ($source as $key => $value) {
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
          $from_db_user = $user_repo->findBy(["name" => $player, "platform" => $platform]);

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

          $entity->setDate($generation_date);
        }
        //$user_repo->clear();
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
echo "Memory: ".(memory_get_peak_usage(true)/1024/1024)." MB, ".memory_get_peak_usage(true);
