<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 3:09 AM
 */

namespace AppBundle\Service\Implementation;

use AppBundle\Entity\AvailableHoliday;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use Doctrine\ORM\EntityManager;

class AvailableHolidayService extends CrudService implements IAvailableHolidayService
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    function getRepo()
    {
        return $this->em->getRepository(\AppBundle\Entity\AvailableHoliday::class);
    }

    function getAvailableHolidays()
    {
        return $this->getRepo()->findAll();
    }

    function getAvailableHoliday($username, $holidayId, $year)
    {
        return $this->getRepo()->findOneBy(array("ah_user"=>$username, "ah_holiday"=>$holidayId, "ah_year"=>$year));
    }

    function getAvailableHolidaysByUsername($username)
    {
        return $this->getRepo()->findBy(array("ah_user"=>$username));
    }

    function deleteAvailableHoliday($username, $holidayId, $year)
    {
        $holidayToDelete = $this->getAvailableHoliday($username, $holidayId, $year);
        $this->em->remove($holidayToDelete);
        $this->em->flush();
    }

    function saveAvailableHoliday($availableHoliday)
    {
        $this->em->persist($availableHoliday);
        $this->em->flush();
    }

    function getAvailableHolidaysByHolidayId($holidayId)
    {
        $query = $this->getRepo()->createQueryBuilder('a')
        ->join('a.ah_holiday', 'h')
        ->where('h.h_id = :hid')
        ->setParameter('hid', $holidayId)
        ->getQuery();

        return $query->getResult();
    }

    function getAvailableHolidayByUsernameHolidayIdYear($username, $holidayId, $year)
    {
        $query = $this->getRepo()->createQueryBuilder('a')
            ->where('a.ah_year = :year AND a.ah_user = :user AND a.ah_holiday = :holidayId')
            ->setParameter('year', $year)
            ->setParameter('user', $username)
            ->setParameter('holidayId', $holidayId)
            ->getQuery();

        return $query->getResult();
    }

    function getAvailableHolidaysByUsernameHolidayId($username, $holidayId)
    {
        $query = $this->getRepo()->createQueryBuilder('a')
            ->join('a.ah_holiday', 'h')
            ->where('h.h_id = :hid AND a.ah_user = :username')
            ->setParameter('hid', $holidayId)
            ->setParameter('username', $username)
            ->getQuery();

        return $query->getResult();
    }
}