<?php
namespace Storage;

abstract class AbstractFile {
    protected function createDirIfNotExists(string $dirname) : void {
      if(!is_dir($dirname)) {
        mkdir($dirname, 0777);
      }
    }

    protected function createFileIfNotExists(string $dirpath, string $filename) : void {
      if(!file_exists($dirpath."/".$filename)) {
        touch($dirpath."/".$filename);
      }
    }

    protected function saveToFile(string $path, $data) : void {
        $file = fopen($path, "w");
        fwrite($file, $data);
        fclose($file);
    }

    abstract public function save();
}

?>
