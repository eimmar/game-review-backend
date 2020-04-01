<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var GameList[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\GameList", mappedBy="user")
     */
    private $gameLists;

    public function __construct()
    {
        parent::__construct();
        $this->gameLists = new ArrayCollection();
    }

    /**
     * @return GameList[]|PersistentCollection
     */
    public function getGameLists(): PersistentCollection
    {
        return $this->gameLists;
    }
}
