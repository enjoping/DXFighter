<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 20:01
 */

require_once('DXFighter.php');

$dxf = new \DXFighter\DXFighter();

//TODO add some example calls
$dxf->toString();

$dxf->saveAs('dxfighter.dxf');