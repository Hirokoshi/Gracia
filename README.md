Gracia
----------
Gracia is a quick library to create and manage pictures with php. 

This library can be used only to create or manage **empty** pictures. GraciaJPG and GraciaPNG are coming soon :-).

License
----------
Author : Elyas Kamel (Hirokoshi)

Contact : hirokoshi@gw2.fr - melyasfa@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
 This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

Doc
----------
###Constructor
`__construct(string $name, int $x, int $y)`

The constructor creates an empty picture with a *name*, *x* width and *y* height.

######Example
`$obj = new Gracia("myPicture", 350, 150);`

###setBackground
`setBackground(string $hexa)`

This method sets a background to the picture. The hexadecimal color of the background is defined in *hexa* parameter.


######Example
`
$obj->setBackground("#000"); //sets a black background to the picture
`

###setText
`setText(int $size, int $x, int $y, string $text, string $hexa)`

This method sets a text to the picture with *size, x position, y position, the label of the text and the hexadecimal code color*.

######Example
`
$obj->setText(14, 120, 30, "Hello world!", "#abcdef"); //write "Hello world" in the picture
`

###setPixel
`setPixel(int $x, int $y, string $hexa)`

Draws a pixel in *(x,y)* pos in the picture. The hexadecimal color of the pixel is defined in *hexa* parameter.

######Example
`
$obj->setPixel(50, 50, '#000");
`

###setLine
`setLine(int $x1, int $y1, int $x2, int $y2, string $hexa)`

Draws a line in the picture between *(x1, y1)* and *(x2, y2)*. *hexa* is the hexadecimal color code.

######Example
`$obj->setLine(120, 40, 220, 40, "#abcdef");`

###rotate
`rotate(double $angle)`

Rotate the picture using *angle* parameter in degrees.

######Example
`$obj->rotate(180);`

#####setTransparent
`setTransparent()`

Sets the picture transparent.

###setFont
`setFont(string $path)`

Sets a special font to the text. 

######Example
`$obj->setFont('fonts/myfont.ttf');`

###setTtfText
`setTtfText(int $size, int $x, int $y, string $text, string $hexa)`

This method sets a *specific* text to the picture with *size, x position, y position, the label of the text and the hexadecimal code color*.

**Note : to use this method, you must set a specific font with setFont**.

###setBorder
`setBorder(string $hexa, int $border_pxl = 1)`

Sets a border to the image. *hexa* parameter is the hexadecimal color of the border and *border_pxl* is the density of the border.

######Example
`$obj->setBorder('#000', 5); //black border with 5px density`

###fusion
`fusion(string $file_path, int $x, int $y, int $op)`

This method merges the current picture with another image. *file_path* is the path of the target image, *(x,y)* is the merge position and *op* is the opacity of the target image.

######Example
`$obj->fusion('img/anotherpicture.jpg', 30, 50, 50); //merge the current img with anotherpicture.png with 50% opacity`

###setName
`setName(string $new_name)`

Sets a new name to the picture.

###resize
`resize(int $w, $int $h)`

This method resizes the current image. *w* is the new width and *h* is the new height.

######Example 
`$obj->resize(300, 100);`

###createThumbnail()
`createThumbnail(string $thumb_name);`

This method creates a thumbnail from the current image and saves it in *thumb_name*. The thumbnail's proportions are calculated automatically. 

######Example
`$obj->createThumbnail('img/thumb_picture'); //creates a thumbnail "thumb_picture.png" in the img folder`

###show()

Shows the image.

###save
`save(string $path_name)`

Saves the image into *path_name*.

######Example
`$obj->save('img/mypicture'); //saves the image into img/mypicture.png`

###show()

Shows the image.

