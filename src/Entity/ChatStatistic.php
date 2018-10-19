<?php
namespace WChart\Entity;

 /**
 * @Entity
 * @Table(name="chat_statistics")
 **/
class ChatStatistic implements \JsonSerializable {
    /**
    * @Id
    * @Column(type="bigint")
    * @GeneratedValue
    **/
    protected $id;
    /**
     * @ManyToOne(targetEntity="Item")
     * @JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item;
    /** @Column(type="integer") **/
    protected $min = 0;
    /** @Column(type="integer") **/
    protected $max = 0;
    /** @Column(type="integer") **/
    protected $avg = 0;
    /** @Column(type="integer") **/
    protected $median = 0;
    /** @Column(type="string") **/
    protected $type;
    /** @Column(type="datetime") **/
    protected $date;

    public function getItem() {
        return $this->item;
    }

    public function setItem($id) {
      $this->item = $id;
    }

    public function getMin() {
        return $this->min;
    }

    public function setMin(int $id) {
      $this->min = $id;
    }

    public function getMax() {
        return $this->max;
    }

    public function setMax(int $id) {
      $this->max = $id;
    }

    public function getAvg() {
        return $this->avg;
    }

    public function setAvg(int $id) {
      $this->avg = $id;
    }

    public function getMedian() {
        return $this->median;
    }

    public function setMedian(int $id) {
      $this->median = $id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($id) {
      $this->type = $id;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($id) {
      $this->date = $id;
    }

    public function jsonSerialize() {
      return get_object_vars($this);
    }
}
