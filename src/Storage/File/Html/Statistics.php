<?php
namespace WChart\Storage\File\Html;

/**
 * Store data in files
 */

class Statistics extends \WChart\Storage\AbstractFile {
    //THE DATA OF FILE
    public $data;
    // THE DATE OF TIME
    public $date;
    public $full_file_array;
    public $path;
    public $platform_iteration = [];

    function __construct(array $data, string $path, array $iteration) {
        $this->data = $data;
        $this->date = getdate();
        $this->path = $path;
        $this->platform_iteration = $iteration;
    }

    public function save() : void {
        //Iteration for BUY, SELL
        foreach ($this->platform_iteration as $platform) {
          foreach ($this->data as $type => $value) {
              //Iteration trough entities
              $doc = $this->getDocHeader();

              $table = $this->getTableHeader();
              foreach ($value as $item => $entity) {
                  $table .= $this->createTableRow($entity, $platform);
              }
              $table .= $this->getTableFooter();

              $doc .= $this->createDocBody($table, $type, $platform);

              $this->createFileIfNotExists($this->path, $type.$platform.".html");
              $this->saveToFile($this->path.$type.$platform.".html", $doc);

          }
        }
    }

    private function createTableRow($statistic, $platform) : string {
        $name = $statistic["name"];
        $min = $statistic["min"];
        $avg = $statistic["avg"];
        $median = $statistic["median"];
        $mode = $statistic["mode"];

        if(is_array($min)) {
          $min = $min[$platform."_min"];
          $avg = $avg[$platform."_avg"];
          $median = $median[$platform."_median"];
          $mode = $mode[$platform."_mode"];
        }

        return <<<ROW
        <tr>
            <td>
            $name
            </td>
            <td>
            $min
            </td>
            <td>
            $avg
            </td>
            <td>
            $median
            </td>
            <td>
            $mode
            </td>
        </tr>
ROW;
    }

    private function getTableHeader() : string {
        return <<<HEADER
        <table>
            <thead>
              <tr>
                <th>ITEM</th>
                <th>MIN</th>
                <th>AVG</th>
                <th>MED</th>
                <th>MODE</th>
              </tr>
            </thead>
        <tbody>
HEADER;
    }

    private function getTableFooter() : string {
        return "</tbody></table>";
    }

    private function getDocHeader() : string {
        return <<<'THEDOC'
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <!-- Required meta tags -->
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <!-- Meta -->
          <title>War$frame</title>
          <meta name="subtitle" content="Price checking website!">
          <meta name="Keywords" content="warframe, warframe.market, nexus-stats, market, value, prices, compare, weapons, primed mods, warframe market, nexus stats, warframe auction house, warframe items list, listing">
          <meta name="author" content="Adam Migacz/Nykilor/Marmolada">
          <meta name="google" content="notranslate">
          <meta name="HandheldFriendly" content="True">
          <!-- OpenGraph -->
          <meta property="og:title" content="Warframechart">
          <meta property="og:type" content="website">
          <meta property="og:url" content="https://warframechart.ct8.pl">
          <meta property="og:image" content="https://warframechart.ct8.pl/img/darvo.png">
          <meta property="og:description" content="War$frame is a site where you can check price of multiple items at once and check how it changes overtime. Futhermore it allows to check the relic drops!">
          <link rel="apple-touch-icon" sizes="180x180" href="../icons/apple-touch-icon.png">
          <link rel="icon" type="image/png" sizes="32x32" href="../icons/favicon-32x32.png">
          <link rel="icon" type="image/png" sizes="16x16" href="../icons/favicon-16x16.png">
          <link rel="manifest" href="../icons/manifest.json">
          <link rel="mask-icon" href="../icons/safari-pinned-tab.svg" color="#5bbad5">
          <link rel="shortcut icon" href="../icons/favicon.ico">
          <meta name="apple-mobile-web-app-title" content="War$frame">
          <meta name="application-name" content="War$frame">
          <meta name="msapplication-config" content="../icons/browserconfig.xml">
          <meta name="theme-color" content="#ffffff">
          <style>
            table {
                border-collapse: collapse;
                width: 100%;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            }

            thead tr th {
                border-bottom: 1px solid black;
                padding: 10px 5px;
            }

            tbody tr td {
                border-bottom: 1px solid gray;
                padding: 6px;
            }

            tr td:nth-child(n+2), tr th:nth-child(n+2) {
                text-align: right;
            }

            h1 {
                text-transform: capitalize;
            }

            @media print {
                a {
                    display: none;
                }
            }
          </style>
        </head>
THEDOC;
    }

    private function createDocBody(string $body_content, $type, $platform) : string {
        return "<body><a href='../nojs/'>GO TO MENU</a><h1>".$platform." ".$type." statistics</h1>".$body_content."</body></html>";
    }
}
