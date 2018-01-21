<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:32 AM
 */

namespace AppBundle\ViewModel;


class AvailableHolidayViewModel extends HolidayViewModelBase
{
    /**
     * @var int
     */
    private $holidayId;
    /**
     * @var int
     */
    private $year;
    /**
     * @var int
     */
    private $days;

    function __construct($holidayName, $holidayId, $year, $days)
    {
        parent::__construct($holidayName);
        $this->holidayId = $holidayId;
        $this->year = $year;
        $this->days = $days;
    }

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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days)
    {
        $this->days = $days;
    }
}