<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $r_id;
    /**
     * @ORM\Column(type="string")
     */
    private $r_name;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="r_users")
     */
    private $r_users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->r_users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get rId
     *
     * @return integer
     */
    public function getRId()
    {
        return $this->r_id;
    }

    /**
     * Set rName
     *
     * @param string $rName
     *
     * @return Role
     */
    public function setRName($rName)
    {
        $this->r_name = $rName;

        return $this;
    }

    /**
     * Get rName
     *
     * @return string
     */
    public function getRName()
    {
        return $this->r_name;
    }

    /**
     * Add rUser
     *
     * @param \AppBundle\Entity\User $rUser
     *
     * @return Role
     */
    public function addRUser(\AppBundle\Entity\User $rUser)
    {
        $this->r_users[] = $rUser;

        return $this;
    }

    /**
     * Remove rUser
     *
     * @param \AppBundle\Entity\User $rUser
     */
    public function removeRUser(\AppBundle\Entity\User $rUser)
    {
        $this->r_users->removeElement($rUser);
    }

    /**
     * Get rUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRUsers()
    {
        return $this->r_users;
    }
}
