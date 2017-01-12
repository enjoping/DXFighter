<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 *
 * Documentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/header_section_group_codes_dxf_02.htm
 */

namespace DXFighter\lib;

/**
 * Class SystemVariable
 * @package DXFighter\lib
 *
 * Can be used to define system wide variables
 */
class SystemVariable extends BasicObject {
  protected $variable;
  protected $values;

  function __construct($variable, $values) {
    $this->variable = $variable;
    $this->values = $values;
    parent::__construct();
  }

  public function render() {
    $output = array();
    array_push($output, 9, "$" . strtoupper($this->variable));
    $values = $this->values;
    if(isset($values['point'])){
      array_push($output, $this->point($values['point']));
      unset($values['point']);
    }
    foreach($values as $groupCode => $value){
      array_push($output, $groupCode, $value);
    }
    return implode($output, PHP_EOL);
  }
}