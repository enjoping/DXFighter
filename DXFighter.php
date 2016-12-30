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

use DXFighter\lib\AppID,
  DXFighter\lib\Block,
  DXFighter\lib\BlockRecord,
  DXFighter\lib\Dictionary,
  DXFighter\lib\Layer,
  DXFighter\lib\LType,
  DXFighter\lib\Section,
  DXFighter\lib\Style,
  DXFighter\lib\SystemVariable,
  DXFighter\lib\Table;

function dxf_autoloader($className) {
  echo $className;
}


spl_autoload_register (function($class) {
  $class = str_replace('DXFighter\\lib\\', 'lib/', $class);
  require_once $class . '.php';
});



/**
 * Class DXFighter
 * @package DXFighter
 */
class DXFighter {
  protected $sections;
  protected $header;
  protected $classes;
  protected $tables;
  protected $blocks;
  protected $entities;
  protected $objects;
  protected $thumbnailImage;

  function __construct() {
    $this->sections = array('header', 'classes', 'tables', 'blocks', 'entities', 'objects', 'thumbnailImage');
    foreach ($this->sections as $section) {
      $this->{$section} = new Section($section);
    }
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
    $tableOrder = array('vport', 'ltype', 'layer', 'style', 'view', 'ucs', 'appid', 'dimstyle', 'block_record');
    foreach ($tableOrder as $table) {
      $tables[$table] = new Table($table);
    }
    $tables['appid']->addEntry(new AppID('ACAD'));

    $this->addBlock($tables, '*model_space');
    $this->addBlock($tables, '*paper_space');

    $tables['layer']->addEntry(new Layer('0'));

    $tables['ltype']->addEntry(new LType('byblock'));
    $tables['ltype']->addEntry(new LType('bylayer'));

    $tables['style']->addEntry(new Style('standard'));
    $this->tables->addMultipleItems($tables);

    $this->objects->addItem(new Dictionary(array('ACAD_GROUP')));
  }

  public function addBlock(&$tables, $name) {
    $tables['block_record']->addEntry(new BlockRecord($name));
    $this->blocks->addItem(new Block($name));
  }

  public function addEntity($entity) {
    $this->entities->addItem($entity);
  }

  /**
   * Outputs an array representation of the DXF
   *
   * @return array
   */
  public function toArray() {
    $output = array();
    foreach ($this->sections as $section) {
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
    foreach ($this->sections as $section) {
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
    fwrite($fh, iconv("UTF-8", "WINDOWS-1252", $this->toString(FALSE)));
    fclose($fh);
  }

}
