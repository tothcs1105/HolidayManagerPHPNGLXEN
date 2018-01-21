<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 2:03 AM
 */

namespace AppBundle\Service\Factory;

use AppBundle\Entity\Holiday;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\IHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\Service\Declaration\IUserService;
use AppBundle\Service\Implementation\AvailableHolidayService;
use AppBundle\Service\Implementation\HolidayService;
use AppBundle\Service\Implementation\TakenHolidayService;
use AppBundle\Service\Implementation\UserService;
use Doctrine\ORM\EntityManager;

class ServiceFactory
{
    /** @var EntityManager  */
    private $entityManager;

    /**
     * ChoiceService constructor.
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return IUserService
     */
    public function getUserService(){
        return new UserService($this->entityManager);
    }

    /**
     * @return ITakenHolidayService
     */
    public function getTakenHolidayService(){
        return new TakenHolidayService($this->entityManager);
    }

    /**
     * @return IAvailableHolidayService
     */
    public function getAvailableHolidayService(){
        return new AvailableHolidayService($this->entityManager);
    }

    /**
     * @return IHolidayService
     */
    public function getHolidayService(){
        return new HolidayService($this->entityManager);
    }
}