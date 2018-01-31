<?php
namespace Factory\WarframeWikia\VoidRelic;
use Entity as E;

/**
 * Get's the data from table and creates a array of relics
 */
class ByRelic implements \Factory\FromScrapingFactoryInterface {

    public $document;

    public function create(string $document) : array {
        $this->document = $document;

        $dom = new \DOMDocument();

        //The Class dosn't really work well with HTML5 tags.
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        libxml_clear_errors();

        $table = $dom->getElementsByTagName("table")->item(0);

        $entities = [];
        $first_iter = 0;
        foreach ($table->getElementsByTagName("tr") as $tr) {
            //We don't need the header
            if($first_iter === 0) {
                $first_iter++;
                continue;
            }
            $removeSideSpace = function ($elem) {
                return trim($elem);
            };

            //Get base \DOMElements
            $columns = $tr->getElementsByTagName("td");
            $tier = $columns->item(0);
            $type = $columns->item(1);
            $common = $columns->item(2);
            $uncommon = $columns->item(3);
            $rare = $columns->item(4);

            //A function to trim the spaces on sides


            $common_array = $this->createArrayFromNodeListBy("li", $common, $removeSideSpace);
            $uncommon_array = $this->createArrayFromNodeListBy("li", $uncommon, $removeSideSpace);
            $rare_array = $this->createArrayFromNodeListBy("li", $rare, $removeSideSpace);

            $entities[] = new E\Relic($removeSideSpace($tier->nodeValue), $removeSideSpace($type->nodeValue), $common_array, $uncommon_array, $rare_array);
        }

        return $entities;
    }

    private function createArrayFromNodeListBy(string $tag, \DOMElement $elem, $callback = false) : array {
        $array = [];
        foreach ($elem->getElementsByTagName($tag) as $child) {
            if($callback) {
                $array[] = str_replace(["Systems Blueprint", "Chassis Blueprint"], ["Systems", "Chassis"], $callback($child->nodeValue));
            } else {
                $array[] = str_replace(["Systems Blueprint", "Chassis Blueprint"], ["Systems", "Chassis"], $child->nodeValue);
            }
        }

        return $array;
    }
}
