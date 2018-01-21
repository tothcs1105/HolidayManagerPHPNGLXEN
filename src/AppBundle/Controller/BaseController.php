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
        $loggedUser = $this->get('session')->get(Constants::USER_VARIABLE_NAME);
        if(!$loggedUser){
            throw $this->createAccessDeniedException();
        }
        return $loggedUser;
    }
}