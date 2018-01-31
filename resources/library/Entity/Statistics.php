<?php
namespace Entity;

/**
 * Statistics Entity
 */
class Statistics implements \JsonSerializable {

    private $name;
    private $min;
    private $max;
    private $avg;
    private $median;
    private $mode;
    private $orders;
    private $error;

    function __construct(string $name, $min, $max, $avg, $median, $mode, $orders, $error = null) {
        $this->name = $name;
        $this->min = $min;
        $this->max = $max;
        $this->avg = $avg;
        $this->median = $median;
        $this->mode = $mode;
        $this->orders = $orders;
        $this->error = $error;
    }

    public function getName() {
        return $this->name;
    }

    public function getMin() {
        return $this->min;
    }

    public function getMax() {
        return $this->max;
    }

    public function getAvg() {
        return $this->avg;
    }

    public function getMedian() {
        return $this->median;
    }

    public function getMode() {
      return $this->mode;
    }

    public function getOrders() {
        return $this->orders;
    }

    public function getError() {
        return $this->error;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
