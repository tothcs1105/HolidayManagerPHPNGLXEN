<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 2:07 AM
 */

namespace AppBundle\Service\Implementation;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

abstract class CrudService
{
    /** @var EntityManager  */
    protected $em;

    /**
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->em=$entityManager;
    }

    /**
     * @return EntityRepository
     */
    abstract function getRepo();
}