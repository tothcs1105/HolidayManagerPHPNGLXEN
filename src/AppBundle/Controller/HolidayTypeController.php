<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 7:09 PM
 */

namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HolidayTypeController extends BaseController
{
    /**
     * @Route("/holidayTypes", name="holidayTypes")
     */
    public function listHolidayTypesAction(Request $request){
        if($this->checkAdmin()){

        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("holidayList");
        }
    }
}