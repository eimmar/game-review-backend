<?php

declare(strict_types=1);

namespace App\Tests\Unit\Security\Voter;

use App\Entity\Review;
use App\Entity\User;
use App\Security\Voter\ReviewVoter;
use PHPUnit\Framework\TestCase;

class ReviewVoterTest extends TestCase
{
    private ReviewVoter $voter;


    public function setUp()
    {
        $this->voter = new ReviewVoter();
    }

    public function testCanView()
    {
        $reflector = new \ReflectionClass($this->voter);
        $canView = $reflector->getMethod('canView');
        $canView->setAccessible(true);
        $user = new User();
        $review = new Review();

        $review->setApproved(true);
        $this->assertTrue($canView->invokeArgs($this->voter, [$review, $user]));

        $review->setUser($user);
        $review->setApproved(false);
        $this->assertTrue($canView->invokeArgs($this->voter, [$review, $user]));

        $review->setUser(new User());
        $this->assertFalse($canView->invokeArgs($this->voter, [$review, $user]));
    }

    public function testCanModify()
    {
        $reflector = new \ReflectionClass($this->voter);
        $canModify = $reflector->getMethod('canModify');
        $canModify->setAccessible(true);
        $user = new User();
        $review = new Review();

        $this->assertFalse($canModify->invokeArgs($this->voter, [$review, $user]));

        $review->setUser($user);
        $this->assertTrue($canModify->invokeArgs($this->voter, [$review, $user]));
    }
}
