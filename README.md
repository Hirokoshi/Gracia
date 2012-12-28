<h1>Gracia</h1>
Gracia is a quick library to create and manage pictures with php. <br />
This library can be used only to create or manage <strong>empty</strong> pictures. GraciaJPG and GraciaPNG are coming soon :-).

<h2>Doc</h2>
<h3>Constructor</h3>
<code>__construct(string $name, int $x, int $y)</code><br /><br />
The constructor creates an empty picture with a <em>name</em>, <em>x</em> width and <em>y</em> height.

<h5>Example</h5>
<code>$obj = new Gracia("myPicture", 350, 150);</code>

<h3>setBackground(string $hexa)</h3>
<code>setBackground(string $hexa)</code><br /><br />
This method set a background to the picture. The color of the background is defined in <em>hexa</em> parameter. This parameter is a hexadimal color code.
<br />

<h5>Example</h5>
<code>
$obj->setBackground("#000"); //set a black background to the picture
</code>

<h3>setText(int $size, int $x, int $y, string $text, string $hexa)</h3>
<code>setText(int $size, int $x, int $y, string $text, string $hexa)</code><br /><br />
This method set a text to the picture with <em>size, x position, y position, the label of the text and the hexadecimal code color</em>.
<br />

<h5>Example</h5>
<code>
$obj->setTtfText(14, 120, 30, "Hello world!", "#abcdef"); //write "Hello world" in the picture
</code>
