<?php
/**
 * DXFighter
 * Inspired by https://github.com/nycresistor/SDXF/blob/master/sdxf.py
 * Basis by https://github.com/digitalfotografen/DXFwriter
 * Updated to AC1012 by https://github.com/enjoping
 *
 * DXF Documentation at http://www.autodesk.com/techpubs/autocad/acad2000/dxf/
 */

namespace DXFighter;

use DXFighter\lib\Section,
  DXFighter\lib\SystemVariable,
  DXFighter\lib\Table,
  DXFighter\lib\AppID,
  DXFighter\lib\BlockRecord,
  DXFighter\lib\Layer,
  DXFighter\lib\LType,
  DXFighter\lib\Style;

function __autoload($class_name) {
  $class_name = str_replace('DXFighter\\', '', $class_name);
  require_once $class_name . '.php';
}

/**
 * Class DXFighter
 * @package DXFighter
 */
class DXFighter {
  protected $header;
  protected $classes;
  protected $tables;
  protected $blocks;
  protected $entities;
  protected $objects;
  protected $thumbnailImage;

  function __construct() {
    $this->header = new Section('header');
    $this->classes = new Section('classes');
    $this->tables = new Section('tables');
    $this->blocks = new Section('blocks');
    $this->entities = new Section('entities');
    $this->objects = new Section('objects');
    $this->thumbnailImage = new Section('thumbnailimage');
    $this->addBasicObjects();
  }

  /**
   * Private function, called while constructing a new object of this class.
   * As DXF files have to fit certain requirements we need all these basic items.
   */
  private function addBasicObjects() {
    $this->header->addItem(new SystemVariable("acadver", array(1 => "AC1012")));
    $this->header->addItem(new SystemVariable("dwgcodepage", array(3 => "ANSI_1252")));
    $this->header->addItem(new SystemVariable("insbase", array('point' => array(0, 0, 0))));
    $this->header->addItem(new SystemVariable("extmin", array('point' => array(0, 0, 0))));
    $this->header->addItem(new SystemVariable("extmax", array('point' => array(0, 0, 0))));

    $tables = array();
    foreach (array('appid', 'block_record', 'dimstyle', 'layer', 'ltype', 'style', 'ucs', 'view', 'vport') as $table) {
      $tables[$table] = new Table($table);
    }
    $tables['appid']->addEntry(new AppID('DXFighter'));

    $tables['block_record']->addEntry(new BlockRecord('*model_space'));
    $tables['block_record']->addEntry(new BlockRecord('*paper_space'));

    $tables['layer']->addEntry(new Layer('0'));

    $tables['ltype']->addEntry(new LType('byblock'));
    $tables['ltype']->addEntry(new LType('bylayer'));

    $tables['style']->addEntry(new Style('standard'));
    $this->tables->addMultipleItems($tables);
  }

  /**
   * Outputs an array representation of the DXF
   *
   * @return array
   */
  public function toArray() {
    $output = array();
    foreach (array('header', 'classes', 'tables', 'blocks', 'entities', 'objects', 'thumbnailImage') as $section) {
      $output[strtoupper($section)] = $this->{$section}->toArray();
    }
    return $output;
  }

  /**
   * Returns or outputs the DXF as a string
   *
   * @param bool|TRUE $return
   * @return string
   */
  public function toString($return = TRUE) {
    $output = array();
    array_push($output, 999, "DXFighter");
    foreach (array('header', 'classes', 'tables', 'blocks', 'entities', 'objects', 'thumbnailImage') as $section) {
      $output[] = $this->{$section}->render();
    }
    array_push($output, 0, "EOF");
    $output_string = implode($output, PHP_EOL);

    if ($return) {
      echo nl2br($output_string);
      return '';
    } else {
      return $output_string;
    }
  }

  /**
   * Save the DXF to a specific place
   *
   * @param $fileName
   */
  public function saveAs($fileName) {
    $fh = fopen($fileName, 'w');
    fwrite($fh, iconv("UTF-8", "WINDOWS-1252", $this->render(FALSE)));
    fclose($fh);
  }

}
