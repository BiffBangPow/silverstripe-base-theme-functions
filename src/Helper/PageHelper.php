<?php

namespace BiffBangPow\Theme\BaseTheme\Helper;

class PageHelper
{

    /**
     * Return a colour tint for the supplied colour
     * @param $hex
     * @param $opacity
     * @return string
     */
    public static function colourTint($hex, $opacity): string
    {
        if (stristr($hex, '#')) {
            $hex = str_replace('#', '', $hex);
        }
        /// HEX TO RGB
        $rgb = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];

        return 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
    }

    /**
     * Return a brighter / darker version of the supplied colour
     * @param $hex
     * @param int $percent
     * @return string
     */
    public static function colourBrightness($hex, int $percent): string
    {
        $hex = str_replace('#', '', $hex);

        //Convert the hex to an array of RGB
        $rgb = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];

        //Calculate the new value for each
        for ($i = 0; $i < 3; $i++) {

            if ($percent > 0) {
                // Lighter
                $multiplier = 1 + ($percent / 100);
            } else if ($percent < 0) {
                $multiplier = 1 - (($percent * -1) / 100);
                // Darker
            } else {
                $multiplier = 1;
            }

            $rgb[$i] = round($rgb[$i] * $multiplier);

            //Add a bit of range limiting
            $rgb[$i] = min(255, $rgb[$i]);
            $rgb[$i] = max(0, $rgb[$i]);

        }


        // RGB to back to Hex
        $hex = '';
        for ($i = 0; $i < 3; $i++) {
            $hexDigit = dechex($rgb[$i]);

            //Add a leading zero if necessary
            if (strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
        }
        return '#' . $hex;
    }

}
