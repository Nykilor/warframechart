<?php
namespace Factory\WarframeWikia\VoidRelic;
use Entity as E;

/**
 * Get's the data from table and creates a array of items and the relics they are asigned too
 */
class ByRewards implements \Factory\FromScrapingFactoryInterface {

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
            $item = $columns->item(0);
            $part = $columns->item(1);
            $tier = $columns->item(2);
            $name = $columns->item(3);

            //A function to trim the spaces on sides

            $entities[] = new E\ItemRelicInfo(
                $item->nodeValue,
                str_replace(["Systems Blueprint", "Chassis Blueprint", "Neuroptics Blueprint"], ["Systems", "Chassis", "Neuroptics"], $part->nodeValue),
                strtolower($tier->nodeValue." ".$name->nodeValue)
            );
        }

        return $entities;
    }

}
