<?php

namespace AppBundle\Controller;

use AppBundle\Common\Constants;
use AppBundle\DTO\AvailableHolidayDTO;
use AppBundle\Entity\Holiday;
use AppBundle\Entity\TakenHoliday;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\IHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\Service\Declaration\IUserService;
use AppBundle\ViewModel\AvailableHolidayViewModel;
use AppBundle\ViewModel\TakenHolidayViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class TakenHolidayController extends BaseController
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

    /**
     * @var IUserService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->takenHolidayService = $this->get(Constants::TAKEN_HOLIDAY_SERVICE);
        $this->availableHolidayService = $this->get(Constants::AVAILABLE_HOLIDAY_SERVICE);
        $this->holidayService = $this->get(Constants::HOLIDAY_SERVICE);
        $this->userService = $this->get(Constants::USER_SERVICE);
    }

    /**
     * @Route("/", name="takenHolidayList")
     */
    public function listTakenHolidaysAction(Request $request){
        $loggedUser = $this->checkLogin();
        $params = array();
        $takenHolidayEntities = $this->takenHolidayService->getTakenHolidaysByUser($loggedUser);
        $params["takenHolidays"] = array();
        if($takenHolidayEntities){
            foreach ($takenHolidayEntities as $takenHoliday){
                /**
                 * @var Holiday
                 */
                $holidaytmp = $takenHoliday->getThHoliday();
                $thtmp = new TakenHolidayViewModel($takenHoliday->getThId(), $holidaytmp->getHName(), $takenHoliday->getThFrom(), $takenHoliday->getThTo());
                array_push($params["takenHolidays"], $thtmp);
            }
        }
        return $this->render('takenholiday/listTakenHolidays.html.twig', $params);
    }

    /**
     * @Route("/takenewholiday/{id}/{year}", name="takeHoliday")
     * @param $id int
     * @param $year int
     */
    public function takeAvailableHoliday(Request $request, $id, $year)
    {
        $loggedUser = $this->checkLogin();
        $holiday = $this->holidayService->getHoliday($id);
        if (!$holiday) {
            throw $this->createNotFoundException('The holiday does not exists!');
        }
        $holidayName = $holiday->getHName();
        $availableHolidayDto = new AvailableHolidayDTO($this->container, $year);
        $form = $availableHolidayDto->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $message = null;
            if($this->checkIfUserRequestIsValid($loggedUser, $id, $year, $availableHolidayDto->getFrom(), $availableHolidayDto->getTo(), $message)) {
                $user = $this->userService->getUser($loggedUser);
                $holiday = $this->holidayService->getHoliday($id);

                $newTakenHoliday = new TakenHoliday();
                $newTakenHoliday->setThUser($user);
                $newTakenHoliday->setThHoliday($holiday);
                $newTakenHoliday->setThFrom($availableHolidayDto->getFrom());
                $newTakenHoliday->setThTo($availableHolidayDto->getTo());

                $this->takenHolidayService->saveTakenHoliday($newTakenHoliday);
                return $this->redirectToRoute("takenHolidayList");
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, $message);
            }
        }

        $params = array();
        $params[Constants::FORM_PARAM_VALUE] = $form->createView();
        $params["holidayName"] = $holidayName;
        return $this->render('takenholiday/takeHoliday.html.twig', $params);
    }

    /**
     * @param $username string
     * @param $holidayId int
     * @param $from \DateTime
     * @param $to \DateTime
     * @param $message string
     * @return bool
     */
    private function checkIfUserRequestIsValid($username, $holidayId, $year, $from, $to, &$message){
        $takenHolidays = $this->takenHolidayService->getTakenHolidaysByHolidayIdUsername($holidayId, $username);
        $availableHolidays = $this->availableHolidayService->getAvailableHolidaysByUsernameHolidayId($username, $holidayId);

        $fromYear = intval($from->format('Y'));
        $toYear = intval($from->format('Y'));

        if($fromYear != $toYear) {
            $message = "From date and to date should be in the same year!";
            return false;
        }

        $takenDays = 0;
        $overlap = false;
        foreach ($takenHolidays as $takenHoliday){
            if(intval($takenHoliday->getThFrom()->format('Y')) == $year){
                $overlap = $this->takenHolidayService->isFromToDateOverlaps($username, $holidayId, $from, $to);
                $days = $takenHoliday->getThTo()->diff($takenHoliday->getThFrom())->d+1;
                $takenDays += $days;
            }
        }

        if($overlap){
            $message = "The given interval conflicts with another one in the database!";
            return false;
        }

        $newDays = $to->diff($from)->d+1;
        $takenDays += $newDays;

        $availableHolidayDays = 0;
        foreach ($availableHolidays as $availableHoliday){
            if($availableHoliday->getAhYear() == $year){
                $availableHolidayDays += $availableHoliday->getAhDays();
            }
        }
        if($availableHolidayDays < $takenDays) {
            $message = "You do not have enough available holidays!";
            return false;
        }
        return true;
    }

    /**
     * @Route("/removeholiday/{id}", name="deleteTakenHoliday")
     * @param $id int
     */
    public function deleteTakenHolidayAction(Request $request, $id){
        $loggedUser = $this->checkLogin();
        $params = array();
        $this->takenHolidayService->deleteTakenHoliday($id);
        $this->addFlash(Constants::TWIG_NOTICE, "Taken holiday removed successfully!");
        return $this->redirectToRoute("takenHolidayList");
    }
}