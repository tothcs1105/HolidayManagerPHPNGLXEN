<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="holidays")
 */
class Holiday
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $h_id;

    /**
     * @ORM\Column(type="string")
     */
    private $h_name;

    /**
     * @ORM\OneToOne(targetEntity="AvailableHoliday", mappedBy="ah_holiday")
     */
    private $h_auser;

    /**
     * @ORM\OneToOne(targetEntity="TakenHoliday", mappedBy="th_holiday")
     */
    private $h_tuser;

    /**
     * Get hId
     *
     * @return integer
     */
    public function getHId()
    {
        return $this->h_id;
    }

    /**
     * Set hName
     *
     * @param string $hName
     *
     * @return Holiday
     */
    public function setHName($hName)
    {
        $this->h_name = $hName;

        return $this;
    }

    /**
     * Get hName
     *
     * @return string
     */
    public function getHName()
    {
        return $this->h_name;
    }

    /**
     * Set hAuser
     *
     * @param \AppBundle\Entity\AvailableHoliday $hAuser
     *
     * @return Holiday
     */
    public function setHAuser(\AppBundle\Entity\AvailableHoliday $hAuser = null)
    {
        $this->h_auser = $hAuser;

        return $this;
    }

    /**
     * Get hAuser
     *
     * @return \AppBundle\Entity\AvailableHoliday
     */
    public function getHAuser()
    {
        return $this->h_auser;
    }

    /**
     * Set hTuser
     *
     * @param \AppBundle\Entity\TakenHoliday $hTuser
     *
     * @return Holiday
     */
    public function setHTuser(\AppBundle\Entity\TakenHoliday $hTuser = null)
    {
        $this->h_tuser = $hTuser;

        return $this;
    }

    /**
     * Get hTuser
     *
     * @return \AppBundle\Entity\TakenHoliday
     */
    public function getHTuser()
    {
        return $this->h_tuser;
    }
}