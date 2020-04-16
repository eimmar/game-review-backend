<?php
namespace App\Entity;
use App\Enum\GameListType;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *     name="fos_user",
 *     indexes={@ORM\Index(columns={"first_name", "last_name", "email"}, flags={"fulltext"})}
 *     )
 */
class User extends BaseUser
{
    use TimestampableTrait;

    /**
     * @Groups({"user"})
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var GameList[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\GameList", mappedBy="user", cascade={"persist", "remove"})
     */
    private $gameLists;

    /**
     * @var Review[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="user", cascade={"persist", "remove"})
     */
    private $reviews;

    /**
     * @Groups({"user"})
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;

    /**
     * @Groups({"user"})
     * @var string|null
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @Groups({"user"})
     */
    protected $email;

    /**
     * @Groups({"user"})
     */
    protected $roles;

    public function __construct()
    {
        parent::__construct();
        $favorites = new GameList(GameListType::FAVORITES, $this);
        $wishlist = new GameList(GameListType::WISHLIST, $this);
        $played = new GameList(GameListType::PLAYING, $this);
        $favorites->setName('Favorites');
        $wishlist->setName('Wishlist');
        $played->setName('Played');

        $this->gameLists = new ArrayCollection([$favorites, $wishlist, $played]);
        $this->firstName = '';
    }

    /**
     * @return GameList[]|Collection
     */
    public function getGameLists(): Collection
    {
        return $this->gameLists;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Review[]|ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param Review[]|ArrayCollection $reviews
     */
    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
        $this->username = $email;
    }
}
