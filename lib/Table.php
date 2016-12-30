<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 *
 * Documentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/tables_section.htm
 */

namespace DXFighter\lib;

/**
 * Class Table
 * @package DXFighter\lib
 *
 * DXF files need several tables written in the table section.
 */
class Table extends BasicObject {
  protected $name;
  protected $entries;

  function __construct($name) {
    $this->name = $name;
    $this->entries = array();
    parent::__construct();
  }

  public function addEntry($entry) {
    $this->entries[] = $entry;
  }

  public function render() {
    $output = array();
    array_push($output, 0, "TABLE");
    array_push($output, 2, strtoupper($this->name));
    array_push($output, 5, $this->getHandle());
    array_push($output, 330, 0);
    array_push($output, 100, "AcDbSymbolTable");
    array_push($output, 70, count($this->entries));
    foreach($this->entries as $entry) {
      $output[] = $entry->render();
    }
    array_push($output, 0, "ENDTAB");
    return implode($output, PHP_EOL);
  }
}