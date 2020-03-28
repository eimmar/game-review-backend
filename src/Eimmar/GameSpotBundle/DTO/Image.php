<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\DTO;

class Image implements DTO
{
    /**
     * @var string
     */
    private string $squareTiny;

    /**
     * @var string
     */
    private string $screenTiny;

    /**
     * @var string
     */
    private string $squareSmall;

    /**
     * @var string
     */
    private string $original;

    /**
     * @param string $squareTiny
     * @param string $screenTiny
     * @param string $squareSmall
     * @param string $original
     */
    public function __construct(string $squareTiny, string $screenTiny, string $squareSmall, string $original)
    {
        $this->squareTiny = $squareTiny;
        $this->screenTiny = $screenTiny;
        $this->squareSmall = $squareSmall;
        $this->original = $original;
    }

    /**
     * @return string
     */
    public function getSquareTiny(): string
    {
        return $this->squareTiny;
    }

    /**
     * @return string
     */
    public function getScreenTiny(): string
    {
        return $this->screenTiny;
    }

    /**
     * @return string
     */
    public function getSquareSmall(): string
    {
        return $this->squareSmall;
    }

    /**
     * @return string
     */
    public function getOriginal(): string
    {
        return $this->original;
    }
}
