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
 */

/**
 * @desc Main class
 */
class Gracia {
    protected $img, $name, $x, $y, $bgcolor, $font_path;
    
    /**
     * @desc Construct the object
     * @param string $name => the name of the picture
     * @param int $x => picture width
     * @param int $y => picture height
     * @return the picture
     */
    public function __construct($name, $x, $y) {
        if(is_string($name) && is_int($x) && is_int($y)) {
            $this->x = $x;
            $this->y = $y;
            $this->img = imagecreate($this->x,$this->y);
            $this->name = $name;
            return header("Content-type: image/png");
        } else {
            exit('Error. The picture is not created.');
        }
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
     * @desc Set color GD from hexadecimal color
     * @param string $hexa => hexadecimal color
     * @return imagecolorallocate => GD color
     */
    private function getColorAllocate($hexa) {
        if($this->verifyHexa($hexa)) {
            $rgb = self::hexRgb($hexa);
            $color = imagecolorallocate($this->img, $rgb[0], $rgb[1], $rgb[2]);
            return $color;
        }
    }
    
    /**
     * @desc Verify if the hexa color is valid
     * @param string $hexa => hexadecimal color
     * @return bool
     */
    private function verifyHexa($hexa) {
        if(preg_match("/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/", $hexa)) {
            return true;
        } else return false;
    }
    
    /**
     * @desc Set a background to the current picture
     * @param string $hexa => hexadecimal color
     */
    final public function setBackground($hexa) {
        $this->bgcolor = $this->getColorAllocate($hexa);
    }
    
    /**
     * @desc Set a text to the current picture
     * @param int $size => text size
     * @param int $x => x position
     * @param int $y => y position
     * @param string $text => the label of the text
     * @param string $hexa => hexadecimal color
     */
    public function setText($size, $x, $y, $text, $hexa) {
        $size = (int) $size;
        $x = (int) $x;
        $y = (int) $y;
        $text = (string) $text;

        imagestring($this->img, $size, $x, $y, $text, $this->getColorAllocate($hexa));
    } 
    
    /**
     * @desc Draw a pixel in the x,y pos in the picture
     * @param int $x => x position
     * @param int $y => y position
     * @param string $hexa => hexadecimal color
     */
    public function setPixel($x, $y, $hexa) {
        $x = (int) $x;
        $y = (int) $y;
        $verifyHexa = $this->verifyHexa($hexa);
        
        if($verifyHexa) {
            $color = $this->getColorAllocate($hexa);
            imagesetpixel($this->img, $x, $y, $color);
        } else {
            header("Content-type: text/html");
            return exit("Your hexadecimal color is incorrect.");
        }
        
    }
    
    /**
     * @desc Draw a ligne in the current picture
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param string $hexa => hexadecimal color
     */
    public function setLine($x1, $y1, $x2, $y2, $hexa) {
        $x1 = (int) $x1;
        $x2 = (int) $x2;
        $y1 =(int) $y1;
        $y2 = (int) $y2;
        
        if($this->verifyHexa($hexa)) {
            $color = $this->getColorAllocate($hexa);
            imageline($this->img, $x1, $y1, $x2, $y2, $color);
        } else {
            header("Content-type: text/html");
            return exit("Your hexadecimal color is incorrect.");            
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
        else {
            header("Content-type: text/html");
            return exit('Erreur. The file can not be opened.');
        }
    }
    
    /**
     * @desc set a text using a specific font
     * @desc To use this method, the user must set a font with setFont();
     * @param string $size => text size
     * @param int $x => x pos
     * @param int $y => y pos
     * @param string $text => the label of the text
     * @param string $hexa => hexadecimal color
     */
    public function setTtfText($size, $x, $y, $text, $hexa) {  
        if(!empty($this->font_path)) {
            $size = (int) $size;
            $x = (int) $x;
            $y = (int) $y;
            $text = (string) $text;

            imagettftext($this->img, $size, 0, $x, $y, $this->getColorAllocate($hexa), $this->font_path, $text);
        } else  {
            header("Content-type: text/html");
            exit('Specify your font with <strong>setFont</strong> to use this method.');
        }
    }
    
    /**
     * @desc Set a border to the picture
     * @param string $hexa
     * @param int $border_pxl => the density of the border
     */
    public function setBorder($hexa, $border_pxl = 1) {
        if($this->verifyHexa($hexa)) {
            $color = $this->getColorAllocate($hexa);
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
                    header("Content-type: text/html");
                    exit('The target picture must be a picture.');
            }
            $w_source = imagesx($src);
            $h_source = imagesy($src);
            imagecopymerge($this->img, $src, $x, $y, 0, 0, $w_source, $h_source, $op);
        } else {
            header("Content-type: text/html");
            exit('Error. Can not open the target picture.');
        }
    }
    
    /**
     * @desc Resize the current picture
     * @param int $w => new width
     * @param int $h => new height
     * @param string $new_name => new name (optional)
     */
    public function resize($w, $h, $new_name = null) {
        $min = imagecreatetruecolor($w, $h);
        imagecopyresampled($min, $this->img, 0, 0, 0, 0, $w, $h, $this->x, $this->y);
        if(isset($new_name)) {
            $new_name = (string) $new_name;
            imagepng($min, $new_name.'.png');
        } else {
            imagepng($min);
        }
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
