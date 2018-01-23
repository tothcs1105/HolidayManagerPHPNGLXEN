<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 8:30 AM
 */

namespace AppBundle\Controller;


use AppBundle\Common\Constants;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\ViewModel\AvailableHolidayViewModel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AvailableHolidayController extends BaseController
{
    /**
     * @var IAvailableHolidayService
     */
    private $availableHolidayService;

    /**
     * @var ITakenHolidayService
     */
    private $takenHolidayService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->availableHolidayService = $this->get(Constants::AVAILABLE_HOLIDAY_SERVICE);
        $this->takenHolidayService = $this->get(Constants::TAKEN_HOLIDAY_SERVICE);
    }

    /**
     * @Route("/availableholidays", name="selectAvailableHoliday")
     */
    public function listAvailableHolidaysAction(Request $request)
    {
        $loggedUser = $this->checkLogin();
        $params = array();
        $availableHolidayEntities = $this->availableHolidayService->getAvailableHolidaysByUserName($loggedUser);
        $params["availableHolidays"] = array();
        if($availableHolidayEntities){
            $availableHolidaysGrouped = array();
            foreach ($availableHolidayEntities as $availableHoliday){
                $holidayType = $availableHoliday->getAhHoliday();
                $takenDays = $this->getTakenHolidayDayCount($loggedUser, $holidayType->getHId(), $availableHoliday->getAhYear());

                if(array_key_exists($holidayType->getHId(), $availableHolidaysGrouped)){
                    /**
                     * @var $tmp AvailableHolidayViewModel
                     */
                    $tmp = $availableHolidaysGrouped[$holidayType->getHId()];
                    $yearDayArray = $tmp->getYearDayDictionary();
                    if(array_key_exists($availableHoliday->getAhYear(), $tmp->getYearDayDictionary())){
                        $total = $yearDayArray[$availableHoliday->getAhYear()]["total"];
                        $total += $availableHoliday->getAhDays();
                        $yearDayArray[$availableHoliday->getAhYear()] = array("total" => $total, "left" => $total-$takenDays);
                    }else{
                        $yearDayArray[$availableHoliday->getAhYear()] = array("total" => $availableHoliday->getAhDays(), "left" => $availableHoliday->getAhDays()-$takenDays);
                    }
                    $tmp->setYearDayDictionary($yearDayArray);
                    $availableHolidaysGrouped[$holidayType->getHId()] = $tmp;
                }else{
                    $leftDays = $availableHoliday->getAhDays()-$takenDays;
                    $availableHolidaysGrouped[$holidayType->getHId()] = new AvailableHolidayViewModel($holidayType->getHName(), $holidayType->getHId(), array($availableHoliday->getAhYear() => array("total"=>$availableHoliday->getAhDays(),"left"=>$leftDays)));
                }
            }
            $params["availableHolidays"] = $availableHolidaysGrouped;
        }
        return $this->render('availableholiday/selectAvailableHoliday.html.twig', $params);
    }

    /**
     * @param $user string
     * @param $holidayId int
     * @param $year int
     * @return int
     */
    private function getTakenHolidayDayCount($user, $holidayId, $year){
        $takenDays = 0;
        $takenHolidayEntities = $this->takenHolidayService->getTakenHolidaysByUser($user);
        foreach ($takenHolidayEntities as $takenHoliday){
            if($takenHoliday->getThHoliday()->getHId() == $holidayId && intval($takenHoliday->getThFrom()->format('Y')) == $year){
                //+1 > closed interval
                $takenDays += $takenHoliday->getThTo()->diff($takenHoliday->getThFrom())->d+1;
            }
        }
        return $takenDays;
    }

}