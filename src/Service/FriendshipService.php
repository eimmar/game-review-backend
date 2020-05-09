<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\SearchRequest;
use App\Entity\Friendship;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Repository\FriendshipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class FriendshipService
{
    private EntityManagerInterface $entityManager;

    private FriendshipRepository $friendshipRepository;

    private Security $security;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->friendshipRepository = $entityManager->getRepository(Friendship::class);
        $this->security = $security;
    }

    private function checkCurrentUser()
    {
        if (!$this->security->getUser()) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param User $friend
     * @return Friendship
     * @throws LogicException
     */
    public function addFriend(User $friend)
    {
        $this->checkCurrentUser();

        if ($this->security->getUser() === $friend) {
            throw new LogicException(LogicExceptionCode::INVALID_DATA);
        }

        if ($this->friendshipRepository->findFriendship($this->security->getUser(), $friend)) {
            throw new LogicException(LogicExceptionCode::FRIENDSHIP_USER_ALREADY_FRIEND);
        }

        $friendship = new Friendship($this->security->getUser(), $friend);
        $this->entityManager->persist($friendship);
        $this->entityManager->flush();

        return $friendship;
    }

    /**
     * @param User $friend
     */
    public function removeFriend(User $friend)
    {
        $this->checkCurrentUser();

        /** @var Friendship|null $friendship */
        $friendship = $this->friendshipRepository->findFriendship($this->security->getUser(), $friend, FriendshipStatus::ACCEPTED);

        if ($friendship) {
            $this->entityManager->remove($friendship);
            $this->entityManager->flush();
        }
    }


    /**
     * @param User $initiator
     * @return Friendship|null
     */
    public function acceptRequest(User $initiator)
    {
        $this->checkCurrentUser();

        /** @var Friendship|null $friendship */
        $friendship = $this->friendshipRepository->findFriendRequest($this->security->getUser(), $initiator);

        if ($friendship) {
            $friendship->setStatus(FriendshipStatus::ACCEPTED);
            $friendship->setAcceptedAt(new \DateTimeImmutable());
            $this->entityManager->persist($friendship);
            $this->entityManager->flush();
        } else {
            throw new LogicException(LogicExceptionCode::INVALID_DATA);
        }

        return $friendship;
    }

    /**
     * @param SearchRequest $request
     * @return array
     */
    public function getFriendships(SearchRequest $request)
    {
        $this->checkCurrentUser();

        return $this->friendshipRepository->findAllFriendships($this->security->getUser(), $request);
    }

    /**
     * @param SearchRequest $request
     * @return int
     */
    public function countFriendships(SearchRequest $request)
    {
        $this->checkCurrentUser();

        return $this->friendshipRepository->countFriendships($this->security->getUser(), $request);
    }

    /**
     * @param User $user
     * @param int|null $status
     * @return Friendship|null
     */
    public function getFriendship(User $user, ?int $status = null)
    {
        $this->checkCurrentUser();

        return $this->friendshipRepository->findFriendship($this->security->getUser(), $user, $status);
    }
}
