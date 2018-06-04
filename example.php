<?php
/**
 * Created by PhpStorm.
 * User: jpietler
 * Date: 04.02.16
 * Time: 20:01
 */

require_once('DXFighter.php');

$dxf = new \DXFighter\DXFighter();

$shield = new \DXFighter\lib\Polyline();
$shield->setFlag(0,1);
$shield->setColor(98);
$shield->addPoint(array(-100,0,0));
$shield->addPoint(array(-55,-86.6,0));
$shield->addPoint(array(50,-86.6,0));
$shield->addPoint(array(100,0,0));
$shield->addPoint(array(50,86.6,0));
$shield->addPoint(array(-50,86.6,0));
$dxf->addEntity($shield);

$dxf->addEntity(new \DXFighter\lib\Text("D", array(-10,90,0), 50));
$dxf->addEntity(new \DXFighter\lib\Text("F", array(-10,-140,0), 50));
$dxf->addEntity(new \DXFighter\lib\Text("ighter", array(15,-140,0), 30));

for($i=0; $i < 2; $i++) {
  $rotate = $i==0 ? -30 : 30;

  $sword = new \DXFighter\lib\Polyline();
  $sword->setFlag(0,1);
  $sword->addPoint(array(0,70,0));
  $sword->addPoint(array(8,55,0));
  $sword->addPoint(array(8,-20,0));
  $sword->addPoint(array(1,-15,0));
  $sword->addPoint(array(1,58,0), 0.8);
  $sword->addPoint(array(-1,58,0));
  $sword->addPoint(array(-1,-15,0));
  $sword->addPoint(array(-8,-20,0));
  $sword->addPoint(array(-8,55,0));
  $sword->rotate($rotate);
  $dxf->addEntity($sword);

  $handle = new \DXFighter\lib\Polyline();
  $handle->setFlag(0,1);
  $handle->addPoint(array(0,-17,0));
  $handle->addPoint(array(14,-27,0));
  $handle->addPoint(array(0,-37,0));
  $handle->addPoint(array(-14,-27,0));
  $handle->rotate($rotate);
  $dxf->addEntity($handle);

  $line1 = new \DXFighter\lib\Line(array(10,-27,0),array(-10,-27,0));
  $line1->setColor(240);
  $line1->rotate($rotate);
  $dxf->addEntity($line1);

  $line2 = new \DXFighter\lib\Line(array(0,-21,0),array(0,-33,0));
  $line2->setColor(244);
  $line2->rotate($rotate);
  $dxf->addEntity($line2);

  $ellipse = new \DXFighter\lib\Ellipse(array(0,-50,0),array(0,12,0),0.5);
  $ellipse->rotate($rotate);
  $dxf->addEntity($ellipse);
}

#$dxf->toString();

$dxf->saveAs('dxfighter.dxf');


$reader = new \DXFighter\DXFighter('dxfighter.dxf');
$reader->addEntity(new \DXFighter\lib\Text("You can add any further objects as needed now", array(50,90,0), 20));
$reader->move(array(200, 50, 0));
$reader->rotate(45);
$reader->saveAs('dxfighter2.dxf');

$reader2 = new \DXFighter\DXFighter('dxfighter.dxf');
$reader2->addEntitiesFromFile('dxfighter2.dxf', array(100, 100, 0), 90);
foreach($reader2->getEntities() as $entity) {
  $entity->setLayer('MyLayer');
}
$reader2->saveAs('dxfighter3.dxf');
