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
     * @param $username string
     * @param $holidayId int
     * @param $year int
     * @return AvailableHoliday
     */
    function getAvailableHoliday($username, $holidayId, $year);

    /**
     * @param $holidayId int
     * @return AvailableHoliday[]
     */
    function getAvailableHolidaysByHolidayId($holidayId);

    /**
     * @param $username string
     * @param $holidayId int
     * @return AvailableHoliday[]
     */
    function getAvailableHolidaysByUsernameHolidayId($username, $holidayId);

    /**
     * @param $username string
     * @return AvailableHoliday[]
     */
    function getAvailableHolidaysByUsername($username);

    /**
     * @param $username string
     * @param $holidayId int
     * @param $year int
     */
    function deleteAvailableHoliday($username, $holidayId, $year);

    /**
     * @param $availableHoliday AvailableHoliday
     */
    function saveAvailableHoliday($availableHoliday);
}