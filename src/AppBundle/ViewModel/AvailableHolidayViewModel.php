<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:32 AM
 */

namespace AppBundle\ViewModel;


class AvailableHolidayViewModel extends HolidayViewModel
{
    /**
     * @var array
     */
    private $yearDayDictionary;

    /**
     * AvailableHolidayViewModel constructor.
     * @param string $holidayName
     * @param $holidayId int
     * @param $yearDayDictionary array
     */
    function __construct($holidayName, $holidayId, $yearDayDictionary)
    {
        parent::__construct($holidayName);
        $this->holidayId = $holidayId;
        $this->yearDayDictionary = $yearDayDictionary;
    }

    /**
     * @return array
     */
    public function getYearDayDictionary(): array
    {
        return $this->yearDayDictionary;
    }

    /**
     * @param array $yearDayDictionary
     */
    public function setYearDayDictionary(array $yearDayDictionary)
    {
        $this->yearDayDictionary = $yearDayDictionary;
    }
}