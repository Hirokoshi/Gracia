<?php
//CLASS LOADER
require_once 'classes/Gracia.class.php';

//EXAMPLE
$obj = new Gracia("myPicture", 350, 150);
$obj->setFont('AlteHaasGroteskRegular.ttf');
$obj->setBackground("royalblue");
$obj->setTtfText(14, 120, 40, "Hello world!", "snow");
$obj->setLine(120, 50, 220, 50, "antiquewhite", 3);
$obj->setBorder("gray", 3);
$obj->show_img();
?>

