<?php
namespace Factory\WarframeWikia\Ducats;

/**
 * Get's the data from table and creates a array of name => value
 */
class Prices implements \Factory\FromScrapingFactoryInterface {

    public $document;

    public function create(string $document) : array {
        $this->document = $document;

        $dom = new \DOMDocument();

        //The Class dosn't really work well with HTML5 tags.
        libxml_use_internal_errors(true);
        $dom->loadHTML($document);
        libxml_clear_errors();

        $table = $dom->getElementsByTagName("table");
        $items = [];
        for ($i=1; $i < $table->length; $i++) {
          $relic_table = $table->item($i);
          $first_iter = 0;
          foreach ($relic_table->getElementsByTagName("tr") as $tr) {
              //We don't need the header
              if($first_iter === 0) {
                  $first_iter++;
                  continue;
              }

              //Get base \DOMElements
              $columns = $tr->getElementsByTagName("td");
              $name = $columns->item(0);
              $value = $columns->item(1);

              //A function to trim the spaces on sides

              $items[trim(str_replace(["Systems Blueprint", "Chassis Blueprint", "Neuroptics Blueprint"], ["Systems", "Chassis", "Neuroptics"], $name->nodeValue))] = ["ducats" => intval(str_replace("*", "", trim($value->nodeValue)))];
          }
        }

        return $items;
    }
}
