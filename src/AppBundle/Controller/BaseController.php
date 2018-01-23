<?php
namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
    /**
     * @return string
     */
    protected function checkLogin()
    {
        $loggedUser = $this->get('session')->get(Constants::USER_KEY);
        if(!$loggedUser){
            $this->addFlash(Constants::TWIG_NOTICE, "You have to login!");
            throw $this->createAccessDeniedException();
        }
        return $loggedUser;
    }

    /**
     * @return bool
     */
    protected function checkAdmin(){
        $this->checkLogin();
        $admin = $this->get('session')->get(Constants::ADMIN_USER_KEY);
        if($admin == true){
            return true;
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administrator privileges!");
            return false;
        }
    }
}