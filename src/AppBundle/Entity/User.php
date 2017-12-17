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
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $u_id;
    /**
     * @ORM\Column(type="string")
     */
    private $u_name;
    /**
     * @ORM\Column(type="string")
     */
    private $u_pass;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="r_users")
     * @ORM\JoinColumn(name="u_role", referencedColumnName="r_id")
     */
    private $u_role;

    /**
     * @ORM\OneToOne(targetEntity="AvailableHoliday", mappedBy="ah_user")
     */
    private $u_aholiday;

    /**
     * @ORM\OneToOne(targetEntity="TakenHoliday", mappedBy="th_user")
     */
    private $u_tholiday;

    /**
     * Get uId
     *
     * @return integer
     */
    public function getUId()
    {
        return $this->u_id;
    }

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
}