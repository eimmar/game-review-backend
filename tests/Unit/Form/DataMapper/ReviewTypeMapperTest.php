<?php

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
