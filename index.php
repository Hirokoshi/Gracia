<?php
//CLASS LOADER
function loadClass($classname) {
    require_once('classes/'.$classname.'.class.php');
}
spl_autoload_register('loadClass');

//EXAMPLE
$obj = new Gracia("myPicture", 350, 150);
$obj->setBackground("#8c6430");
$obj->setLine(10, 10, 60, 60, "#fff");
$obj->rotate(180);
$obj->setBorder("#000000", 3);
$obj->show_img();
?>

