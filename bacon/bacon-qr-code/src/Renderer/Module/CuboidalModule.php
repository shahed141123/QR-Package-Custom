<?php
declare(strict_types = 1);

namespace BaconQrCode\Renderer\Module;

use BaconQrCode\Encoder\ByteMatrix;
use BaconQrCode\Exception\InvalidArgumentException;
use BaconQrCode\Renderer\Path\Path;

/**
 * Renders individual modules as dots.
 */
final class CuboidalModule implements ModuleInterface
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

        // Define the corner distances for the hexagon
        $cornerDistances = [
            [0, $halfSize],
            [$halfSize * sqrt(3) / 2, 0.5 * $halfSize],
            [$halfSize * sqrt(3) / 2, 1.5 * $halfSize],
            [0, 2 * $halfSize],
            [-$halfSize * sqrt(3) / 2, 1.5 * $halfSize],
            [-$halfSize * sqrt(3) / 2, 0.5 * $halfSize],
            [0, $halfSize],
        ];

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if (!$matrix->get($x, $y)) {
                    continue;
                }

                $pathX = $x + $margin;
                $pathY = $y + $margin;

                // Move to the starting point
                $path = $path->move($pathX + $cornerDistances[0][0], $pathY + $cornerDistances[0][1]);

                // Draw the hexagon
                for ($i = 1; $i < count($cornerDistances); $i++) {
                    $corner = $cornerDistances[$i];
                    $path = $path->line($pathX + $corner[0], $pathY + $corner[1]);
                }

                // Close the hexagon
                $path = $path->close();
            }
        }

        return $path;
    }


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
