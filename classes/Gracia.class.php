<?php
/**
 *           _           _             _     _ 
 *     /\  /(_)_ __ ___ | | _____  ___| |__ (_)
 *    / /_/ / | '__/ _ \| |/ / _ \/ __| '_ \| |
 *   / __  /| | | | (_) |   < (_) \__ \ | | | |
 *   \/ /_/ |_|_|  \___/|_|\_\___/|___/_| |_|_|
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 *  Gracia is a quick library to create and manage pictures with php
 *  Author: Elyas Kamel
 *  Contact: hirokoshi@gw2.fr OR melyasfa@gmail.com
 *  @version 0.2.3
 */

/**
 * @desc Global variables
 */

//Defined colors
$GColors = array(
    'black' => array(0, 0, 0),
    'white' => array(255, 255, 255),
    'blue' => array(0, 0, 255),
    'yellow' => array(255, 255, 0),
    'gray' => array(190, 190, 190),
    'brown' => array(165, 42, 42),
    'red' => array(255, 0, 0),
    'purple' => array(160, 32, 240),
    'snow' => array(255, 250, 250),
    'antiquewhite' => array(250, 235, 215),
    'lightgray' => array(211, 211, 211),
    'midnightblue' => array(25, 25, 112),
    'royalblue' => array(65, 105, 225),
    'steelblue' => array(70, 130, 180),
    'lightblue' => array(173, 216, 230),
    'turquoise' => array(64, 224, 208),
    'cyan' => array(0, 255, 255),
    'cadetblue' => array(95, 158, 160),
    'darkgreen' => array(0, 100, 0),
    'darkolivegreen' => array(85, 107, 47),
    'greenyellow' => array(173, 255, 47),
    'khaki' => array(240, 230, 140),
    'gold' => array(255, 215, 0),
    'beige' => array(245, 245, 220),
    'orange' => array(255, 165, 0),
    'salmon' => array(250, 128, 114),
    'darkorange' => array(255, 140, 0),
    'orangered' => array(255, 69, 0),
    'pink' => array(255, 192, 203),
    'violet' => array(238, 130, 238),
    'darkviolet' => array(148, 0, 211)
);


/**
 * @desc Exception class
 */
class GraciaException extends Exception {
    
    /**
     * @desc Construct the exception
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
        header('Content-type: text/html');
    }
}

/**
 * @desc Color class
 */
class GraciaColor {
    
    protected $name,
              $r,
              $g,
              $b;
    
    /**
     * @desc construct the color
     * @global array $GColors
     * @param string $name
     * @throws GraciaException
     */
    public function __construct($name) {
        global $GColors;
        
        if(is_string($name)) {
            //Verify if the "$name" is a hexadecimal color code
            if(self::verifyHexa($name)) {
                $rgb = self::hexRgb($name);
                
                if(in_array($rgb, $GColors)) {
                    foreach($GColors as $key => $value) {
                        if($rgb == $value) {
                            $this->name = $key;
                        }
                    }    
                } else $this->name = $name;
                
                $this->r = $rgb[0];
                $this->g = $rgb[1];
                $this->b = $rgb[2];          
            } else if(preg_match("#^[a-zA-Z]#", $name)) {
                if(self::checkColor($name)) {
                    $this->name = $name;
                    $this->r = $GColors[$name][0];
                    $this->g = $GColors[$name][1];
                    $this->b = $GColors[$name][2];
                } else {
                    throw new GraciaException("This color doesn't exists.");
                }                
            } else {
                throw new GraciaException("Please specify a correct color value.");
            }
        } else {
            throw new GraciaException("Please specify a correct color value.");
        }
    }
    
    /**
     * @desc check if the color exists
     * @global array $GColors
     * @param str $name
     * @return boolean
     */
    static private function checkColor($name) {
        global $GColors;
        
        $name = (string) $name;
        $ok = false;
        
        foreach($GColors as $key => $v) {
            if($name == $key) {
                $ok = true;
            }
        }
        
        return $ok;
    }
    
     /**
     * @desc Convert a hexadecimal color to RGB
     * @param string $hex => hexadecimal color
     * @return array => RGB
     */
    static private function hexRgb($hex) {
        if($hex[0] == '#') $hex = substr($hex, 1);

        if(strlen($hex) == 6) list($r, $v, $b) = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
        else if(strlen($hex) == 3) list($r, $v, $b) = array($hex[0].$hex[0], $hex[1].$hex[1], $hex[2].$hex[2]); 
        else return false;

        $r = hexdec($r);
        $v = hexdec($v);
        $b = hexdec($b);

        return array($r, $v, $b);            
    }
    
    /**
     * @desc Verify if the hexa color is valid
     * @param string $hexa => hexadecimal color
     * @return bool
     */
    static private function verifyHexa($hexa) {
        if(preg_match("/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/", $hexa)) {
            return true;
        } else return false;
    }
    
    //GETTERS
    public function getColorName() {
        return $this->name;
    }
    
    public function getRgb() {
        return array($this->r, $this->g, $this->b);
    }
}

/**
 * @desc Main class
 */
class Gracia {
    protected $img, $name, $x, $y, $bgcolor, $font_path;

    public function __construct($name, $x, $y, $bgcolor = null) {
        if(is_string($name) && is_int($x) && is_int($y)) {
            $this->x = $x;
            $this->y = $y;
            $this->img = imagecreate($this->x,$this->y);
            $this->name = $name;

            if($bgcolor !== null)
                $this->bgcolor = $this->getColorAllocate(new GraciaColor($bgcolor));

            header("Content-type: image/png");
        } else {
            throw new GraciaException('Please specify correct values.');
        }
    }
    

    /**
     * @desc Set color GD from hexadecimal color
     * @param GraciaColor $colorObj
     * @return imagecolorallocate => GD color
     */
    private function getColorAllocate(GraciaColor $colorObj) {
        $rgb = $colorObj->getRgb();
            
        $color = imagecolorallocate($this->img, $rgb[0], $rgb[1], $rgb[2]);
        return $color;
    }
    

    
    /**
     * @desc Set a background to the current picture
     * @param string $colorName => hexadecimal color / color name
     */
    final public function setBackground($colorName) {
        $this->bgcolor = $this->getColorAllocate(new GraciaColor($colorName));
    }
    
    /**
     * @desc Set a text to the current picture
     * @param int $size => text size
     * @param int $x => x position
     * @param int $y => y position
     * @param string $text => the label of the text
     * @param string $colorName => hexadecimal color / color name
     */
    public function setText($size, $x, $y, $text, $colorName) {
        $size = (int) $size;
        $x = (int) $x;
        $y = (int) $y;
        $text = (string) $text;
        $colorObj = new GraciaColor($colorName);

        imagestring($this->img, $size, $x, $y, $text, $this->getColorAllocate($colorObj));
    } 
    
    /**
     * @desc Draw a pixel in the x,y pos in the picture
     * @param int $x => x position
     * @param int $y => y position
     * @param string $colorName => hexadecimal color / color name
     */
    public function setPixel($x, $y, $colorName) {
        $x = (int) $x;
        $y = (int) $y;
        $colorObj = new GraciaColor($colorName);
        
        $color = $this->getColorAllocate($colorObj);
        imagesetpixel($this->img, $x, $y, $color);  
    }

    /**
     * @desc Draw a line in the current picture
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param string $colorName
     * @param int $density_pxl
     */
    public function setLine($x1, $y1, $x2, $y2, $colorName, $density_pxl = 1) {
        $x1 = (int) $x1;
        $x2 = (int) $x2;
        $y1 = (int) $y1;
        $y2 = (int) $y2;

        $colorObj = new GraciaColor($colorName);
        $color = $this->getColorAllocate($colorObj);

        for($i = 0; $i < $density_pxl; $i++) {
            imageline($this->img, $x1, $y1 + $i, $x2, $y2 + $i, $color);
        }
    }

    /**
     * @param $adjacent_side
     * @param $opposite_side
     * @param $x
     * @param $y
     * @param $colorName
     * @param int $density
     */
    public function drawRightTriangle($adjacent_side, $opposite_side, $x, $y, $colorName, $density = 1) {
        $x = (int) $x;
        $y = (int) $y;

        $adjacent_side = intval($adjacent_side);
        $opposite_side = intval($opposite_side);

        $color = $this->getColorAllocate(new GraciaColor($colorName));

        for($i = 0; $i < $density; $i++) {
            imageline($this->img, $x, $y + $i, $x + $adjacent_side + $i, $y + $i, $color);
            imageline($this->img, ($x + $adjacent_side) + $i, ($y - $opposite_side), ($x + $adjacent_side) + $i, $y + $i, $color);
            imageline($this->img, $x, $y + $i, $x + $adjacent_side, ($y - $opposite_side) + $i, $color);
        }
    }

    /**
     * @desc Draws a polygon
     * @param array $vals
     * @param int $density
     * @param string $colorName
     */
    public function drawPolygon($vals, $colorName, $density = 2) {
        $density = (int) $density;

        $count = count($vals);
        if($count > 2) {
            for($i = 0; $i < $count - 1; $i++) {
                $x1 = $vals[$i][0];
                $y1 = $vals[$i][1];
                $x2 = $vals[$i + 1][0];
                $y2 = $vals[$i + 1][1];

                $this->setLine($x1, $y1, $x2, $y2, $colorName, $density);
            }

            $x1 = $vals[$count - 1][0];
            $y1 = $vals[$count - 1][1];
            $x2 = $vals[0][0];
            $y2 = $vals[0][1];

            $this->setLine($x1, $y1, $x2, $y2, $colorName, $density);
        }
    }
    
    /**
     * @desc Rotate the picture
     * @param double $angle
     */
    public function rotate($angle) {
        $angle = (double) $angle;
        
        $this->img = imagerotate($this->img, $angle, 0);
    }

    /**
     * @desc Pixelise the image
     */
    public function pixelise() {
        imagefilter($this->img, IMG_FILTER_PIXELATE, IMG_FILTER_CONTRAST, IMG_FILTER_PIXELATE);
    }

    /**
     * @desc Reverse the colors of the image
     */
    public function negate() {
        imagefilter($this->img, IMG_FILTER_NEGATE);
    }

    /**
     * @desc Modify the contrast of the image
     * @param int $contrast
     * @throws GraciaException
     */
    public function setContrast($contrast = 1) {
        if($contrast >= 1 && $contrast <= 100)
            imagefilter($this->img, IMG_FILTER_CONTRAST, $contrast);
        else throw new GraciaException("The contrast must be a value between 1 and 100.");
    }

    /**
     * @desc Applies "colorize" filter to the image
     * @param string $colorName
     * @param int $alpha
     */
    public function colorize($colorName, $alpha) {
        $alpha = (int) $alpha;

        $color = new GraciaColor($colorName);
        $rgb = $color->getRgb();

        imagefilter($this->img, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2], $alpha);
    }

    /**
     * @desc Makes the image smoother
     * @param double $smooth_level
     */
    public function smooth($smooth_level) {
        $smooth_level = (double) $smooth_level;

        imagefilter($this->img, IMG_FILTER_SMOOTH, $smooth_level);
    }

    /**
     * @desc Set the picture transparent
     */
    public function setTransparent() {
        imagecolortransparent($this->img, $this->bgcolor);
    }
    
    /**
     * @desc set a font to the text
     * @param string $path => the path of the font file
     */
    public function setFont($path) {
        if(file_exists($path))
            $this->font_path = $path;
        else 
            throw new GraciaException("The font file can not be opened. Verify the path.");
    }
    
    /**
     * @desc set a text using a specific font
     * @desc To use this method, the user must set a font with setFont();
     * @param string $size => text size
     * @param int $x => x pos
     * @param int $y => y pos
     * @param string $text => the label of the text
     * @param string $colorName => hexadecimal color / color name
     */
    public function setTtfText($size, $x, $y, $text, $colorName) {  
        if(!empty($this->font_path)) {
            $size = (int) $size;
            $x = (int) $x;
            $y = (int) $y;
            $text = (string) $text;

            imagettftext($this->img, $size, 0, $x, $y, $this->getColorAllocate(new GraciaColor($colorName)), $this->font_path, $text);
        } else  {
            throw new GraciaException("Specify your font with setFont to use this method.");            
        }
    }
    
    /**
     * @desc Set a border to the picture
     * @param string $colorName => hexadecimal color / color name
     * @param int $border_pxl => the density of the border
     */
    public function setBorder($colorName, $border_pxl = 1) {
        $colorObj = new GraciaColor($colorName);
        $color = $this->getColorAllocate($colorObj);
        $border_pxl = (int) $border_pxl;
            
        $weight = $this->x - 1;
        $height = $this->y - 1;
        $x = 0;
        $y = 0;
            
        for($i = 0; $i < $border_pxl; $i++) {
            imageline($this->img, $x + $i, $y + $i, $x + $i, $y + $height + $i, $color);
            imageline($this->img, $x + $i, $y + $i, $x + $weight + $i, $y + $i, $color);
            imageline($this->img, $x + $weight - $i, $y - $i, $x + $weight - $i, $y + $height - $i, $color);
            imageline($this->img, $x - $i, $y + $height - $i, $x + $weight - $i, $y + $height - $i, $color);                   
        }      
    }
    
    /**
     * @desc Show the picture
     */
    public function show_img() {
        imagepng($this->img);
    }
    
    /**
     * @desc Save the picture
     * @param string $path => the path where the picture will be saved
     * @example save('img/name');
     */
    public function save($path_name) {
        imagepng($this->img, $path_name.'.png');
    }
    
    /**
     * @desc Merge the picture with another picture
     * @param string $file_path => other picture target
     * @param int $x => the x pos of the fusion
     * @param int $y => the y pos
     * @param int $op => opacity
     */
    public function fusion($file_path, $x, $y, $op) {
        if(file_exists($file_path)) {
            $extension = explode('.', $file_path);
            switch($extension[1]) {
                case "png":
                case "PNG":
                    $src = imagecreatefrompng($file_path);
                    break;
                case "jpg":
                case "JPG":
                case "JPEG":
                    $src = imagecreatefromjpeg($file_path);
                    break;
                default;
                    throw new GraciaException("The target must be a picture.");            
            }
            $w_source = imagesx($src);
            $h_source = imagesy($src);
            imagecopymerge($this->img, $src, $x, $y, 0, 0, $w_source, $h_source, $op);
        } else {
            throw new GraciaException("Can not open the target picture. Please specify a valid file path.");            
        }
    }
    
    /**
     * @desc Resize the current picture
     * @param int $w => new width
     * @param int $h => new height
     */
    public function resize($w, $h) {
        $w = (int) $w;
        $h = (int) $h;
        
        $min = imagecreatetruecolor($w, $h);
        imagecopyresampled($min, $this->img, 0, 0, 0, 0, $w, $h, $this->x, $this->y);
        
        $this->img = $min;
    }
    
    /**
     * @desc Create a thumbnail from the image
     * @param string $thumb_name => thumbnail name
     */
    public function createThumbnail($thumb_name) {
        $reduction = ((300 * 100) / $this->x);
        $thumb_height = (($this->y * $reduction) / 100);
        $thumb_width = 300;
        
        $thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);
        imagecopyresampled($thumbnail, $this->img, 0, 0, 0, 0, $thumb_width, $thumb_height, $this->x, $this->y);
        
        imagepng($thumbnail, $thumb_name.'.png');
        
    }
    
    /**
     * @desc Change the name of the current picture
     * @param string $new_name => the new name of the picture
     */
    public function setName($new_name) {
        $new_name = (string) $new_name;
        
        $this->name = $new_name;
    }
    
    //GETTERS\\
    public function getName() {
        return $this->name;
    }   
}
?>