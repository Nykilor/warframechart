<?php

namespace WChart\Repository;

/**
 * Chart data
 */
class User {

  /**
   * Instance of \Doctrine\ORM\EntityManager from bootstrap.php
   * @var \Doctrine\ORM\EntityManager
   */
  public $em;

  public function __construct(\Doctrine\ORM\EntityManager $em) {
    $this->em = $em;
  }

  public function getUser(string $name, string $platform) {
    $repo = $this->em->getRepository("WChart\Entity\User");
    $result = $repo->findBy(["name" => $name, "platform" => $platform]);

    return $result;
  }
}
