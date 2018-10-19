<?php
namespace WChart\Factory;
/**
 * Factory interface
 */
interface FromApiFactoryInterface {
    public function create(array $raw, \DateTime $date, $ent);
}
