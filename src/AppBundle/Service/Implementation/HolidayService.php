<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 3:38 AM
 */

namespace AppBundle\Service\Implementation;

use AppBundle\Entity\Holiday;
use AppBundle\Service\Declaration\IHolidayService;
use Doctrine\ORM\EntityManager;

class HolidayService extends CrudService implements IHolidayService
{

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    function getRepo()
    {
        return $this->em->getRepository(Holiday::class);
    }

    function getHolidays()
    {
        return $this->getRepo()->findAll();
    }

    function getHoliday($holidayId)
    {
        return $this->getRepo()->findOneBy(array("h_id" => $holidayId));
    }

    function deleteHoliday($holidayId)
    {
        $holiday = $this->getHoliday($holidayId);
        $this->em->remove($holiday);
        $this->em->flush();
    }

    function saveHoliday($holiday)
    {
        $this->em->persist($holiday);
        $this->em->flush();
    }
}