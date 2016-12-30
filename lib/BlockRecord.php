<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/block95record_dxf_04.htm
 */

namespace DXFighter\lib;

/**
 * Class BlockRecord
 * @package DXFighter\lib
 */
class BlockRecord extends BasicObject {
  protected $name;

  function __construct($name) {
    $this->name = $name;
    parent::__construct();
  }

  public function render() {
    $output = array();
    array_push($output, 0, "BLOCK_RECORD");
    array_push($output, 5, $this->getHandle());
    array_push($output, 100, "AcDbSymbolTableRecord");
    array_push($output, 100, "AcDbBlockTableRecord");
    array_push($output, 2, strtoupper($this->name));
    return implode($output, PHP_EOL);
  }
}