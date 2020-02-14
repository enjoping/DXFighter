<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 *
 * Documentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/appid_dxf_04.htm
 */

namespace DXFighter\lib;

/**
 * Class AppID
 * @package DXFighter\lib
 *
 * The AppID does not do anything to the DXF it's just to name the software
 * which was used to generate the DXF file.
 */
class AppID extends BasicObject {
  protected $name;
  protected $flag;

  /**
   * AppID constructor.
   * @param $name
   * @param int $flag
   */
  function __construct($name, $flag = 0) {
    $this->name = $name;
    $this->flag = $flag;
    parent::__construct();
  }

  public function getName() {
    return $this->name;
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = array();
    array_push($output, 0, "APPID");
    array_push($output, 5, $this->getHandle());
    array_push($output, 100, "AcDbSymbolTableRecord");
    array_push($output, 100, "AcDbRegAppTableRecord");
    array_push($output, 2, strtoupper($this->name));
    array_push($output, 70, $this->flag);
    return implode(PHP_EOL, $output);
  }
}