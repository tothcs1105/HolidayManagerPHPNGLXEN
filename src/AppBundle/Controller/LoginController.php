<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:59 AM
 */

namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use AppBundle\DTO\LoginDTO;
use AppBundle\DTO\UserDTO;
use AppBundle\Service\Declaration\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends BaseController
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
    public function loginAction(Request $request){
        $loginDto = new LoginDTO($request, $this->container, null);
        $form = $loginDto->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->userService->getUserByUserName($loginDto->getUserName());
            if($user){
                if(sha1($loginDto->getPassword()) == $user->getUPass()){
                        $this->container->set(Constants::USER_VARIABLE_NAME);
                    }
            }
        }
        $params = array();
        $params["form"] = $form->createView();
        return $this->render('login/login.html.twig', $params);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }
}