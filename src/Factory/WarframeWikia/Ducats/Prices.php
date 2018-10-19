<?php
namespace WChart\Factory\WarframeWikia\Ducats;

/**
 * Get's the data from table and creates a array of name => value
 */
class Prices implements \WChart\Factory\FromScrapingFactoryInterface {

    public $document;

    public function create(string $document) : array {
        $this->document = $document;

        $dom = new \DOMDocument();

        //The Class dosn't really work well with HTML5 tags.
        //https://stackoverflow.com/questions/7082401/avoid-domdocument-xml-warnings-in-php
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        libxml_clear_errors();

        $table = $dom->getElementsByTagName("table");

        $first_iter = 0;
        foreach ($table[0]->getElementsByTagName("tr") as $tr) {
              //We don't need the header
              if($first_iter === 0) {
                  $first_iter++;
                  continue;
              }

              //Get base \DOMElements
              $columns = $tr->getElementsByTagName("td");
              $name = $columns->item(0);
              $value = $columns->item(2);

              //A function to trim the spaces on sides
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

              $items[trim(str_replace($exceptions["replace"], $exceptions["with"], $name->nodeValue))] = ["ducat" => intval(str_replace("*", "", trim($value->nodeValue)))];
        }

        return $items;
    }
}
