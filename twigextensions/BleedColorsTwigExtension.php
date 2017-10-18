<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class BleedColorsTwigExtension extends \Twig_Extension
{

    //
    // -- PRIVATE --------------------------------------------------------------------------------------------------------------
    //

    private function _hex2rgb($hexStr, $returnAsString = false, $seperator = ',')
    {
        /**
        * Convert a hexa decimal color code to its RGB equivalent.
        * Credit goes to hafees@msn.com for this one.
        *
        * @param string $hexStr (hexadecimal color value)
        * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
        * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
        * @return array or string (depending on second parameter. Returns False if invalid hex color value)
        */ 

        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();

        // If a proper hex code, convert using bitwise operation. No overhead... faster
        if (strlen($hexStr) == 6) {
            $colorVal = hexdec($hexStr);
            $rgbArray['red']   = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue']  = 0xFF & $colorVal;
        }
        // If shorthand notation, need some string manipulations
        elseif (strlen($hexStr) == 3) {
            $rgbArray['red']   = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue']  = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        }
        // If invalid hex color code
        else {
            return false;
        }

        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }

    private function getBrightness($c)
    {
        /**
         * This method will return a number in the rage of 0 (black) to 255 (White)
         * and to set the foreground color based on the Brightness method:
         *
         * brightness  =  sqrt( .241 R2 + .691 G2 + .068 B2 )
         * http://alienryderflex.com/hsp.html
         *
         * @param array $c  Color array
         */

        return (int)sqrt(
            $c['red']   * $c['red']   * .241 + 
            $c['green'] * $c['green'] * .691 + 
            $c['blue']  * $c['blue']  * .068);
    }

    //
    // -- PUBLIC --------------------------------------------------------------------------------------------------------------
    //

    public function getName()
    {
        return 'BleedColors';
    }

    public function getFilters()
    {
        return array(
            'brightness' => new Twig_Filter_Method($this, 'brightness'),
            'isLight'    => new Twig_Filter_Method($this, 'isLight'),
            'isDark'     => new Twig_Filter_Method($this, 'isDark'),
            'hex2rgb'    => new Twig_Filter_Method($this, 'hex2rgb'),
        );
    }

    public function isLight($h, $t = 130) {
        /**
         * Checks if the color is light according
         * to the specified threshold.
         *
         * @param string $h  The hex value
         * @param int    $t  The brightness threshold
         */

        $res = $this->brightness($h);
        return ($res >= $t ? true : false);
    }

    public function isDark($h, $t = 130) {
        /**
         * Checks if the color is light according
         * to the specified threshold.
         *
         * @param string $h  The hex value
         * @param int    $t  The brightness threshold
         */

        $res = $this->brightness($h);
        return ($res <= $t ? true : false);
    }

    public function brightness($h)
    {
        /**
         * Converts Hexadecimal to RGB and returns the
         * brightness value of it on a scale from 0-255.
         *
         * @param string $hex  The hexadecimal string
         */

        $rgb = $this->_hex2rgb($h);
        $res = $this->getBrightness($rgb);
        
        return $res;
    }

    public function hex2rgb($v, $s = true) {
        /**
         * Converts Hexadecimal to RGB.
         *
         * @param string  $v  The hex value
         * @param boolean $s  String (true) or array (false)
         */

        return $this->_hex2rgb($v, $s);
    }
}
