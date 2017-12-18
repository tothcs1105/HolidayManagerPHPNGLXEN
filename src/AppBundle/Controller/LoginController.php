<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:59 AM
 */

namespace AppBundle\Controller;

use AppBundle\Service\Declaration\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginController extends Controller
{
    /**
     * @var IUserService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $this->get("app.userservice");
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(){
        $user = array("users" => $this->userService->getUsers());
        return $this->render('login/login.html.twig', $user);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }
}