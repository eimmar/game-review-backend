<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DTO\PaginationRequest;
use App\Entity\Review;
use App\Entity\User;
use App\Service\ReviewService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class ReviewServiceTest extends TestCase
{
    private ReviewService $service;

    private Security $security;

    public function setUp()
    {
        $this->security = $this->createMock(Security::class);
        $this->service = new ReviewService($this->security);
    }

    public function testGetUserReviews()
    {
        $user = new User();
        $review = new Review();
        $review->setApproved(true);
        $review2 = new Review();
        $review2->setApproved(true);
        $review3 = new Review();
        $user->setReviews(new ArrayCollection([$review, $review2, $review3]));

        $this->security->method('getUser')->willReturn($user, new User(), null);

        $this->assertEquals([$review, $review2, $review3], $this->service->getUserReviews(new PaginationRequest(0, 3), $user));
        $this->assertEquals([$review, $review2], $this->service->getUserReviews(new PaginationRequest(0, 3), $user));
        $this->assertEquals([$review, $review2], $this->service->getUserReviews(new PaginationRequest(0, 3), $user));
    }
}
