<?php

function getRGB($hexColor, $alpha = 1) {
    $intColor = hexdec($hexColor);
    $red = (($intColor >> 16) & 0xff) * $alpha;
    $green = (($intColor >> 8) & 0xff) * $alpha;
    $blue = ($intColor & 0xff) * $alpha;

    return [round($red), round($green), round($blue)];
}
