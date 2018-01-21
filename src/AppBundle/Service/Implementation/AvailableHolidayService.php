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

    function getAvailableHoliday($userName, $holidayId, $year)
    {
        return $this->getRepo()->findOneBy(array("ah_user"=>$userName, "ah_holiday"=>$holidayId, "ah_year"=>$year));
    }

    function getAvailableHolidaysByUserName($userName)
    {
        return $this->getRepo()->findBy(array("ah_user"=>$userName));
    }

    function deleteAvailableHoliday($userName, $holidayId, $year)
    {
        $holidayToDelete = $this->getAvailableHoliday($userName, $holidayId, $year);
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
}