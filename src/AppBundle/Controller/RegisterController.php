<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 9:12 AM
 */

namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use AppBundle\DTO\RegisterDTO;
use AppBundle\Entity\User;
use AppBundle\Service\Declaration\IRoleService;
use AppBundle\Service\Declaration\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends BaseController
{
    /**
     * @var IUserService
     */
    private $userService;

    /**
     * @var IRoleService
     */
    private $roleService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $this->get(Constants::USER_SERVICE);
        $this->roleService = $this->get(Constants::ROLE_SERVICE);
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request){
        $registerDto = new RegisterDTO($this->container);
        $form = $registerDto->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $alreadyUser = $this->userService->getUser($registerDto->getUsername());
            if($alreadyUser){
                $this->addFlash(Constants::TWIG_NOTICE, "Username already exists!");
            }else{
                $newUser = new User();
                $newUser->setUName($registerDto->getUsername());
                $newUser->setUPass(sha1($registerDto->getPassword()));
                $newUser->setUAdmin(false);
                $this->userService->saveUser($newUser);
                $this->addFlash(Constants::TWIG_NOTICE, "You have registered successfully!");
                return $this->redirectToRoute("login");
            }
        }
        $params = array();
        $params["form"] = $form->createView();
        return $this->render('register/register.html.twig', $params);
    }
}