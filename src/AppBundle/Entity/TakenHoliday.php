<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="taken_holidays")
 */
class TakenHoliday
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $th_id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $th_from;
    /**
     * @ORM\Column(type="datetime")
     */
    private $th_to;
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="u_tholiday")
     * @ORM\JoinColumn(name="th_user", referencedColumnName="u_id")
     */
    private $th_user;
    /**
     * @ORM\OneToOne(targetEntity="Holiday", inversedBy="h_tuser")
     * @ORM\JoinColumn(name="th_holiday", referencedColumnName="h_id")
     */
    private $th_holiday;

    /**
     * Get thId
     *
     * @return integer
     */
    public function getThId()
    {
        return $this->th_id;
    }

    /**
     * Set thFrom
     *
     * @param \DateTime $thFrom
     *
     * @return TakenHoliday
     */
    public function setThFrom($thFrom)
    {
        $this->th_from = $thFrom;

        return $this;
    }

    /**
     * Get thFrom
     *
     * @return \DateTime
     */
    public function getThFrom()
    {
        return $this->th_from;
    }

    /**
     * Set thTo
     *
     * @param \DateTime $thTo
     *
     * @return TakenHoliday
     */
    public function setThTo($thTo)
    {
        $this->th_to = $thTo;

        return $this;
    }

    /**
     * Get thTo
     *
     * @return \DateTime
     */
    public function getThTo()
    {
        return $this->th_to;
    }

    /**
     * Set thUser
     *
     * @param \AppBundle\Entity\User $thUser
     *
     * @return TakenHoliday
     */
    public function setThUser(\AppBundle\Entity\User $thUser = null)
    {
        $this->th_user = $thUser;

        return $this;
    }

    /**
     * Get thUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getThUser()
    {
        return $this->th_user;
    }

    /**
     * Set thHoliday
     *
     * @param \AppBundle\Entity\Holiday $thHoliday
     *
     * @return TakenHoliday
     */
    public function setThHoliday(\AppBundle\Entity\Holiday $thHoliday = null)
    {
        $this->th_holiday = $thHoliday;

        return $this;
    }

    /**
     * Get thHoliday
     *
     * @return \AppBundle\Entity\Holiday
     */
    public function getThHoliday()
    {
        return $this->th_holiday;
    }
}
