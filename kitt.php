<?php

use Scheb\QlcGenerator\Qlc\Sequence;

require __DIR__ . '/vendor/autoload.php';

$alphaAnim = [
    [0.8, 0.1, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0],
    [0.6, 0.8, 0.1, 0.0, 0.0, 0.0, 0.0, 0.0],
    [0.4, 0.6, 0.8, 0.1, 0.0, 0.0, 0.0, 0.0],
    [0.2, 0.4, 0.6, 0.8, 1.0, 0.0, 0.0, 0.0],
    [0.0, 0.2, 0.4, 0.6, 0.8, 1.0, 0.0, 0.0],
    [0.0, 0.0, 0.2, 0.4, 0.6, 0.8, 1.0, 0.0],
    [0.0, 0.0, 0.0, 0.2, 0.4, 0.6, 0.8, 1.0],
    [0.0, 0.0, 0.0, 0.0, 0.2, 0.4, 0.6, 1.0],
    [0.0, 0.0, 0.0, 0.0, 0.0, 0.2, 0.4, 1.0],
    [0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.2, 1.0],
    [0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 1.0, 0.8],
    [0.0, 0.0, 0.0, 0.0, 0.0, 1.0, 0.8, 0.6],
    [0.0, 0.0, 0.0, 0.0, 1.0, 0.8, 0.6, 0.4],
    [0.0, 0.0, 0.0, 1.0, 0.8, 0.6, 0.4, 0.2],
    [0.0, 0.0, 1.0, 0.8, 0.6, 0.4, 0.2, 0.0],
    [0.0, 1.0, 0.8, 0.6, 0.4, 0.2, 0.0, 0.0],
    [1.0, 0.8, 0.6, 0.4, 0.2, 0.0, 0.0, 0.0],
    [1.0, 0.6, 0.4, 0.2, 0.0, 0.0, 0.0, 0.0],
    [1.0, 0.4, 0.2, 0.0, 0.0, 0.0, 0.0, 0.0],
    [1.0, 0.2, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0],
    [1.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0],
];

// Generate Sequence in each color
foreach (COLORS as $colorName => $color) {
    $scene = new Sequence('Kitt ' . $colorName);

    foreach ($alphaAnim as $stepAlphas) {
        $deviceValues = [];
        foreach ([BAR1, BAR2] as $device) {
            $deviceValues[$device] = [];
            foreach ($stepAlphas as $alpha) {
                $deviceValues[$device] = array_merge($deviceValues[$device], getRGB($color, $alpha));
            }
        }
        $scene->addStep($deviceValues);
    }

    echo $scene->generate();
}
