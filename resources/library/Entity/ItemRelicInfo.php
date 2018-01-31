<?php
namespace Entity;

/**
 * Items relics info Entity
 */
class ItemRelicInfo implements \JsonSerializable {

    private $item;
    private $part;
    private $relic;

    function __construct(string $item, string $part, string $relic) {
        $this->item = $item;
        $this->part = $part;
        $this->relic = $relic;
    }

    public function getItem() {
        return $this->item;
    }

    public function getPart() {
        return $this->Part;
    }

    public function getRelic() {
        return $this->relic;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
