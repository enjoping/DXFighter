<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/polyline_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Polyline
 * @package DXFighter\lib
 */
class Polyline extends Entity {
  protected $base = array(0, 0, 0);
  protected $thickness;
  protected $extrusion;
  protected $points = array();
  protected $dimension;
  protected $seqend;

  function __construct($dimension = 2) {
    $this->entityType = 'polyline';
    $this->flags = array_fill(0, 7, 0);
    $this->dimension = $dimension;
    parent::__construct();
  }

  public function addPoint($point, $bulge = 0) {
    $this->points[] = new Vertex($point, $this->dimension, $this->handle, $this->layer, $bulge);
  }

  private function addSeqend() {
    $this->seqend = new Seqend($this->handle, $this->layer);
  }

  public function rotate($rotate, $rotationCenter = array(0,0,0)) {
    foreach($this->points as $point) {
      $point->rotate(deg2rad($rotate), $rotationCenter);
    }
  }

  public function render() {
    if(!isset($this->seqend)) {
      $this->addSeqend();
    }
    $output = parent::render();
    array_push($output, 100, 'AcDb'.$this->dimension.'dPolyline');
    array_push($output, $this->point($this->base));
    array_push($output, 70, $this->flagsToString());

    foreach($this->points as $point) {
      array_push($output, $point->render());
    }

    array_push($output, $this->seqend->render());
    return implode($output, PHP_EOL);
  }
}
