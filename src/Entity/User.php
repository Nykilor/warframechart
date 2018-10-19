<?php
namespace WChart\Entity;

use Ev;

 /**
 * @Entity
 * @Table(name="user")
 **/
class User implements \JsonSerializable {
    /**
    * @Id
    * @Column(type="integer")
    * @GeneratedValue
    **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $platform;
    /** @Column(type="datetime") **/
    protected $date;
    /** @Column(type="json_array") **/
    protected $source = [];

    public function __construct() {
      $this->date = new \DateTime();
    }

    public function getId() {
      return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getPlatform() {
        return $this->platform;
    }

    public function setPlatform(string $name) {
        $this->platform = $name;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($id) {
      $this->date = $id;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($id) {
      $this->source = $id;
    }

    public function jsonSerialize() {
      return get_object_vars($this);
    }
}
