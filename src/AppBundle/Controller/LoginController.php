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
use AppBundle\Service\Declaration\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginController extends BaseController
{
    /**
     * @var IUserService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $this->get(Constants::USER_SERVICE);
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
                    $this->get('session')->set(Constants::USER_KEY, $user->getUName());
                    if($user->getUAdmin() == true){
                        $this->get('session')->set(Constants::ADMIN_USER_KEY, true);
                    }
                    $this->addFlash(Constants::TWIG_NOTICE, "Logged in successfully!");
                    return $this->redirectToRoute("holidayList");
                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "Wrong password!");
                }
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "Wrong username!");
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
        $this->checkLogin();
        $this->get('session')->clear();
        $this->addFlash(Constants::TWIG_NOTICE, "Logged out successfully!");
        return $this->redirectToRoute("login");
    }
}