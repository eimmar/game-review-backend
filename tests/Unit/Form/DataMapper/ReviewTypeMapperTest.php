<?php

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

declare(strict_types=1);

namespace App\Tests\Unit\Form\DataMapper;

use App\Entity\Game;
use App\Entity\Review;
use App\Entity\User;
use App\Form\DataMapper\ReviewTypeMapper;
use PHPUnit\Framework\TestCase;

class ReviewTypeMapperTest extends TestCase
{
    private ReviewTypeMapper $mapper;

    public function setUp()
    {
        $this->mapper = new ReviewTypeMapper();
    }

    public function testMapDataToForms()
    {
        //TODO: Finish tests
//        $data = new Review();
//        $data->setGame(new Game());
//        $data->setUser(new User());
//        $data->setTitle('review');
//        $data->setComment('comment');
//        $data->setRating(10);
//
//        $data->setPros(null);
//        $data->setCons('con|con2|||||||||| |con3');
//
//        $this->mapper->mapDataToForms();
    }

    public function testMapFormsToData()
    {

    }
}
