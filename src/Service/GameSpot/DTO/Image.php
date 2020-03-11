<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Service\GameSpot\DTO;

class Image implements DTO
{
    /**
     * @var string
     */
    private $squareTiny;

    /**
     * @var string
     */
    private $screenTiny;

    /**
     * @var string
     */
    private $squareSmall;

    /**
     * @var string
     */
    private $original;

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
