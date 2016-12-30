<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/endblk_dxf_05.htm
 */

namespace DXFighter\lib;

/**
 * Class Endblk
 * @package DXFighter\lib
 */
class Endblk extends Entity {

  function __construct($layer, $pointer) {
    $this->entityType = 'endblk';
    $this->layer = $layer;
    $this->pointer = $pointer;
    parent::__construct();
  }

  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbBlockEnd');
    return implode($output, PHP_EOL);
  }
}
