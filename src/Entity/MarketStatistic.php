<?php
namespace WChart\Entity;

 /**
 * @Entity
 * @Table(name="market_statistics")
 **/
class MarketStatistic implements \JsonSerializable {
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
    protected $pc_min = 0;
    /** @Column(type="integer") **/
    protected $pc_avg = 0;
    /** @Column(type="integer") **/
    protected $pc_median = 0;
    /** @Column(type="integer") **/
    protected $pc_mode = 0;
    /** @Column(type="integer") **/
    protected $ps4_min = 0;
    /** @Column(type="integer") **/
    protected $ps4_avg = 0;
    /** @Column(type="integer") **/
    protected $ps4_median = 0;
    /** @Column(type="integer") **/
    protected $ps4_mode = 0;
    /** @Column(type="integer") **/
    protected $xbox_min = 0;
    /** @Column(type="integer") **/
    protected $xbox_avg = 0;
    /** @Column(type="integer") **/
    protected $xbox_median = 0;
    /** @Column(type="integer") **/
    protected $xbox_mode = 0;
    /** @Column(type="string") **/
    protected $type;
    /** @Column(type="datetime") **/
    protected $date;
    /** @Column(type="json_array") **/
    protected $source;

    public function getId() {
      return $this->id;
    }

    public function getItem() {
        return $this->item;
    }

    public function setItem($id) {
      $this->item = $id;
    }

    public function getMin(string $platform) {
        $prop = $platform."_min";
        return $this->$prop;
    }

    public function setMin(string $platform, int $id) {
      $prop = $platform."_min";
      $this->$prop = $id;
    }

    public function getAvg(string $platform) {
      $prop = $platform."_avg";
      return $this->$prop;
    }

    public function setAvg(string $platform, int $id) {
      $prop = $platform."_avg";
      $this->$prop = $id;
    }

    public function getMedian(string $platform) {
      $prop = $platform."_median";
      return $this->$prop;
    }

    public function setMedian(string $platform, int $id) {
      $prop = $platform."_median";
      $this->$prop = $id;
    }

    public function getMode(string $platform) {
      $prop = $platform."_mode";
      return $this->$prop;
    }

    public function setMode(string $platform, int $id) {
      $prop = $platform."_mode";
      $this->$prop = $id;
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
