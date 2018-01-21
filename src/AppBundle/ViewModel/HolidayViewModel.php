<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:32 AM
 */

namespace AppBundle\ViewModel;


class HolidayViewModel
{
    /**
     * @var string
     */
    protected $holidayName;

    /**
     * @return int
     */
    public function getHolidayId(): int
    {
        return $this->holidayId;
    }

    /**
     * @param int $holidayId
     */
    public function setHolidayId(int $holidayId)
    {
        $this->holidayId = $holidayId;
    }

    /**
     * @var int
     */
    protected $holidayId;

    /**
     * @param $holidayId int
     * @param $holidayName string
     */
    function __construct($holidayId, $holidayName)
    {
        $this->holidayId = $holidayId;
        $this->holidayName = $holidayName;
    }

    /**
     * @return string
     */
    public function getHolidayName(): string
    {
        return $this->holidayName;
    }

    /**
     * @param string $holidayName
     */
    public function setHolidayName(string $holidayName)
    {
        $this->holidayName = $holidayName;
    }
}