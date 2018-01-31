<?php
namespace Factory;
/**
 * Factory interface
 */
interface FromApiFactoryInterface {
    public function create(array $raw, string $name);
}
?>
