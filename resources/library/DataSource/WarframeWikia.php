<?php
namespace DataSource;
use Factory as F;
/**
 * A class to get pages from warframe wikia (the api from the wiki dosn't return any content)
 */

class WarframeWikia {

    private $base_url = "http://warframe.wikia.com/wiki/";
    private $url;
    private $default_factory_class;

    public function collectData(F\FromScrapingFactoryInterface $factory = null) {
        if(!isset($this->url)) {
            throw new \Exception("You've got to set a proper url with the 'setUrl' method.");
        }
        $result = file_get_contents($this->url);

        if($factory === null) {
            $default_class = "Factory\\WarframeWikia\\".str_replace(["_","/"], ["","\\"], $this->default_factory_class);
            $factory = new $default_class();
        }

        $this->entities = $factory->create($result, $this->default_factory_class);

    }

    public function setUrl(string $url_end) : void {
        $this->url = $this->base_url.$url_end;
        $this->default_factory_class = $url_end;
    }

    public function getUrl() : string {
        return $this->url;
    }
}
