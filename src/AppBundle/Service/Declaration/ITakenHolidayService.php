<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/15/2018
 * Time: 4:45 PM
 */

namespace AppBundle\Service\Declaration;


use AppBundle\Entity\TakenHoliday;
use AppBundle\Entity\User;

interface ITakenHolidayService
{
    /**
     * @return TakenHoliday[]
     */
    function getTakenHolidays();

    /**
     * @return TakenHoliday
     * @param $takenHolidayId int
     */
    function getTakenHoliday($takenHolidayId);

    /**
     * @param $holidayId int
     * @return TakenHoliday[]
     */
    function getTakenHolidaysByHolidayId($holidayId);

    /**
     * @param $username string
     * @return TakenHoliday[]
     */
    function getTakenHolidaysByUser($username);

    /**
     * @param $takenHolidayId int
     */
    function deleteTakenHoliday($takenHolidayId);

    /**
     * @param $holiday TakenHoliday
     */
    function saveTakenHoliday($holiday);
}