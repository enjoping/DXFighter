<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 19:23
 *
 * Documentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/general_dxf_file_structure_dxf_aa.htm
 */
namespace DXFighter\lib;

/**
 * Class Section
 * @package DXFighter\lib
 *
 * Every DXF file is build up of multiple sections which contain
 * differnt parts of the DXF definition. Some of them are mandatory, these are:
 * header, classes, tables, blocks, entities, objects and thumbnailimage.
 */
class Section {
  protected $name;
  protected $items = array();

  function __construct($name, $items = array()) {
    $this->name = $name;
    $this->items = $items;
  }

  /**
   * Adds an Item to the items list
   *
   * @param BasicObject $item
   */
  public function addItem(BasicObject $item) {
    $this->items[] = $item;
  }

  /**
   * Adds an array of Items to the items list
   *
   * @param array $items
   */
  public function addMultipleItems($items) {
    foreach($items as $item) {
      $this->addItem($item);
    }
  }

  /**
   * render function to print the section
   *
   * @return string
   */
  public function render() {
    $output = array();
    array_push($output, 0, "SECTION");
    array_push($output, 2, strtoupper($this->name));
    foreach($this->items as $item){
      array_push($output, $item->render());
    }
    array_push($output, 0, "ENDSEC");
    return implode($output, PHP_EOL);
  }

  /**
   * Outputs an array representation of the Section
   * TODO: Find a good way to export the Section
   *
   * @return array
   */
  public function toArray() {
    $output = array();
    return $output;
  }

}