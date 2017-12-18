<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 2:03 AM
 */

namespace AppBundle\Service\Factory;


use AppBundle\Service\Declaration\IUserService;
use AppBundle\Service\Implementation\UserService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

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
}