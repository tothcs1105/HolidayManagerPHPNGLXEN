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
     * @param $holidayId int
     */
    function getTakenHoliday($holidayId);

    /**
     * @param $user string
     * @return TakenHoliday[]
     */
    function getTakenHolidaysByUser($userName);

    /**
     * @param $holidayId int
     */
    function deleteTakenHoliday($holidayId);

    /**
     * @param $holiday TakenHoliday
     */
    function saveTakenHoliday($holiday);
}