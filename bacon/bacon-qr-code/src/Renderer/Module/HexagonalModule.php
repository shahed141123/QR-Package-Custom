<?php
declare(strict_types = 1);

namespace BaconQrCode\Renderer\Module;

use BaconQrCode\Encoder\ByteMatrix;
use BaconQrCode\Exception\InvalidArgumentException;
use BaconQrCode\Renderer\Path\Path;

/**
 * Renders individual modules as dots.
 */
final class HexagonalModule implements ModuleInterface
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
    $margin = (2 - $this->size) / 2; // Increase margin for more spacing

    // Define the increase in width for each side
    $widthIncrease = 0.2; // Adjust this value as needed

    for ($y = 0; $y < $height; ++$y) {
        for ($x = 0; $x < $width; ++$x) {
            if (!$matrix->get($x, $y)) {
                continue;
            }

            $pathX = $x + $margin;
            $pathY = $y + $margin;

            // Adjusted width for each side
            $adjustedWidth = $this->size * (0.9 + $widthIncrease);

            // Draw a hexagon shape with adjusted width
            $path = $path
                ->move($pathX + $halfSize, $pathY)
                ->line($pathX + $adjustedWidth, $pathY + ($halfSize / 2))
                ->line($pathX + $adjustedWidth, $pathY + $halfSize + ($halfSize / 3))
                ->line($pathX + $halfSize, $pathY + $this->size)
                ->line($pathX, $pathY + $halfSize + ($halfSize / 2))
                ->line($pathX, $pathY + ($halfSize / 2))
                ->close()
            ;
        }
    }

    return $path;
}



















}
