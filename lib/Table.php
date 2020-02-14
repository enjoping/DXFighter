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
  protected $entryNames = [];

  /**
   * Table constructor.
   * @param $name
   */
  function __construct($name) {
    $this->name = $name;
    $this->entries = array();
    parent::__construct();
  }

  public function getName() {
    return $this->name;
  }

  /**
   * Add an entity object to the DXF object
   * @param $entry
   */
  public function addEntry($entry) {
    $name = strtoupper($entry->getName());
    if (!in_array($name, $this->entryNames)) {
      $this->entryNames[] = $name;
      $this->entries[] = $entry;
    }
  }

  public function getEntries() {
    return $this->entries;
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = array();
    array_push($output, 0, "TABLE");
    array_push($output, 2, strtoupper($this->name));
    array_push($output, 5, $this->getHandle());
    array_push($output, 330, 0);
    array_push($output, 100, "AcDbSymbolTable");
    array_push($output, 70, count($this->entries));
    foreach ($this->entries as $entry) {
      $output[] = $entry->render();
    }
    array_push($output, 0, "ENDTAB");
    return implode(PHP_EOL, $output);
  }
}