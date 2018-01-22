<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/15/2018
 * Time: 4:45 PM
 */

namespace AppBundle\Service\Implementation;

use AppBundle\Entity\TakenHoliday;
use AppBundle\Service\Declaration\ITakenHolidayService;

class TakenHolidayService extends CrudService implements ITakenHolidayService
{
    function getRepo()
    {
        return $this->em->getRepository(TakenHoliday::class);
    }

    function getTakenHolidays()
    {
        return $this->getRepo()->findAll();
    }

    function getTakenHoliday($takenHolidayId)
    {
        return $this->getRepo()->findOneBy(array("th_id"=>$takenHolidayId));
    }

    function getTakenHolidaysByUser($username)
    {
        return $this->getRepo()->findBy(array("th_user"=>$username));
    }

    function deleteTakenHoliday($takenHolidayId)
    {
        $takenHoliday = $this->getTakenHoliday($takenHolidayId);
        $this->em->remove($takenHoliday);
        $this->em->flush();
    }

    function saveTakenHoliday($holiday)
    {
        $this->em->persist($holiday);
        $this->em->flush();
    }

    function getTakenHolidaysByHolidayId($holidayId)
    {
        $query = $this->getRepo()->createQueryBuilder('t')
            ->join('t.th_holiday', 'h')
            ->where('h.h_id = :hid')
            ->setParameter('hid', $holidayId)
            ->getQuery();

        return $query->getResult();
    }

    function getTakenHolidaysByUserHolidayIdYear($username, $holidayid, $year)
    {
        $query = $this->getRepo()->createQueryBuilder('t')
            ->join('t.th_holiday', 'h')
            ->where('h.h_id = :hid AND t.th_user = :username AND year(t.th_from) = :year')
            ->setParameter('hid', $holidayid)
            ->setParameter('username', $username)
            ->setParameter('year', $year)
            ->getQuery();

        return $query->getArrayResult();
    }
}