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
     * @ORM\OneToMany(targetEntity="AvailableHoliday", mappedBy="ah_holiday")
     */
    private $h_ausers;

    /**
     * @ORM\OneToMany(targetEntity="TakenHoliday", mappedBy="th_holiday")
     */
    private $h_tusers;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->h_ausers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->h_tusers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add hAuser
     *
     * @param \AppBundle\Entity\AvailableHoliday $hAuser
     *
     * @return Holiday
     */
    public function addHAuser(\AppBundle\Entity\AvailableHoliday $hAuser)
    {
        $this->h_ausers[] = $hAuser;

        return $this;
    }

    /**
     * Remove hAuser
     *
     * @param \AppBundle\Entity\AvailableHoliday $hAuser
     */
    public function removeHAuser(\AppBundle\Entity\AvailableHoliday $hAuser)
    {
        $this->h_ausers->removeElement($hAuser);
    }

    /**
     * Get hAusers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHAusers()
    {
        return $this->h_ausers;
    }

    /**
     * Add hTuser
     *
     * @param \AppBundle\Entity\TakenHoliday $hTuser
     *
     * @return Holiday
     */
    public function addHTuser(\AppBundle\Entity\TakenHoliday $hTuser)
    {
        $this->h_tusers[] = $hTuser;

        return $this;
    }

    /**
     * Remove hTuser
     *
     * @param \AppBundle\Entity\TakenHoliday $hTuser
     */
    public function removeHTuser(\AppBundle\Entity\TakenHoliday $hTuser)
    {
        $this->h_tusers->removeElement($hTuser);
    }

    /**
     * Get hTusers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHTusers()
    {
        return $this->h_tusers;
    }
}
