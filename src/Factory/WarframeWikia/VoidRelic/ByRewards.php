<?php
namespace WChart\Factory\WarframeWikia\VoidRelic;

/**
 * Get's the data from table and creates a array of items and the relics they are asigned too
 */
class ByRewards implements \WChart\Factory\FromScrapingFactoryInterface {

    public $document;

    public function create(string $document) : array {
        $this->document = $document;

        $dom = new \DOMDocument();

        //The Class dosn't really work well with HTML5 tags.
        //https://stackoverflow.com/questions/7082401/avoid-domdocument-xml-warnings-in-php
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        libxml_clear_errors();

        $table = $dom->getElementsByTagName("table")->item(0);

        $result = [];
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

            $exceptions = [
              "replace" => [
                "Systems Blueprint",
                "Chassis Blueprint",
                "Neuroptics Blueprint",
                "Kavasa Prime Band",
                "Kavasa Prime Buckle"
              ],
              "with" => [
                "Systems",
                "Chassis",
                "Neuroptics",
                "Kavasa Prime Collar Band",
                "Kavasa Prime Collar Buckle"
              ]
            ];

            $full_item_name = $item->nodeValue." ".str_replace($exceptions["replace"], $exceptions["with"], $part->nodeValue);
            //check if the key exists, create if not.
            if(array_key_exists($full_item_name, $result) && array_key_exists("drop_location", $result[$full_item_name])) {
              $result[$full_item_name]["drop_location"] .= ",".strtolower($tier->nodeValue." ".$name->nodeValue);
            } else {
              $result[$full_item_name]["drop_location"] = strtolower($tier->nodeValue." ".$name->nodeValue);
            }
        }

        return $result;
    }

}
