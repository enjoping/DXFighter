<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 *
 * Documentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/style_dxf_04.htm
 */

namespace DXFighter\lib;

/**
 * Class Style
 * @package DXFighter\lib
 *
 * Allows us to define multiple text stiles which can be applied to text elements.
 */
class Style extends BasicObject {
  protected $name;
  protected $flag;
  protected $height;
  protected $width;
  protected $lineType;

  function __construct($name, $flag = 0, $height = 0, $width = 1, $lineType = 'CONTINUOUS') {
    $this->name = $name;
    $this->flag = $flag;
    $this->height = $height;
    $this->width = $width;
    $this->lineType = $lineType;
    parent::__construct();
  }

  public function render() {
    $output = array();
    array_push($output, 0, "STYLE");
    array_push($output, 5, $this->getHandle());
    array_push($output, 100, "AcDbSymbolTableRecord");
    array_push($output, 100, "AcDbTextStyleTableRecord");
    array_push($output, 2, strtoupper($this->name));
    array_push($output, 70, $this->flag);
    array_push($output, 6, $this->lineType);
    return implode($output, PHP_EOL);
  }
}