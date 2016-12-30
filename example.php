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

$dxf->addEntity(new \DXFighter\lib\Line(array(0, 0, 0), array(10, 10, 0)));

$dxf->toString();
$dxf->addEntity(new \DXFighter\lib\Point(array(5, 0, 0), 2));

$dxf->addEntity(new \DXFighter\lib\Circle(array(5, 0, 0), 3));

$dxf->addEntity(new \DXFighter\lib\Ellipse(array(0, 10, 0), array(2, 5, 0), 0.5));

$dxf->addEntity(new \DXFighter\lib\Arc(array(20, 0, 0), 4, 0, 100));

$dxf->saveAs('dxfighter.dxf');