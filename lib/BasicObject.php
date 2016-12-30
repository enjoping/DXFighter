<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:26
 */

namespace DXFighter\lib;

/**
 * Class BasicObject
 * @package DXFighter\lib
 *
 * This class describes the basic structure of every element
 * The $handle variable is kind of an index which is unique for
 * every element in a DXF file.
 */
class BasicObject {
  public static $id = 1;
  protected $handle;

  function __construct() {
    $this->handle = self::$id;
    self::$id++;
  }

  /**
   * Returns a hexadecimal representation of the objects id.
   *
   * @return string
   */
  public function getHandle() {
    return strtoupper(dechex($this->handle));
  }

  public function render() {

  }

  /**
   * Function to convert an array with coordinates of a point
   * to a string.
   *
   * @param $point
   * @param int $offset
   * @return string
   */
  protected function point($point, $offset = 0) {
    $output = array();
    $groupCode = 10 + $offset;
    foreach ($point as $value) {
      array_push($output, $groupCode, sprintf("%.3f", $value));
      $groupCode += 10;
    }
    return implode($output, PHP_EOL);
  }
}