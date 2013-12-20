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
 *  @version 0.3.2
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

    const PI = 3.14;

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
     * @desc Draws a line in the current picture
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $colorName
     * @param int $density_pxl
     * @param string $style
     */
    public function setLine($x1, $y1, $x2, $y2, $colorName, $density_pxl = 1, $style = 'solid') {
        $x1 = (int) $x1;
        $x2 = (int) $x2;
        $y1 = (int) $y1;
        $y2 = (int) $y2;

        $colorObj = new GraciaColor($colorName);
        $color = $this->getColorAllocate($colorObj);

        $distance = $this->lineDistance($x1, $y1, $x2, $y2);
        $this->getLineVars($i1, $i2, $nb, $i, $style, $density_pxl, $distance);

        switch($style) {
            case 'solid':
                for($i = 0; $i < $density_pxl; $i++) {
                    imageline($this->img, $x1, $y1 + $i, $x2, $y2 + $i, $color);
                }
                break;
            case 'dotted':
                if($i > 1) {
                    if($x1 != $x2) {
                        $m = ($y2 - $y1) / ($x2 - $x1);

                        for($j = 0; $j < $i; $j++) {
                            $x = $x1 + $j * ($x2 - $x1) / ($i - 1);
                            $y = $m * $x + $y1 - $m * $x1;

                            imagefilledellipse($this->img, $x, $y, $density_pxl, $density_pxl, $color);
                        }
                    } else {
                        for($j = 0; $j < $i; $j++) {
                            $y = $y1 + $j * - ($y2 - $y1) / ($i - 1);

                            imagefilledellipse($this->img, $x1, $y, $density_pxl, $density_pxl, $color);
                        }
                    }
                } else {
                    for($i = 0; $i < $density_pxl; $i++) {
                        imageline($this->img, $x1, $y1 + $i, $x2, $y2 + $i, $color);
                    }
                }
                break;
            case 'double':
                $m = $density_pxl / 3;

                if($y1 == $y2) {
                    for($i = 0; $i < ceil($m); $i++) {
                        imageline($this->img, $x1, ($y1 + $m) + $i, $x2, ($y2 + $m) + $i, $color);
                        imageline($this->img, $x1, ($y1 - $m) + $i, $x2, ($y2 - $m) + $i, $color);
                    }
                } else if($x1 == $x2) {
                    for($i = 0; $i < ceil($m); $i++) {
                        imageline($this->img, ($x1 + $m) + $i, $y1, ($x2 + $m) + $i, $y2, $color);
                        imageline($this->img, ($x1 - $m) + $i, $y1, ($x2 - $m) + $i, $y2, $color);
                    }
                } else {
                    $a = ($y2 - $y1) / ($x2 - $x1);
                    $fx = $m / sqrt(1 + pow($a, 2));
                    $fy = $m / sqrt(1 + 1/pow($a, 2));
                    $fy *= ($y2 - $y1) / abs($y2 - $y1);

                    for($i = 0; $i < ceil($m); $i++) {
                        imageline($this->img, round($x1 - $fy), round($y1 + $fx) + $i, round($x2 - $fy), round($y2 + $fx) + $i, $color);
                        imageline($this->img, round($x1 + $fy), round($y1 - $fx) + $i, round($x2 + $fy), round($y2 - $fx) + $i, $color);
                    }
                }
                break;
        }
    }

    /**
     * @desc Return the distance between two points
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @return float
     */
    private function lineDistance($x1, $y1, $x2, $y2) {
        return sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2));
    }

    /**
     * @param $value
     * @param $max
     */
    private function getCenterValue(& $value, $max) {
        $value = round(floatval($value) * $max / 100);
    }


    /**
     * @param $center_x
     * @param $center_y
     * @param $radius
     * @param $colorName
     * @param int $density
     * @param string $style
     */
    public function drawCircle($center_x, $center_y, $radius, $colorName, $density = 1, $style = 'solid') {
        $this->getCenterValue($center_x, $this->x);
        $this->getCenterValue($center_y, $this->y);
        $radius = (int) $radius;
        $density = (int) $density;
        $style = (string) $style;

        $this->drawEllipse($center_x, $center_y, $radius * 2, $radius * 2, $colorName, $density, $style);
    }

    /**
     * @param $center_x
     * @param $center_y
     * @param $width
     * @param $height
     * @param $colorName
     * @param int $density
     * @param string $style
     */
    public function drawEllipse($center_x, $center_y, $width, $height, $colorName, $density = 1, $style = 'solid') {
        $this->getCenterValue($center_x, $this->x);
        $this->getCenterValue($center_y, $this->y);
        $width = (int) $width;
        $height = (int) $height;
        $style = (string) $style;

        $color = $this->getColorAllocate(new GraciaColor($colorName));

        $perim = $this->getCirclePerimeter($width, $height);
        $this->getLineVars($i1, $i2, $nb, $i, $style, $density, $perim);

        switch($style) {
            case 'solid':
                $this->setEllipse($center_x, $center_y, $width, $height, $color, $density);
                break;
            case 'dotted':
                if($i > 1) {
                    for($j = 0; $j < $i - 1; $j++) {
                        $angle = $this->degreesToRadian($j * 360 / ($i - 1));
                        $x = $center_x + 0.5 * $width * cos($angle);
                        $y = $center_y + 0.5 * $height * sin($angle);

                        imagefilledellipse($this->img, round($x), round($y), $density, $density, $color);
                    }
                } else {
                    $this->setEllipse($center_x, $center_y, $width, $height, $color, $density);
                }
                break;
            case 'double':
                $reduction = $density / 3;
                $this->setEllipse($center_y, $center_y, $width + 2 * $reduction, $height + 2 * $reduction, $color, $reduction);
                $this->setEllipse($center_y, $center_y, $width - 2 * $reduction, $height - 2 * $reduction, $color, $reduction);
                break;
            case 'dashed':
                if($i > 1) {
                    for($j = 0; $j < $i - 1; $j++) {
                        $a1 = $j * 360 * ($i - 1);
                        $a2 = $a1 + 360 * ($i1) / $nb;

                        $this->setEllipseArc($center_x, $center_y, $width, $height, $a1, $a2, $color, $density);
                    }
                } else {
                    $this->setEllipse($center_x, $center_y, $width, $height, $color, $density);
                }
                break;
        }
    }

    /**
     * @param $center_x
     * @param $center_y
     * @param $width
     * @param $height
     * @param $color
     * @param $density
     */
    private function setEllipse($center_x, $center_y, $width, $height, $color, $density) {
        $perim = floor($this->getCirclePerimeter($width, $height));
        $width = round($width);
        $height = round($height);

        if($perim >= 2) {
            if($density > 1) {
                $points = array();
                $a = 0;
                $angle = $this->degreesToRadian(360 / ($perim - 1));

                for($i = 0; $i < $perim; $i++) {
                    $points[] = round($center_x + 0.5 * ($width + $density) * cos($a));
                    $points[] = round($center_y + 0.5 * ($height + $density) * sin($a));
                    $a += $angle;
                }

                $a -= $angle;

                for($i = 0; $i < $perim; $i++) {
                    $points[] = round($center_x + 0.5 * ($width - $density) * cos($a));
                    $points[] = round($center_y + 0.5 * ($height - $density) * sin($a));
                    $a -= $angle;
                }

                imagefilledpolygon($this->img, $points, $perim * 2, $color);
            } else {
                imageellipse($this->img, $center_x, $center_y, $width, $height, $color);
            }
        } else {
            imageellipse($this->img, $center_x, $center_y, $width, $height, $color);
        }
    }

    /**
     * @param $center_x
     * @param $center_y
     * @param $width
     * @param $height
     * @param $start
     * @param $end
     * @param $color
     * @param $density
     */
    private function setEllipseArc($center_x, $center_y, $width, $height, $start, $end, $color, $density) {
        $this->setCircleAngle($start, $end);

        $n = floor(abs($end - $start) * $this->getCirclePerimeter($width, $height) / 360);
        $width = round($width);
        $height = round($height);

        if($n >= 2) {
            $points = array();

            if($density > 1) {
                $this->getEllipseVars($e1, $e2, $density);

                if($density % 2 == 0)
                    $e1--;
                else $e2--;

                $list = array();
                $points = $this->getEllipsePoints($width + 2 * $e1, $height + 2 *$e1, $start, $end);

                $n = count($points);

                for($i = 0; $i < $n; $i++)
                    $list[] = array($center_x + $points[$i][0], $center_y + $points[$i][1]);

                $points = array_reverse($this->getEllipsePoints($width - 2 * $e2, $height - 2 * $e2, $start, $end));
                $n = count($points);

                for($i = 0; $i < $n; $i++)
                    $list[] = array($center_x + $points[$i][0], $center_y + $points[$i][1]);

                $this->drawFilledPolygon($list, $color);
            } else {
                $points = $this->getEllipsePoints($width, $height, $start, $end);

                for($i = 0; $i < count($points); $i++)
                    imagesetpixel($this->img, $center_x + $points[$i][0], $center_y + $points[$i][1], $color);
            }
        } else {
            imageline(
                $this->img,
                $center_x + 0.5 * $width * cos($this->degreesToRadian($end)),
                $center_y + 0.5 * $height * sin($this->degreesToRadian($end)),
                $center_x + 0.5 * $width * cos($this->degreesToRadian($start)),
                $center_y + 0.5 * $height * sin($this->degreesToRadian($start)),
                $color
            );
        }
    }

    /**
     * @desc Return the perimeter of a circle
     * @param int $width
     * @param int $height
     * @return int
     */
    private function getCirclePerimeter($width, $height) {
        return 2 * self::PI * sqrt((pow($width, 2) / 8) + (pow($height, 2) / 8));
    }

    /**
     * @desc Set the angle to 360
     * @param int $first_angle
     * @param null int $second_angle
     */
    private function setCircleAngle(& $first_angle, & $second_angle = null) {
        if(is_null($second_angle)) {
            while($first_angle < 0)
                $first_angle += 360;

            while($first_angle >= 360)
                $first_angle -= 360;
        } else {
            while($first_angle < 0) {
                $first_angle += 360;
                $second_angle += 360;
            }

            while($first_angle >= 360) {
                $first_angle -= 360;
                $second_angle -= 360;
            }

            while($second_angle < 0) {
                $first_angle += 360;
                $second_angle += 360;
            }
        }

    }

    /**
     * @param int $e1
     * @param int $e2
     * @param int $density
     */
    private function getEllipseVars(& $e1, & $e2, $density) {
        $e1 = floor($density / 2);
        $e2 = $density - $e1;
    }

    /**
     * @desc Return the angle of a line
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @return float|int
     */
    private function getLineAngle($x1, $y1, $x2, $y2) {
        if($x1 < $x2) {
            // arc tangente
            return atan(($y2 - $y1) / ($x2 - $y1)) * 180 * self::PI;
        } else if($x1 == $x2) {
            if($y1 < $y2)
                return 90;
            else return -90;
        } else {
            if($y1 < $y2) {
                return 180 + atan(($y2 - $y1) / ($x2 - $x1)) * 180 * self::PI;
            } else {
                return -180 + atan(($y2 - $y1) / ($x2 - $x1)) * 180 * self::PI;
            }
        }
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $start
     * @param int $end
     * @return array
     */
    private function getEllipsePoints($width, $height, $start, $end) {
        $p1 = array();
        $p2 = array();
        $p3 = array();
        $p4 = array();

        $a = floor($width / 2);
        $b = floor($height / 2);

        if($width % 2 == 0)
            $a--;

        if($height % 2 == 0)
            $b--;

        $x = 0; $y = $b;
        $d1 = pow($b, 2) - pow($a, 2) * $b - pow($a, 2) / 4;

        $p1[] = array($x, $y);
        $p2[] = array(-$x, $y);
        $p3[] = array(-$x, -$y);
        $p4[] = array($x, -$y);

        while(pow($a, 2) * ($y - 0.5) > pow($b, 2) * ($x + 1)) {
            if($d1 < 0) {
                $d1 += pow($b, 2) * (2 * $x + 3);
                $x++;
            } else {
                $d1 += pow($b, 2) * (2 * $x + 3) + pow($a, 2) * (-2 * $y + 2);
                $x++;
                $y--;
            }

            $p1[] = array($x, $y);
            $p2[] = array(-$x, $y);
            $p3[] = array(-$x, -$y);
            $p4[] = array($x, -$y);
        }

        $d2 = pow($b, 2) * pow(($x + 0.5), 2) + pow($a, 2) * pow(($y - 1), 2) - pow($a, 2) * pow($b, 2);

        while($y > 0) {
            if($d2 < 0) {
                $d2 += pow($b, 2) * (2 * $x + 2) + pow($a, 2) * (-2 * $y + 3);
                $y--;
                $x++;
            } else {
                $d2 += pow($a, 2) * (-2 * $y + 3);
                $y--;
            }

            $p1[] = array($x, $y);
            $p2[] = array(-$x, $y);
            $p3[] = array(-$x, -$y);
            $p4[] = array($x, -$y);
        }

        $p = array_merge(array_reverse($p1), $p2, array_reverse($p3), $p4);
        $i = 0; $n = count($p);
        $r = array();

        do {
            $angle = $this->getLineAngle(0, 0, $p[$i][0], $p[$i][1]);

            if($angle < 0)
                $angle += 360;

            if($angle >= $start)
                break;
            $i++;
        } while($i < $n);

        if($i >= $n)
            $i = 0;

        $d = 0;

        do {
            $angle = $this->getLineAngle(0, 0, $p[$i][0], $p[$i][1]);

            if($angle < 0)
                $angle += 360;

            $angle += $d;

            if($angle <= $end)
                $r[] = $p[$i];
            else
                break;

            $i++;

            if($i >= $n) {
                $i = 0;
                $d += 360;
            }
        } while(true);

        $l = array();
        $n = count($r);

        if($n > 0) {
            $l[] = $r[0];

            for($i = 1; $i < $n; $i++) {
                if($r[$i][0] != $r[$i - 1][0] || $r[$i][1] != $r[$i - 1][1]) {
                    $l[] = $r[$i];
                }
            }
        }

        return $l;
    }

    /**
     * @param $points
     * @param $color
     */
    private function drawFilledPolygon($points, $color) {
        $scanline = 99999;

        $all_edges = array();
        $n = count($points);

        for($i = 0; $i < $n; $i++) {
            $p1 = $points[$i];

            if($i == $n - 1)
                $p2 = $points[0];
            else $p2 = $points[$i + 1];

            $x1 = $p1[0];
            $y1 = $p1[1];
            $x2 = $p2[0];
            $y2 = $p2[1];

            if($y1 != $y2) {
                $inverse = ($x2 - $x1) / ($y2 - $y1);

                if($y1 < $y2) {
                    $ymin = $y1;
                    $xval = $x1;
                    $ymax = $y2;
                } else {
                    $ymin = $y2;
                    $xval = $x2;
                    $ymax = $y1;
                }

                $all_edges[] = array($ymin, $ymax, $xval, $inverse);

                if($ymin < $scanline)
                    $scanline = $ymin;
            } else {
                if($y1 < $scanline)
                    $scanline = $y1;

                if($y2 < $scanline)
                    $scanline = $y2;
            }
        }

        $save_edges = $all_edges;

        $active = array();
        $pixels = array();

        while(count($all_edges) + count($active) > 0) {
            $_tmp = array();
            $n = count($all_edges);

            $added = false;
            for($i = 0; $i < $n; $i++) {
                if($all_edges[$i][0] == $scanline) {
                    $active[] = $all_edges[$i];
                    $added = true;
                } else {
                    $_tmp[] = $all_edges[$i];
                }
            }

            $all_edges = $_tmp;

            $_tmp = array();
            $n = count($active);

            for($i = 0; $i < $n; $i++) {
                if($active[$i][1] > $scanline)
                    $_tmp[] = $active[$i];
            }

            $active = $_tmp;

            $n = count($active);

            for($i = 0; $i < $n; $i++) {
                $min = $i;

                for($j = $i + 1; $j < $n; $j++) {
                    if($active[$j][2] < $active[$min][2])
                        $min = $j;
                }

                if($i != $min) {
                    $_tmp = $active[$i];
                    $active[$i] = $active[$min];
                    $active[$min] = $_tmp;
                }
            }

            $pixels[$scanline] = array();
            $n = count($active);

            for($i = 0; $i < $n; $i += 2) {
                if($i + 1 < $n) {
                    if($active[$i][2] == $active[$i + 1][2]) {
                        $x1 = intval(round($active[$i][2]));
                        $pixels[$scanline][] = array($x1, $x1);
                    } else {
                        $x1 = intval(round($active[$i][2]));
                        $x2 = intval(round($active[$i + 1][2]));
                        $pixels[$scanline][] = array($x1, $x2);
                    }
                }
            }

            $ok = true;
            $_tmp = array();
            $n = count($pixels[$scanline]);
            for($i = 0; $i < $n - 1; $i++) {
                list($x1, $x2) = $pixels[$scanline][$i];

                do {
                    $i++;
                    $ok = false;

                    list($_x1, $_x2) = $pixels[$scanline][$i];

                    if($x2 >= $_x1) {
                        $x2 = $_x2;
                        $ok = true;

                        if($i == $n - 1)
                            $i++;
                    }
                } while($ok && $i < $n - 1);

                $i--;
                $_tmp[] = array($x1, $x2);
            }

            if($i == $n - 1) {
                list($x1, $x2) = $pixels[$scanline][$n - 1];
                $_tmp[] = array($x1, $x2);
            }

            $pixels[$scanline] = $_tmp;

            foreach($pixels[$scanline] as $s) {
                if($s[0] == $s[1]) {
                    imagesetpixel($this->img, $s[0], $scanline, $color);
                } else
                    imageline($this->img, $s[0], $scanline, $s[1], $scanline, $color);
            }

            $n = count($active);
            for($i = 0; $i < $n; $i++) {
                $active[$i][2] += $active[$i][3];
            }

            $scanline++;
        }

        $n = count($points);

        for($i = 0; $i < $n; $i++) {
            $p1 = $points[$i];

            if($i == $n - 1)
                $p2 = $points[0];
            else $p2 = $points[$i + 1];

            $x1 = $p1[0]; $y1 = $p1[1];
            $x2 = $p2[0]; $y2 = $p2[1];

            if($y1 == $y2) {
                if($x1 > $x2) {
                    $tmp = $x2;
                    $x2 = $x1;
                    $x1 = $tmp;
                }

                $draw = array();

                if(!empty($pixels[$y1])) {
                    foreach($pixels[$y1] as $se) {
                        list($_x1, $_x2) = $se;

                        for($x = $_x1; $x <= $_x2; $x++)
                            $draw[$x] = true;
                    }
                }

                $s = null;

                for($x = intval($x1); $x <= $x2; $x++) {
                    if(array_key_exists($x, $draw)) {
                        if($s !== null) {
                            $pixels[$y1][] = array($s, $x - 1);
                            $s = null;
                        }
                    } else {
                        if($s === null)
                            $s = $x;
                        imagesetpixel($this->img, $x, $y1, $color);
                    }
                }

                if($s !== null)
                    $pixels[$y1][] = array($s, $x - 1);

            }
        }

        foreach($save_edges as $edge) {
            list($ymin, $ymax, $xval, $inverse) = $edge;

            for($y = intval($ymin); $y <= $ymax; $y++) {
                $x = intval(round($xval));

                if(array_key_exists($y, $pixels)) {
                    $draw = array();

                    foreach($pixels[$y] as $se) {
                        list($_x1, $_x2) = $se;

                        for($k = $_x1; $k <= $_x2; $k++)
                            $draw[$k] = true;
                    }

                    if(!array_key_exists($x, $draw)) {
                        imagesetpixel($this->img, $x, $y, $color);
                        $pixels[$y][] = array($x, $x);
                    }
                } else {
                    imagesetpixel($this->img, $x, $y, $color);
                    $pixels[$y][] = array($x, $x);
                }

                $xval += $inverse;
            }
        }
    }

    /**
     * @param float/double $deg
     * @return float
     */
    private function degreesToRadian($deg) {
        return self::PI * $deg / 180;
    }

    /**
     * @desc Getting differents variables for line styles
     * @param int $i1
     * @param int $i2
     * @param int $nb
     * @param int $i
     * @param string $style
     * @param int $density
     * @param double/float $dist
     */
    private function getLineVars(& $i1, & $i2, & $nb, & $i, $style, $density, $dist) {
        switch($style) {
            case 'dotted':
                $i1 = 1;
                $i2 = 1;
                break;
            case 'dashed':
                $i1 = 3;
                $i2 = 2;
                break;
            default;
                $i1 = 1;
                $i2 = 1;
                break;
        }

        //Delimit var
        $nb = ceil($dist / $density);

        $i = floor(($nb + $i2) / ($i1 + $i2));

        if($i > 1) {
            $i2 = ($nb - $i * $i1)/($i - 1);
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
     * @param string $path
     * @throws GraciaException
     */
    public function setFont($path) {
        if(file_exists($path))
            $this->font_path = $path;
        else 
            throw new GraciaException("The font file can not be opened. Verify the path.");
    }

    /**
     * @desc To use this method, the user must set a font with setFont();
     * @param int $size
     * @param int $x
     * @param int $y
     * @param string $text
     * @param string $colorName
     * @throws GraciaException
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
     * @param string $path_name
     */
    public function save($path_name) {
        imagepng($this->img, $path_name.'.png');
    }

    /**
     * @desc Merge the image with another image
     * @param string $file_path
     * @param int $x
     * @param int $y
     * @param int $opacity
     * @throws GraciaException
     */
    public function fusion($file_path, $x, $y, $opacity) {
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
            imagecopymerge($this->img, $src, $x, $y, 0, 0, $w_source, $h_source, $opacity);
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