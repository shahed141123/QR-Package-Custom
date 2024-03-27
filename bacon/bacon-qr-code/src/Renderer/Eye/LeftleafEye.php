<?php
declare(strict_types = 1);

namespace BaconQrCode\Renderer\Eye;

use BaconQrCode\Renderer\Path\Path;

/**
 * Renders the inner eye as a circle.
 */
final class LeftleafEye implements EyeInterface
{
    /**
     * @var self|null
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function instance() : self
    {
        return self::$instance ?: self::$instance = new self();
    }

    public function getExternalPath() : Path
    {
        return (new Path())
            ->move(-3.5, -3.5)
            ->line(3.5, -3.5)
            ->line(3.5, 3.5)
            ->line(-3.5, 3.5)
            ->close()
            ->move(-2.5, -2.5)
            ->line(-2.5, 2.5)
            ->line(2.5, 2.5)
            ->line(2.5, -2.5)
            ->close()
        ;
    }

    // public function getInternalPath() : Path
    // {
    //     return (new Path())
    //         ->move(1.5, 0)
    //         ->ellipticArc(1.54, 1.5, 0., false, true, 0., 1.5)
    //         ->ellipticArc(1.5, 1.5, 0., false, true, -1.5, 0.)
    //         ->ellipticArc(1.5, 1.5, 0., false, true, 0., -1.5)
    //         ->ellipticArc(1.5, 1.5, 0., false, true, 1.5, 0.)
    //         ->close()
    //     ;
    // }
    // public function getInternalPath() : Path
    // {
    //     return (new Path())
    //         ->move(1.5, 0)
    //         ->ellipticArc(1.54, 1.5, 0, false, true, 0, 1.5)  // Keep top right arc
    //         ->line(-1.3, 1.6)  // Straight line for top side
    //         ->line(-1.5, 0)    // Replace bottom left arc with a line
    //         ->ellipticArc(1.5, 1.5, 0, false, true, 0, -1.5)
    //         ->line(1.3, -1.6)  // Straight line for top side
    //         ->line(1.5, 0)
    //         ->close();
    // }
    public function getInternalPath() : Path
{
    return (new Path())
        ->move(1.5, 0)
        ->line(1.8, 1.5) // Straight line
        ->line(0, 1.5) // Straight line
        ->ellipticArc(1.5, 1.5, 0, false, true, 0, -1.5) // Bottom left curved side
        ->ellipticArc(1.5, 1.5, 0, false, true, 1.5, 0) // Bottom right curved side
        // ->line(1.8, 1.5) // Straight line from the endpoint of the first line
        ->line(1.5, -1.5) // Straight line (opposite of the third line)
        ->close();
}






}
