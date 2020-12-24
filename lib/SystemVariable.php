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

const POINTITEMLABEL = 'point';

/**
 * Class SystemVariable
 * @package DXFighter\lib
 *
 * Can be used to define system wide variables
 */
class SystemVariable extends BasicObject {
  protected $variable;
  protected $values;

  /**
   * SystemVariable constructor.
   * @param $variable
   * @param $values
   */
  function __construct($variable, $values) {
    $this->variable = $variable;
    $this->values = $values;
    parent::__construct();
  }

  public function getName() {
    return $this->variable;
  }

  public function getValues() {
    return $this->values;
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = array();
    array_push($output, 9, "$" . strtoupper($this->variable));
    if (isset($this->values[POINTITEMLABEL])) {
      array_push($output, $this->point($this->values[POINTITEMLABEL]));
      unset($this->values[POINTITEMLABEL]);
    }
    foreach ($this->values as $groupCode => $value) {
      array_push($output, $groupCode, $value);
    }
    return implode(PHP_EOL, $output);
  }
}
