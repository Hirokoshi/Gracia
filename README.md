Gracia
----------
Gracia is a quick library to create and manage images with php.

This library can be used only to create or manage **empty** images. GraciaJPG and GraciaPNG are coming soon :-).

**Last stable version : 0.2.5**

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
`__construct(string $name, int $x, int, string $bgcolor = null)`

The constructor creates an empty picture with a *name*, *x* width and *y* height. The *bgcolor* parameter is optionnal.

######Example
`$obj = new Gracia("myPicture", 350, 150, "#7F7F7F");`

###colorize
`colorize(string $colorName, int alpha)`

Applies the "colorize" filter to the image.

###createThumbnail
`createThumbnail(string $thumb_name);`

This method creates a thumbnail from the current image and saves it in *thumb_name*. The thumbnail's proportions are calculated automatically.

######Example
`$obj->createThumbnail('img/thumb_picture'); //creates a thumbnail "thumb_picture.png" in the img folder`

###drawRightTriangle
`drawRightTriangle(int $adjacent_side, int $opposite_side, int $x, int $y, string $colorName, int $density = 1)`

Draws a right triangle.

######Example
`$obj->drawRightTriangle(125, 125, 150, 140, 'black', 3); //draws a black right triangle`


###drawPolygon
`drawPolygon(array $vals, string $colorName, int $density = 2)`

Draws a polygon. The parameter *vals* is an array which determines the coordinates of the polygon.

######Example

    $coords = array(
        array(20, 100), array(100, 100), array(20, 30), array(100, 30)
    );

    $obj->drawPolygon($coords, 'black', 2);



###fusion
`fusion(string $file_path, int $x, int $y, int $op)`

This method merges the current picture with another image. *file_path* is the path of the target image, *(x,y)* is the merge position and *op* is the opacity of the target image.

######Example
`$obj->fusion('img/anotherpicture.jpg', 30, 50, 50); //merge the current img with anotherpicture.png with 50% opacity`

###negate
`negate()`

Reverse the colors of the image.

###pixelise
`pixelise()`

Pixelise the image.

###resize
`resize(int $w, $int $h)`

This method resizes the current image. *w* is the new width and *h* is the new height.

######Example
`$obj->resize(300, 100);`

###rotate
`rotate(double $angle)`

Rotate the picture using *angle* parameter in degrees.

######Example
`$obj->rotate(180);`

###save
`save(string $path_name)`

Saves the image into *path_name*.

######Example
`$obj->save('img/mypicture'); //saves the image into img/mypicture.png`

###setBackground
`setBackground(string $colorName)`

This method sets a background to the picture. The hexadecimal color code / color name of the background is defined in *colorName* parameter.

######Example
`
$obj->setBackground("yellow"); //sets a black background to the picture
`
###setBorder
`setBorder(string $colorName, int $border_pxl = 1)`

Sets a border to the image. *colorName* parameter is the hexadecimal color / color name of the border and *border_pxl* is the density of the border.

######Example
`$obj->setBorder('#000', 5); //black border with 5px density`

###setContrast
`setContrast(int $constrast = 1)`

Modify the contrast of the image. The value of the contrast must be between 1 and 100.

######Example
`$obj->setContrast(56);`

###setFont
`setFont(string $path)`

Sets a special font to the text.

######Example
`$obj->setFont('fonts/myfont.ttf');`

###setLine
`setLine(int $x1, int $y1, int $x2, int $y2, string $colorName, int $density_pxl = 1)`

Draws a line in the picture between *(x1, y1)* and *(x2, y2)* with *density_pxl* density. *colorName* is the hexadecimal color code or color name.

######Example
`$obj->setLine(120, 40, 220, 40, "purple");`

###setName
`setName(string $new_name)`

Sets a new name to the picture.

###setPixel
`setPixel(int $x, int $y, string $colorName)`

Draws a pixel in *(x,y)* pos in the picture. The hexadecimal color / color name of the pixel is defined in *colorName* parameter.

######Example
`
$obj->setPixel(50, 50, 'black");
`

###setText
`setText(int $size, int $x, int $y, string $text, string $colorName)`

This method sets a text to the picture with *size, x position, y position, the label of the text and the hexadecimal code or color name*.

######Example
`
$obj->setText(14, 120, 30, "Hello world!", "darkgreen"); //write "Hello world" in the picture
`

#####setTransparent
`setTransparent()`

Sets the picture transparent.

###setTtfText
`setTtfText(int $size, int $x, int $y, string $text, string $colorName)`

This method sets a *specific* text to the picture with *size, x position, y position, the label of the text and the color name.

**Note : to use this method, you must set a specific font with setFont**.

###show_img

Shows the image.

###smooth
`smooth(double $smooth_level)`

Makes the image smoother.

######Example
`$obj->smooth(56)`

Colors legend
----------
There are some colors predefined in Gracia. Here's the list with RGB format :

*black*         => 0-0-0

*white*         => 255-255-255

*blue*          => 0-0-255

*yellow*        => 255-255-0

*gray*          => 190-190-190

*brown*         => 165-42-42

*red*           => 255-0-0

*purple*        => 160-32-240

*snow*          => 255-250-255

*antiquewhite*  => 250-235-215

*lightgray*     => 211-211-211

*midnightblue*  => 25-25-112

*royalblue*     => 65-105-225

*steelblue*     => 70-130-180

*lightblue*     => 173-216-230

*turquoise*     => 64-224-208

*cyan*          => 0-255-255

*cadetblue*     => 95-158-160

*darkgreen*     => 0-100-0

*darkolivegreen*=> 85-107-47

*greenyellow*   => 173-255-47

*khaki*         => 240-230-140

*gold*          => 255-215-0

*beige*         => 245-245-220

*orange*        => 255-165-0

*salmon*        => 250-128-114

*darkorange*    => 255-140-0

*orangered*     => 255-69-0

*pink*          => 255-192-203

*violet*        => 238-130-238

*darkviolet*    => 148-0-211