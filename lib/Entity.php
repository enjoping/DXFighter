<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 30.12.16
 * Time: 16:18
 *
 * Dokumentation http://www.autodesk.com/techpubs/autocad/acad2000/dxf/block_dxf_05.htm
 */

namespace DXFighter\lib;

class Entity extends BasicObject{
	protected $entityType;
	protected $layer = 0;
	protected $flags;
	protected $pointer = 0;

	function __construct(){
		parent::__construct();
	}

	function render() {
		$output = array();
		array_push($output, 0, strtoupper($this->entityType));
		array_push($output, 5, $this->getHandle());
		array_push($output, 330, $this->idToHex($this->pointer));
		array_push($output, 100, 'AcDbEntity');
		array_push($output, 8, $this->layer);
		return $output ;
	}

	/**
	 * rotate
	 * Rotate one point around a center point
	 *
	 * @param $point
	 * @param $center
	 * @param $angle
	 */
  protected function rotatePoint(&$point, $center, $angle) {
    $x = $point[0];
    $y = $point[1];
    $point[0] = $center[0] + ($x - $center[0]) * cos($angle) - ($y - $center[1]) * sin($angle);
    $point[1] = $center[1] + ($y - $center[1]) * cos($angle) + ($x - $center[0]) * sin($angle);
  }

	protected function flagsToString() {
		$output = 0;
		foreach($this->flags as $i => $flag) {
			$output += pow(2, $i) * $flag;
		}
		return $output;
	}

	public function setFlag($id, $value) {
		$this->flags[$id] = $value;
	}

	public function setLayer($layer) {
		$this->layer = $layer;
	}
}

