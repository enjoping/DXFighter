<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/ellipse_dxf_06.htm
 */

namespace DXFighter\lib;

/**
 * Class Ellipse
 * @package DXFighter\lib
 */
class Ellipse extends Entity {
  protected $center;
  protected $endpoint;
  protected $extrusion;
  protected $ratio;
  protected $start;
  protected $end;

  function __construct($center, $endpoint, $ratio, $start = 0, $end = M_PI*2, $extrusion = array(0, 0, 1)) {
    $this->entityType = 'ellipse';
    $this->center = $center;
    $this->endpoint = $endpoint;
    $this->ratio = $ratio;
    $this->start = $start;
    $this->end = $end;
    $this->extrusion = $extrusion;
    parent::__construct();
  }

  public function render() {
    $output = parent::render();
    array_push($output, 100, 'AcDbEllipse');
    array_push($output, $this->point($this->center));
    array_push($output, $this->point($this->endpoint, 1));
    array_push($output, $this->point($this->extrusion, 200));
    array_push($output, 40, $this->ratio);
    array_push($output, 41, $this->start);
    array_push($output, 42, $this->end);
    return implode($output, PHP_EOL);
  }
}
