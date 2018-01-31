<?php
namespace Entity;

/**
 * Relics Entity
 */
class Relic implements \JsonSerializable {

    private $tier;
    private $type;
    private $common_rewards;
    private $uncommon_rewards;
    private $rare_rewards;

    function __construct(string $tier, string $type, array $common_rewards, array $uncommon_rewards, array $rare_rewards) {
        $this->tier = $tier;
        $this->type = $type;
        $this->common_rewards = $common_rewards;
        $this->uncommon_rewards = $uncommon_rewards;
        $this->rare_rewards = $rare_rewards;
    }

    public function getTier() {
        return $this->tier;
    }

    public function getType() {
        return $this->type;
    }

    public function getCommonRewards() {
        return $this->common_rewards;
    }

    public function getUncommonRewards() {
        return $this->uncommon_rewards;
    }

    public function getRareRewards() {
        return $this->rare_rewards;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
