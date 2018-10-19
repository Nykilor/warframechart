<?php
namespace WChart\Factory\WarframeWikia;

/**
 * Get's the data from table and creates a array of name => value
 */
class PrimeVault implements \WChart\Factory\FromScrapingFactoryInterface {

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
        $last_table = count($table) - 1;
        $items = [];
        $first_iter = 0;
        foreach ($table[$last_table]->getElementsByTagName("tr") as $tr) {
          //We don't need the header
          if($first_iter === 0) {
            $first_iter++;
            continue;
          }

          $columns = $tr->getElementsByTagName("td");
          $name = $columns->item(0);
          $date = $columns->item(1);
          $type = $columns->item(2);

          $items[] = trim($name->nodeValue);
        }

        return $items;
    }
}
