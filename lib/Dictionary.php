<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/endblk_dxf_05.htm
 */

namespace DXFighter\lib;

const ENTRYOWNERLABEL = 'owner';

/**
 * Class BlockRecord
 * @package DXFighter\lib
 */
class Dictionary extends Entity {
  protected $entries = array();

  /**
   * Dictionary constructor.
   * @param array $entries
   */
  function __construct($entries = array()) {
    if (!empty($entries)) {
      foreach ($entries as $entry) {
        array_push($this->entries, array(
          'name' => $entry,
          ENTRYOWNERLABEL => new Dictionary()
        ));
      }
    }
    parent::__construct();
  }

  public function getName() {
    return $this->entries[0]['name'];
  }

  /**
   * Public function to render an entity, returns a string representation of
   * the entity.
   * @return string
   */
  public function render() {
    $output = array();
    $entryOutput = '';
    array_push($output, 0, 'DICTIONARY');
    array_push($output, 5, $this->getHandle());
    array_push($output, 330, 0);
    array_push($output, 100, 'AcDbDictionary');
    foreach ($this->entries as $entry) {
      array_push($output, 3, $entry['name']);
      array_push($output, 350, $entry[ENTRYOWNERLABEL]->getHandle());
      $entryOutput .= $entry[ENTRYOWNERLABEL]->render();
    }
    array_push($output, 1001, 'ACAD');
    array_push($output, 1000, 'TREAT_AS_HARD');
    array_push($output, 1070, 0);
    if (!empty($entryOutput)) {
      array_push($output, $entryOutput);
    }
    return implode(PHP_EOL, $output);
  }
}
