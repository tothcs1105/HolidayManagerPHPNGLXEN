<?php
namespace AppBundle\DTO;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseDTO
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var FormFactory
     */
    protected $formFactory;

    public function __construct($req, $container, $em)
    {
        $this->request=$req;
        $this->em=$em;
        $this->container=$container;
        $this->formFactory=$this->container->get("form.factory");
    }

    /**
     * @return FormInterface
     */
    public abstract function getForm();
}