<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:06 AM
 */

namespace AppBundle\Service\Declaration;


use AppBundle\Entity\AvailableHoliday;

interface IAvailableHolidayService
{
    /**
     * @return AvailableHoliday[]
     */
    function getAvailableHolidays();

    /**
     * @param $userName string
     * @param $holidayId int
     * @param $year int
     * @return AvailableHoliday
     */
    function getAvailableHoliday($userName, $holidayId, $year);

    /**
     * @param $holidayId int
     * @return AvailableHoliday[]
     */
    function getAvailableHolidaysByHolidayId($holidayId);

    /**
     * @param $userName string
     * @return AvailableHoliday[]
     */
    function getAvailableHolidaysByUserName($userName);

    /**
     * @param $userName string
     * @param $holidayId int
     * @param $year int
     */
    function deleteAvailableHoliday($userName, $holidayId, $year);

    /**
     * @param $availableHoliday AvailableHoliday
     */
    function saveAvailableHoliday($availableHoliday);
}