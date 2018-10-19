<?php
//// TODO: $additional like in MarketData to hide ID and stuff
namespace WChart\Repository;

/**
 * Chart data
 */
class ChatData {

  public $em; //Doctrine entity menager

  public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
  }
  //TODO: REMAKE THIS + ADD CACHING
  public function getChatTimeChartData(int $item_id, \DateTime $start, \DateTime $end, string $type = "both") {
    $startString = $start->format("Y-m-d");
    $endString = $end->format("Y-m-d");

    $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
    $cacheId = $startString.$endString;
    if(isset($type) && in_array($type, ["sell", "buy"])) $cacheId .= $type;

    if($cacheDriver->contains($cacheId)) {
      return $cacheDriver->fetch($cacheId);
    }

    $qb = $this->em->getRepository("WChart\Entity\ChatStatistic")->createQueryBuilder("stat");
    $qb->leftJoin('stat.item', 'item')
       ->where("item.id = :id")
       ->setParameter(":id", $item_id)
       ->andWhere('stat.date BETWEEN :start AND :end')
       ->setParameter(":start", $startString)
       ->setParameter(":end", $endString);
    if(isset($type) && in_array($type, ["sell", "buy"])) {
      $qb->andWhere("stat.type = :type")
         ->setParameter(":type", $type);
    }

    $result = $qb->getQuery()->getArrayResult();

    if($result) {
      $today = new \DateTime();

      $startStamp = $start->getTimestamp();
      $endStamp = $end->getTimestamp();
      $todayStamp = $today->getTimestamp();

      //If today is between those two dates cache it for an hour, else for lifetime.
      if($todayStamp > $startStamp && $todayStamp < $endStamp) {
        $cacheDriver->save($cacheId, $result, 3600);
      } else {
        $cacheDriver->save($cacheId, $result);
      }
    }

    return $result;
  }

  public function getChatTimeChartData2(int $item_id, \DateTime $start, \DateTime $end, string $type = "both") {
    $sql = "SELECT `date`,`min`,`max`,`avg`,`median`,`type`";
    $sql .= " FROM `chat_statistics`";
    //The range
    $start_date_string = $start->format("Y-m-d");
    $end_date_string = $end->format("Y-m-d");

    switch ($type) {
      case 'sell':
        $type_case = "`type` = :type AND";
        break;
      case 'buy':
        $type_case = "`type` = :type AND";
        break;
      case 'both':
        $type_case = "";
        break;
      default:
        return new \Exception("Only 'buy' and 'sell' types allowed");
        break;
    }

    $sql .= " WHERE $type_case `item_id` = :id AND `date` BETWEEN :start AND :end";

    $stmt = $this->em->getConnection()->prepare($sql);

    $stmt->bindParam(":id", $item_id, \PDO::PARAM_INT);
    $stmt->bindParam(":start", $start_date_string, \PDO::PARAM_STR, 10);
    $stmt->bindParam(":end", $end_date_string, \PDO::PARAM_STR, 10);
    if(strpos($sql, ":type")) $stmt->bindParam(":type", $type, \PDO::PARAM_STR);

    if($stmt->execute()) {
      $data = $stmt->fetchAll();
      return $data;
    } else {
      return false;
    }
  }

}
