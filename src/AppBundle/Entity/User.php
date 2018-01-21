<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $u_name;
    /**
     * @ORM\Column(type="string")
     */
    private $u_pass;

    /**
     * @ORM\Column(type="boolean")
     */
    private $u_admin;
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="r_users")
     * @ORM\JoinColumn(name="u_role", referencedColumnName="r_id")
     */
    private $u_role;

    /**
     * @ORM\OneToMany(targetEntity="AvailableHoliday", mappedBy="ah_user")
     */
    private $u_aholidays;

    /**
     * @ORM\OneToMany(targetEntity="TakenHoliday", mappedBy="th_user")
     */
    private $u_tholidays;

    /**
     * Set uName
     *
     * @param string $uName
     *
     * @return User
     */
    public function setUName($uName)
    {
        $this->u_name = $uName;

        return $this;
    }

    /**
     * Get uName
     *
     * @return string
     */
    public function getUName()
    {
        return $this->u_name;
    }

    /**
     * Set uPass
     *
     * @param string $uPass
     *
     * @return User
     */
    public function setUPass($uPass)
    {
        $this->u_pass = $uPass;

        return $this;
    }

    /**
     * Get uPass
     *
     * @return string
     */
    public function getUPass()
    {
        return $this->u_pass;
    }

    /**
     * Set uRole
     *
     * @param \AppBundle\Entity\Role $uRole
     *
     * @return User
     */
    public function setURole(\AppBundle\Entity\Role $uRole = null)
    {
        $this->u_role = $uRole;

        return $this;
    }

    /**
     * Get uRole
     *
     * @return \AppBundle\Entity\Role
     */
    public function getURole()
    {
        return $this->u_role;
    }

    /**
     * Set uAholiday
     *
     * @param \AppBundle\Entity\AvailableHoliday $uAholiday
     *
     * @return User
     */
    public function setUAholiday(\AppBundle\Entity\AvailableHoliday $uAholiday = null)
    {
        $this->u_aholiday = $uAholiday;

        return $this;
    }

    /**
     * Get uAholiday
     *
     * @return \AppBundle\Entity\AvailableHoliday
     */
    public function getUAholiday()
    {
        return $this->u_aholiday;
    }

    /**
     * Set uTholiday
     *
     * @param \AppBundle\Entity\TakenHoliday $uTholiday
     *
     * @return User
     */
    public function setUTholiday(\AppBundle\Entity\TakenHoliday $uTholiday = null)
    {
        $this->u_tholiday = $uTholiday;

        return $this;
    }

    /**
     * Get uTholiday
     *
     * @return \AppBundle\Entity\TakenHoliday
     */
    public function getUTholiday()
    {
        return $this->u_tholiday;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->u_aholidays = new \Doctrine\Common\Collections\ArrayCollection();
        $this->u_tholidays = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add uAholiday
     *
     * @param \AppBundle\Entity\AvailableHoliday $uAholiday
     *
     * @return User
     */
    public function addUAholiday(\AppBundle\Entity\AvailableHoliday $uAholiday)
    {
        $this->u_aholidays[] = $uAholiday;

        return $this;
    }

    /**
     * Remove uAholiday
     *
     * @param \AppBundle\Entity\AvailableHoliday $uAholiday
     */
    public function removeUAholiday(\AppBundle\Entity\AvailableHoliday $uAholiday)
    {
        $this->u_aholidays->removeElement($uAholiday);
    }

    /**
     * Get uAholidays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUAholidays()
    {
        return $this->u_aholidays;
    }

    /**
     * Add uTholiday
     *
     * @param \AppBundle\Entity\TakenHoliday $uTholiday
     *
     * @return User
     */
    public function addUTholiday(\AppBundle\Entity\TakenHoliday $uTholiday)
    {
        $this->u_tholidays[] = $uTholiday;

        return $this;
    }

    /**
     * Remove uTholiday
     *
     * @param \AppBundle\Entity\TakenHoliday $uTholiday
     */
    public function removeUTholiday(\AppBundle\Entity\TakenHoliday $uTholiday)
    {
        $this->u_tholidays->removeElement($uTholiday);
    }

    /**
     * Get uTholidays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUTholidays()
    {
        return $this->u_tholidays;
    }

    /**
     * Set uAdmin.
     *
     * @param bool $uAdmin
     *
     * @return User
     */
    public function setUAdmin($uAdmin)
    {
        $this->u_admin = $uAdmin;

        return $this;
    }

    /**
     * Get uAdmin.
     *
     * @return bool
     */
    public function getUAdmin()
    {
        return $this->u_admin;
    }
}
