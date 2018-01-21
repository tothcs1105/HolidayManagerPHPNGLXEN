<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 3:36 AM
 */

namespace AppBundle\Service\Declaration;


use AppBundle\Entity\Holiday;

interface IHolidayService
{
    /**
     * @return Holiday[]
     */
    function getHolidays();

    /**
     * @param $holidayId int
     * @return Holiday
     */
    function getHoliday($holidayId);

    /**
     * @param $holidayId int
     */
    function deleteHoliday($holidayId);

    /**
     * @param $holiday Holiday
     */
    function saveHoliday($holiday);
}