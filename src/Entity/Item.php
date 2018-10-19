<?php
namespace WChart\Entity;

 /**
 * @Entity
 * @Table(name="items")
 **/
class Item implements \JsonSerializable {
    /**
    * @Id
    * @Column(type="integer")
    * @GeneratedValue
    **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $drop_location = "none";
    /** @Column(type="integer") **/
    protected $ducat = 0;
    /** @Column(type="boolean") **/
    protected $vaulted = false;
    /** @Column(type="boolean") **/
    protected $double_part = false;
    /** @Column(type="json_array") **/
    protected $set_parts;
    /** @Column(type="string") **/
    protected $item_type = "not_set";

    public function getId() {
      return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setDropLocation(string $drop) {
      $this->drop_location = $drop;
    }

    public function getDropLocation() {
        return $this->drop_location;
    }

    public function setDucat(int $ducat) {
      $this->ducat = $ducat;
    }

    public function getDucat() {
        return $this->ducat;
    }

    public function setVaulted(bool $v) {
      $this->vaulted = $v;
    }

    public function getVaulted() {
        return $this->vaulted;
    }

    public function setDoublePart(bool $v) {
      $this->double_part = $v;
    }

    public function getDoublePart() {
        return $this->double_part;
    }

    public function getSetParts() {
      return $this->set_parts;
    }

    public function setSetParts($v) {
      return $this->set_parts = $v;
    }

    public function getItemType() {
      return $this->item_type;
    }

    public function setItemType($v) {
      return $this->item_type = $v;
    }

    public function jsonSerialize() {
      return get_object_vars($this);
    }
}
