<?php
declare(strict_types = 1);

namespace BaconQrCode\Renderer\Module;

use BaconQrCode\Encoder\ByteMatrix;
use BaconQrCode\Exception\InvalidArgumentException;
use BaconQrCode\Renderer\Path\Path;

/**
 * Renders individual modules as dots.
 */
final class DiamondModule implements ModuleInterface
{
    public const LARGE = 1;
    public const MEDIUM = .8;
    public const SMALL = .6;

    /**
     * @var float
     */
    private $size;

    public function __construct(float $size)
    {
        if ($size <= 0 || $size > 1) {
            throw new InvalidArgumentException('Size must between 0 (exclusive) and 1 (inclusive)');
        }

        $this->size = $size;
    }

    public function createPath(ByteMatrix $matrix) : Path
    {
        $width = $matrix->getWidth();
        $height = $matrix->getHeight();
        $path = new Path();
        $halfSize = $this->size / 2;
        $margin = (1 - $this->size) / 2;

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if (!$matrix->get($x, $y)) {
                    continue;
                }

                $pathX = $x + $margin;
                $pathY = $y + $margin;

                // Draw a diamond shape instead of ellipses
                $path = $path
                    ->move($pathX + $halfSize, $pathY)
                    ->line($pathX + $this->size, $pathY + $halfSize)
                    ->line($pathX + $halfSize, $pathY + $this->size)
                    ->line($pathX, $pathY + $halfSize)
                    ->close()
                ;
            }
        }

        return $path;
    }

//     public function createPath(ByteMatrix $matrix) : Path
// {
//     $width = $matrix->getWidth();
//     $height = $matrix->getHeight();
//     $path = new Path();
//     $halfSize = $this->size / 2;
//     $margin = (1 - $this->size) / 2;
//     $hexHeight = 3 * sqrt(3) / 2 * $halfSize;
//     $horizontalSpacing = $halfSize * 3;

//     for ($y = 0; $y < $height; ++$y) {
//         for ($x = 0; $x < $width; ++$x) {
//             if ($matrix->get($x, $y)) {
//                 $pathX = $x * $horizontalSpacing + $margin;
//                 $pathY = $y * $hexHeight * 2 + $margin;

//                 // Draw hexagons
//                 $path = $path
//                     ->move($pathX + $halfSize, $pathY)
//                     ->line($pathX + $this->size, $pathY + $hexHeight / 2)
//                     ->line($pathX + $this->size, $pathY + $hexHeight + $hexHeight / 2)
//                     ->line($pathX + $halfSize, $pathY + 2 * $hexHeight)
//                     ->line($pathX, $pathY + $hexHeight + $hexHeight / 2)
//                     ->line($pathX, $pathY + $hexHeight / 2)
//                     ->close();
//             }
//         }
//     }

//     return $path;
// }

// public function createPath(ByteMatrix $matrix) : Path
// {
//     $width = $matrix->getWidth();
//     $height = $matrix->getHeight();
//     $path = new Path();
//     $halfSize = $this->size / 2;
//     $margin = (1 - $this->size) / 2;

//     // Angle of rotation for the hexagon
//     $rotationAngle = deg2rad(-30); // 30 degrees counter-clockwise rotation

//     for ($y = 0; $y < $height; ++$y) {
//         for ($x = 0; $x < $width; ++$x) {
//             if (!$matrix->get($x, $y)) {
//                 continue;
//             }

//             $pathX = $x + $margin;
//             $pathY = $y + $margin;

//             // Calculate the coordinates for the vertices of the hexagon
//             $points = [];
//             for ($i = 0; $i < 6; $i++) {
//                 $angle = $rotationAngle + $i * (2 * M_PI / 6);
//                 $hexX = $pathX + $halfSize * cos($angle);
//                 $hexY = $pathY + $halfSize * sin($angle);
//                 $points[] = [$hexX, $hexY];
//             }

//             // Draw the hexagon
//             $path = $path
//                 ->move($points[0][0], $points[0][1]);
//             for ($i = 1; $i < 6; $i++) {
//                 $path = $path->line($points[$i][0], $points[$i][1]);
//             }
//             $path = $path->close();
//         }
//     }

//     return $path;
// }

















    





}
