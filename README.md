<h1>Gracia</h1>
Gracia is a quick library to create and manage pictures with php 
This library can be used only to create or manage <strong>empty</strong> pictures. GraciaJPG and GraciaPNG are coming soon :-).

<h2>Example</h2>
<strong>1 - Creating an empty picture</strong>
<?php
    $obj = new Gracia("myPicture", 350, 150); //Creating a new picture 350x150
    $obj->setFont('AlteHaasGroteskRegular.ttf');
    $obj->setBackground("#8c6430");
    $obj->setTtfText(14, 120, 30, "Hello world!", "#abcdef"); //Set a text using the TTF file
    $obj->setLine(120, 40, 220, 40, "#abcdef"); //Draw a line into the picture
    $obj->setBorder("#abcdef", 3); //Draw a 3px density border
    $obj->show_img(); //Finally, show the picture
?>