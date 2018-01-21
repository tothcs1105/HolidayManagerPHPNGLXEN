<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="available_holidays")
 */
class AvailableHoliday
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="u_aholidays")
     * @ORM\JoinColumn(name="ah_user", referencedColumnName="u_name")
     */
    private $ah_user;
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Holiday", inversedBy="h_ausers")
     * @ORM\JoinColumn(name="ah_holiday", referencedColumnName="h_id")
     */
    private $ah_holiday;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $ah_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $ah_days;

    /**
     * Set ahYear
     *
     * @param integer $ahYear
     *
     * @return AvailableHoliday
     */
    public function setAhYear($ahYear)
    {
        $this->ah_year = $ahYear;

        return $this;
    }

    /**
     * Get ahYear
     *
     * @return integer
     */
    public function getAhYear()
    {
        return $this->ah_year;
    }

    /**
     * Set ahDays
     *
     * @param integer $ahDays
     *
     * @return AvailableHoliday
     */
    public function setAhDays($ahDays)
    {
        $this->ah_days = $ahDays;

        return $this;
    }

    /**
     * Get ahDays
     *
     * @return integer
     */
    public function getAhDays()
    {
        return $this->ah_days;
    }

    /**
     * Set ahUser
     *
     * @param \AppBundle\Entity\User $ahUser
     *
     * @return AvailableHoliday
     */
    public function setAhUser(\AppBundle\Entity\User $ahUser)
    {
        $this->ah_user = $ahUser;

        return $this;
    }

    /**
     * Get ahUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getAhUser()
    {
        return $this->ah_user;
    }

    /**
     * Set ahHoliday
     *
     * @param \AppBundle\Entity\Holiday $ahHoliday
     *
     * @return AvailableHoliday
     */
    public function setAhHoliday(\AppBundle\Entity\Holiday $ahHoliday)
    {
        $this->ah_holiday = $ahHoliday;

        return $this;
    }

    /**
     * Get ahHoliday
     *
     * @return \AppBundle\Entity\Holiday
     */
    public function getAhHoliday()
    {
        return $this->ah_holiday;
    }
}
