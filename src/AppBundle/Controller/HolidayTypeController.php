<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 7:09 PM
 */

namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use AppBundle\DTO\HolidayDTO;
use AppBundle\Entity\Holiday;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\IHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\ViewModel\HolidayViewModel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HolidayTypeController extends BaseController
{
    /**
     * @var IHolidayService
     */
    private $holidayService;

    /**
     * @var ITakenHolidayService
     */
    private $takenHolidayService;

    /**
     * @var IAvailableHolidayService
     */
    private $availableHolidayService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->holidayService = $this->get(Constants::HOLIDAY_SERVICE);
        $this->takenHolidayService = $this->get(Constants::TAKEN_HOLIDAY_SERVICE);
        $this->availableHolidayService = $this->get(Constants::AVAILABLE_HOLIDAY_SERVICE);
    }

    /**
     * @Route("/holidayTypes", name="holidayTypes")
     */
    public function listHolidayTypesAction(Request $request){
        if($this->checkAdmin()){
            $params = array();
            $params["holidayTypes"] = array();
            $holidayTypeEntities = $this->holidayService->getHolidays();
            foreach ($holidayTypeEntities as $holidayType){
                $holidayViewModelTmp = new HolidayViewModel($holidayType->getHId(), $holidayType->getHName());
                array_push($params["holidayTypes"], $holidayViewModelTmp);
            }
            return $this->render( 'holidaytype/holidayTypeList.html.twig', $params);
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @param Request $request
     * @Route("/addHoliday", name="addHolidayType")
     * @Route("/updateHoliday/{id}", name="updateHolidayType")
     */
    public function addUpdateHolidayTypeAction(Request $request, $id = null){
        if($this->checkAdmin()){
            $holidayDto = null;
            if($id){
                $holiday = $this->holidayService->getHoliday($id);
                if($holiday){
                    $holidayDto = new HolidayDTO($request, $this->container, $holiday->getHName());
                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "There is no such holiday type!");
                    return $this->redirectToRoute("takenHolidayList");
                }
            }else{
                $holidayDto = new HolidayDTO($request, $this->container);
            }
            $params = array();
            $form = $holidayDto->getForm();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $holidayEntity = null;
                if($id){
                    $holidayEntity = $this->holidayService->getHoliday($id);
                }else{
                    $holidayEntity = new Holiday();
                }
                $holidayEntity->setHName($holidayDto->getHolidayName());
                $this->holidayService->saveHoliday($holidayEntity);
                return $this->redirectToRoute("holidayTypes");
            }
            $params["form"] = $form->createView();
            return $this->render("holidaytype/editHolidayType.html.twig", $params);
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @param Request $request
     * @param $id int
     * @Route("/deleteHolidayType/{id}", name="deleteHolidayType")
     */
    public function deleteHolidayTypeAction(Request $request, $id){
        if($this->checkAdmin()){
            $holiday = $this->holidayService->getHoliday($id);
            if($holiday){
                $takenHolidayEntites = $this->takenHolidayService->getTakenHolidaysByHolidayId($id);
                foreach ($takenHolidayEntites as $takenHoliday){
                    $this->takenHolidayService->deleteTakenHoliday($takenHoliday->getThId());
                }
                $availableHolidayEntities = $this->availableHolidayService->getAvailableHolidaysByHolidayId($id);
                foreach ($availableHolidayEntities as $availableHoliday){
                    $this->availableHolidayService->deleteAvailableHoliday($availableHoliday->getAhUser()->getUName(), $availableHoliday->getAhHoliday()->getHId(), $availableHoliday->getAhYear());
                }
                $this->holidayService->deleteHoliday($id);
                $this->addFlash(Constants::TWIG_NOTICE, $holiday->getHName()." holiday successfully deleted!");
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no holiday with this id!");
            }
            return $this->redirectToRoute("holidayTypes");
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }
}