<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:32 AM
 */

namespace AppBundle\ViewModel;


abstract class HolidayViewModelBase
{
    /**
     * @var string
     */
    protected $holidayName;

    /**
     * HolidayViewModelBase constructor.
     * @param $holidayName string
     */
    function __construct($holidayName)
    {
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