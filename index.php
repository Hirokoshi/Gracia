<?php
//CLASS LOADER
function loadClass($classname) {
    require_once('classes/'.$classname.'.class.php');
}
spl_autoload_register('loadClass');

//EXAMPLE
$obj = new Gracia("myPicture", 350, 150);
$obj->setFont('AlteHaasGroteskRegular.ttf');
$obj->setBackground("#8c6430");
$obj->setTtfText(14, 120, 30, "Hello world!", "#abcdef");
$obj->setLine(120, 40, 220, 40, "#abcdef");
$obj->setBorder("#abcdef", 3);
$obj->show_img();
?>

