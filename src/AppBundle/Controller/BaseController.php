<?php
namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseController extends Controller
{
    protected function checkLogin()
    {
        if($this->container->get(Constants::USER_VARIABLE_NAME)){
            $this->createAccessDeniedException();
        }
    }
}