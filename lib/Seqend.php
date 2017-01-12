<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/seqend_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Seqend
 * @package DXFighter\lib
 */
class Seqend extends Entity {
  protected $base = array(0, 0, 0);
  protected $thickness;
  protected $extrusion;
  protected $points = array();
  protected $dimension;

  function __construct($pointer, $layer) {
    $this->entityType = 'seqend';
    $this->pointer = $pointer;
    parent::__construct();
  }

  public function render() {
    $output = parent::render();
    return implode($output, PHP_EOL);
  }
}
