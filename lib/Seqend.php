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

  /**
   * Seqend constructor.
   * @param $pointer
   * @param $layer
   */
  function __construct($pointer, $layer) {
    $this->entityType = 'seqend';
    $this->pointer = $pointer;
    $this->layer = $layer;
    parent::__construct();
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = parent::render();
    return implode(PHP_EOL, $output);
  }
}
