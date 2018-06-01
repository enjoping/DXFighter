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
use DXFighter\lib\Ellipse;
use DXFighter\lib\Line;
use DXFighter\lib\Text;
use PHPUnit\Framework\Exception;

/**
 * Returns the class name, used for auto loading libraries
 * @param $className
 */
function dxf_autoloader($className) {
  echo $className;
}

/**
 * Handle class auto loading from lib folder
 */
spl_autoload_register(function($class) {
  $class = str_replace('DXFighter\\lib\\', 'lib/', $class);
  if (file_exists($class . '.php')) {
    require_once $class . '.php';
  }
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

  /**
   * DXFighter constructor.
   * sets basic values needed for further usage if the init flag is set
   *
   * @param bool $init
   */
  function __construct($init = TRUE) {
    $this->sections = array(
      'header',
      'classes',
      'tables',
      'blocks',
      'entities',
      'objects',
      'thumbnailImage'
    );
    foreach ($this->sections as $section) {
      $this->{$section} = new Section($section);
    }
    if ($init) {
      $this->addBasicObjects();
    }
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

  /**
   * Handler for adding block entities to the DXF file
   * @param $tables
   * @param $name
   */
  public function addBlock(&$tables, $name) {
    $tables['block_record']->addEntry(new BlockRecord($name));
    $this->blocks->addItem(new Block($name));
  }

  /**
   * Handler to add an entity to the DXFighter instance
   * @param $entity
   */
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
    $outputString = implode($output, PHP_EOL);

    if ($return) {
      echo nl2br($outputString);
      return '';
    } else {
      return $outputString;
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

  public function read($path) {
    if (!file_exists($path) || !filesize($path)) {
      throw new Exception('The path to the file is either invalid or the file is empty');
    }
    $content = file_get_contents($path);
    $lines = preg_split ('/$\R?^/m', $content);
    $values = [];
    for ($i = 0; $i < count($lines); $i++) {
      $values[] = [
        'key' => $lines[$i++],
        'value' => $lines[$i]
      ];
    }
    $this->readDocument($values);
  }

  private function readDocument($values) {
    $section_pattern = [
      'name' => '',
      'values' => [],
    ];
    $section = $section_pattern;
    foreach ($values as $value) {
      if ($value['key'] == 0) {
        if ($value['value'] == 'SECTION') {
          $section = $section_pattern;
          continue;
        } elseif ($value['value'] == 'ENDSEC') {
          switch ($section['name']) {
            case 'HEADER':
              $this->readHeaderSection($section['values']);
              break;
            case 'TABLES':
              $this->readTablesSection($section['values']);
              break;
            case 'ENTITIES':
              $this->readEntitiesSection($section['values']);
              break;
            default:
              if (count($section['values'])) {
                // TODO BLOCKS and OBJECTS section are still missing
                #echo "Section " . $section['name'] . " with " . count($section['values']) . " elements is currently ignored" . PHP_EOL;
              }
              break;
          }
          continue;
        }
      }
      if ($value['key'] == 2 && empty($section['name'])) {
        $section['name'] = $value['value'];
        continue;
      }
      $section['values'][] = $value;
    }
  }

  private function readHeaderSection($values) {
    $variable_pattern = [
      'name' => '',
      'values' => [],
    ];
    $variables = [];
    $variable = $variable_pattern;
    foreach ($values as $value) {
      if ($value['key'] == 9) {
        if (!empty($variable['values'])) {
          $variables[] = $variable;
        }
        $variable = $variable_pattern;
        $variable['name'] = $value['value'];
        continue;
      }
      $variable['values'][$value['key']] = $value['value'];
    }
    if (!empty($variable['values'])) {
      $variables[] = $variable;
    }
    foreach($variables as $variable) {
      $this->header->addItem(new SystemVariable(str_replace('$', '', $variable['name']), $variable['values']));
    }
  }

  private function readTablesSection($values) {
    // TODO: The content of the table needs to be added
    $table = null;
    foreach ($values as $value) {
      if ($value['key'] == 0) {
        if ($value['value'] == 'TABLE') {
          $table = null;
          continue;
        } elseif ($value['value'] == 'ENDTAB') {
          $this->tables->addItem($table);
          continue;
        }
      }
      if ($value['key'] == 2 && !isset($table)) {
        $table = new Table($value['value']);
      }
    }
  }

  private function readEntitiesSection($values) {
    $entityType = '';
    $data = [];
    $types = ['TEXT', 'LINE', 'ELLIPSE'];
    // TODO most entity types are still missing
    foreach ($values as $value) {
      if ($value['key'] == 0) {
        if (in_array($entityType, $types) && !empty($data)) {
          $this->addReadEntity($entityType, $data);
        }
        $entityType = $value['value'];
        $data = [];
      } else {
        if (in_array($entityType, $types)) {
          $data[$value['key']] = $value['value'];
        }
      }
    }
    if (in_array($entityType, $types) && !empty($data)) {
      $this->addReadEntity($entityType, $data);
    }
  }

  private function addReadEntity($type, $data) {
    switch ($type) {
      case 'TEXT':
        $point = [$data[10], $data[20], $data[30]];
        $rotation = $data[50] ? $data[50] : 0;
        $thickness = $data[39] ? $data[39] : 0;
        $text = new Text($data[1], $point, $data[40], $rotation, $thickness);
        if ($data[72]) {
          $text->setHorizontalJustification($data[72]);
        }
        if ($data[73]) {
          $text->setVerticalJustification($data[73]);
        }
        $this->addEntity($text);
        break;
      case 'LINE':
        $start = [$data[10], $data[20], $data[30]];
        $end = [$data[11], $data[21], $data[31]];
        $thickness = $data[39] ? $data[39] : 0;
        $extrusion = [
          $data[210] ? $data[210] : 0,
          $data[220] ? $data[220] : 0,
          $data[230] ? $data[230] : 1
        ];
        $line = new Line($start, $end, $thickness, $extrusion);
        $this->addEntity($line);
        break;
      case 'ELLIPSE':
        $center = [$data[10], $data[20], $data[30]];
        $endpoint = [$data[11], $data[21], $data[31]];
        $start = $data[41] ? $data[41] : 0;
        $end = $data[42] ? $data[42] : M_PI * 2;
        $extrusion = [
          $data[210] ? $data[210] : 0,
          $data[220] ? $data[220] : 0,
          $data[230] ? $data[230] : 1
        ];
        $ellipse = new Ellipse($center, $endpoint, $data[40], $start, $end, $extrusion);
        $this->addEntity($ellipse);
        break;
    }
  }
}
