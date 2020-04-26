<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\FriendshipStatus;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Friendship
{
    /**
     * @Groups({"user"})
     * @ORM\Id()
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friends")
     */
    private $sender;

    /**
     * @Groups({"user"})
     * @ORM\Id()
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="friendsWithMe")
     */
    private $receiver;

    /**
     * @Groups({"friendship"})
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $status;

    /**
     * @Groups({"friendship"})
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @Groups({"friendship"})
     * @var DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    protected $acceptedAt;

    /**
     * @param User $sender
     * @param User $receiver
     */
    public function __construct(User $sender, User $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->status = FriendshipStatus::PENDING;
    }

    /**
     * @return User
     */
    public function getSender(): User
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     */
    public function setSender(User $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return User
     */
    public function getReceiver(): User
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     */
    public function setReceiver(User $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getAcceptedAt(): ?DateTimeImmutable
    {
        return $this->acceptedAt;
    }

    /**
     * @param DateTimeImmutable|null $acceptedAt
     */
    public function setAcceptedAt(?DateTimeImmutable $acceptedAt): void
    {
        $this->acceptedAt = $acceptedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
