<?php

namespace WChart\Repository;

/**
 * Chart data
 */
class MarketData {

  /**
   * Instance of \Doctrine\ORM\EntityManager from bootstrap.php
   * @var \Doctrine\ORM\EntityManager
   */
  public $em;

  public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
  }

  public function getMarketTimeChartData(int $item_id, \DateTime $start, \DateTime $end, $additional = false) {
    $startString = $start->format("Y-m-d");
    $endString = $end->format("Y-m-d");

    if($additional) {
      if(isset($additional["platform"]) && in_array($additional["platform"], ["pc", "ps4", "xbox"])) {
        $platform = [$additional["platform"]];
      } else {
        $platform = ["pc", "ps4", "xbox"];
      }
      $cols = ["min", "avg", "median", "mode"];
      $custom = ["stat.date"];

      foreach ($cols as $value) {
        foreach ($platform as $platform_string) {
          $custom[] = "stat.".$platform_string."_".$value;
        }
      }

      if($additional && isset($additional["type"]) && in_array($additional["type"], ["sell", "buy"])) {
        $type = $additional["type"];
      } else {
        $custom[] = "stat.type";
      }

      if(isset($additional["show_id"])) {
        if($additional["show_id"] === false) {
          $custom[] = "stat.id";
        }
      } else {
        $custom[] = "stat.id";
      }

      if(isset($additional["show_source"])) {
        if($additional["show_source"] === false) {
          $custom[] = "stat.source";
        }
      } else {
        $custom[] = "stat.source";
      }

      $query_builder_select = implode(",", $custom);
    }

    //GOT TO GET OTHER CACHE DRIVER
    $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
    $cacheId = $startString.$endString;
    if(isset($type)) $cacheId .= $type;
    if(isset($platform) && count($platform) === 1) $cacheId .= $platform[0];


    if($cacheDriver->contains($cacheId)) {
      return $cacheDriver->fetch($cacheId);
    }

    $qb = $this->em->getRepository("WChart\Entity\MarketStatistic")->createQueryBuilder("stat");
    if(isset($query_builder_select)) {
      $qb->select($query_builder_select);
    }
    $qb->leftJoin('stat.item', 'item')
       ->where("item.id = :id")
       ->setParameter(":id", $item_id)
       ->andWhere('stat.date BETWEEN :start AND :end')
       ->setParameter(":start", $startString)
       ->setParameter(":end", $endString);
    if(isset($type)) {
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

  public function getThisWeekSource() {
    $end = date("Y-m-d", strtotime('sunday this week'));
    $start = date("Y-m-d", strtotime('monday this week'));

    $qb = $this->em->getRepository("WChart\Entity\MarketStatistic")->createQueryBuilder("stat");
    $qb->select("stat.source, stat.date");
    $qb->where("stat.date BETWEEN :start and :end")
       ->setParameter(":start", $start)
       ->setParameter(":end", $end);

    $result = $qb->getQuery()->getArrayResult();


    return $result;
  }

}
