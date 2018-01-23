<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 11:18 PM
 */

namespace AppBundle\Controller;


use AppBundle\Common\Constants;
use AppBundle\DTO\NewHolidayDTO;
use AppBundle\Entity\AvailableHoliday;
use AppBundle\Entity\TakenHoliday;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\IHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\Service\Declaration\IUserService;
use AppBundle\ViewModel\AvailableHolidayViewModel;
use AppBundle\ViewModel\HolidayViewModel;
use AppBundle\ViewModel\UserHolidayViewModel;
use AppBundle\ViewModel\UserViewModel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends BaseController
{
    /**
     * @var IUserService
     */
    private $userService;

    /**
     * @var IAvailableHolidayService
     */
    private $availableHolidayService;

    /**
     * @var ITakenHolidayService
     */
    private $takenHolidayService;

    /**
     * @var IHolidayService
     */
    private $holidayService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $this->get(Constants::USER_SERVICE);
        $this->availableHolidayService = $this->get(Constants::AVAILABLE_HOLIDAY_SERVICE);
        $this->takenHolidayService = $this->get(Constants::TAKEN_HOLIDAY_SERVICE);
        $this->holidayService = $this->get(Constants::HOLIDAY_SERVICE);
    }

    /**
     * @Route("/listusers", name="listUsers")
     */
    public function listUsersAction(Request $request){
        if($this->checkAdmin()){
            $params = array();
            $userEntities = $this->userService->getUsers();
            $params["users"] = array();
            if($userEntities){
                foreach ($userEntities as $userEntity){
                    $userTmp = new UserViewModel($userEntity->getUName(), $userEntity->getUAdmin());
                    array_push($params['users'], $userTmp);
                }
            }
            return $this->render("user/listUsers.html.twig", $params);
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @Route("/listavailableholidays/{username}", name="listUserHolidays")
     * @param $username string
     */
    public function listUserHolidaysAction(Request $request, $username){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $params = array();
                $availableHolidayEntities = $this->availableHolidayService->getAvailableHolidaysByUsername($username);
                $params["holidayUser"] = $username;
                $params["userHolidays"] = array();
                if($availableHolidayEntities){
                    foreach ($availableHolidayEntities as $availableHoliday) {
                        $userHolidayTmp = new UserHolidayViewModel($availableHoliday->getAhHoliday()->getHId(),$availableHoliday->getAhHoliday()->getHName(), $user->getUName(), $availableHoliday->getAhYear(), $availableHoliday->getAhDays());
                        array_push($params["userHolidays"], $userHolidayTmp);
                    }
                }
                return $this->render("user/listUserHolidays.html.twig", $params);
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no such user: ".$username."!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @Route("/selectholidayforuser/{username}", name="selectHolidayForUser")
     * @param Request $request
     * @param $username
     */
    public function selectHolidayForUserAction(Request $request, $username){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $params = array();
                $params["holidayUser"] = $user->getUName();
                $holidayTypes = $this->holidayService->getHolidays();
                $params["holidayTypes"] = array();
                if($holidayTypes){
                    foreach ($holidayTypes as $holidayType){
                        $holidayViewModelTmp = new HolidayViewModel($holidayType->getHId(), $holidayType->getHName());
                        array_push($params["holidayTypes"], $holidayViewModelTmp);
                    }
                }
                return $this->render("user/selectHolidayForUser.html.twig", $params);
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no such user: ".$username."!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @Route("/adduserholiday/{username}/{holidayId}", name="addUserHoliday")
     * @param $username string
     * @param $holidayId int
     */
    public function addUserHolidayAction(Request $request, $username, $holidayId){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $holiday = $this->holidayService->getHoliday($holidayId);
                if($holiday){
                    $params = array();
                    $newHolidayDto = new NewHolidayDTO($request, $this->container);
                    $form = $newHolidayDto->getForm();
                    $form->handleRequest($request);
                    if($form->isSubmitted() && $form->isValid()) {
                        $userAvailableHoliday = $this->availableHolidayService->getAvailableHoliday($username, $holidayId, $newHolidayDto->getYear());
                        if ($userAvailableHoliday) {
                            $userAvailableHoliday->setAhDays($userAvailableHoliday->getAhDays() + $newHolidayDto->getDays());
                            $this->availableHolidayService->saveAvailableHoliday($userAvailableHoliday);
                        } else {
                            $newAvailableHoliday = new AvailableHoliday();
                            $newAvailableHoliday->setAhUser($user);
                            $newAvailableHoliday->setAhHoliday($holiday);
                            $newAvailableHoliday->setAhYear($newHolidayDto->getYear());
                            $newAvailableHoliday->setAhDays($newHolidayDto->getDays());
                            $this->availableHolidayService->saveAvailableHoliday($newAvailableHoliday);
                        }
                        $this->addFlash(Constants::TWIG_NOTICE, $newHolidayDto->getDays() . " days " . $holiday->getHName() . " added for " . $username . " in " . $newHolidayDto->getYear());
                        return $this->redirectToRoute("listUserHolidays", array("username" => $username));
                    }
                    $params["holidayName"] = $holiday->getHName();
                    $params["holidayUser"] = $username;
                    $params["form"] = $form->createView();
                    return $this->render("user/addNewHolidayUser.html.twig", $params);
                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "There is no holiday with the given id: ".$holidayId."!");
                    return $this->redirectToRoute("listUserHolidays", array("username"=>$username));
                }
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no such user: ".$username."!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @Route("/updateuserholiday/{username}/{holidayId}/{year}", name="updateUserHoliday")
     * @param Request $request
     * @param $username
     * @param $holidayId
     * @param $year
     */
    public function updateUserHolidayAction(Request $request, $username, $holidayId, $year){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $holiday = $this->holidayService->getHoliday($holidayId);
                if($holiday){
                    $availableHoliday = $this->availableHolidayService->getAvailableHoliday($username, $holidayId, $year);
                    if($availableHoliday){
                        $editHolidayDto = new NewHolidayDTO($request, $this->container, $year);
                        $editHolidayDto->setDays($availableHoliday->getAhDays());
                        $form = $editHolidayDto->getForm();
                        $form->handleRequest($request);
                        if($form->isSubmitted() && $form->isValid()){
                            if($availableHoliday->getAhDays() > $editHolidayDto->getDays()){
                                $this->deleteClosestDaysIntervalTakenHoliday($username, $holidayId, $year, $editHolidayDto->getDays());
                            }
                            $availableHoliday->setAhDays($editHolidayDto->getDays());
                            $this->availableHolidayService->saveAvailableHoliday($availableHoliday);
                            return $this->redirectToRoute("listUserHolidays", array("username"=>$username));
                        }
                        $params = array();
                        $params["holidayUser"] = $username;
                        $params["holidayName"] = $holiday->getHName();
                        $params["form"] = $form->createView();
                        return $this->render("user/addNewHolidayUser.html.twig", $params);
                    }else{
                        $this->addFlash(Constants::TWIG_NOTICE, "There is no available holiday (".$holiday->getHName().") for ".$username." in ".$year."!");
                        return $this->redirectToRoute("listUserHolidays", array("username"=>$username));
                    }
                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "There is no holiday with the given id: ".$holidayId."!");
                    return $this->redirectToRoute("listUserHolidays", array("username"=>$username));
                }
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no such user: ".$username."!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @param $availableDays int
     */
    private function deleteClosestDaysIntervalTakenHoliday($username, $holidayId, $year, $availableDays){
        $takenHolidays = $this->takenHolidayService->getTakenHolidaysByHolidayIdUsername($holidayId, $username);
        if($takenHolidays) {
            $takenDays = 0;
            $takenHolidaysYear = array();
            foreach ($takenHolidays as $takenHoliday) {
                if (intval($takenHoliday->getThFrom()->format('Y')) == $year) {
                    $takenDays += $takenHoliday->getThFrom()->diff($takenHoliday->getThTo())->d+1;
                    array_push($takenHolidaysYear, $takenHoliday);
                }
            }

            while ($takenDays > $availableDays) {
                $takenDays -= $this->deleteClosestDayCountTakenHoliday($takenHolidaysYear, $takenDays - $availableDays);
            }
        }
    }

    /**
     * @param $takenHolidays TakenHoliday[]
     * @param $days int
     * @return int
     */
    private function deleteClosestDayCountTakenHoliday($takenHolidays, $diffDays){
        $daysdeleted = 0;
        $minTakenHoliday = null;
        $minValue = PHP_INT_MAX;
        foreach ($takenHolidays as $takenHoliday){
                $takenDays = $takenHoliday->getThFrom()->diff($takenHoliday->getThTo())->d+1;
                $diff = abs($takenDays - $diffDays);
                if($diff < $minValue){
                    $minValue = $diff;
                    $minTakenHoliday = $takenHoliday;
                    $daysdeleted = $takenDays;
                }
        }
        if($minTakenHoliday){
            $this->takenHolidayService->deleteTakenHoliday($minTakenHoliday->getThId());
        }
        return $daysdeleted;
    }

    /**
     * @Route("/deleteuserholiday/{username}/{holidayId}/{year}", name="deleteUserHoliday")
     * @param Request $request
     * @param $username string
     * @param $holidayId int
     * @param $year int
     */
    public function deleteUserHolidayAction(Request $request, $username, $holidayId, $year){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $takenHolidayEntities = $this->takenHolidayService->getTakenHolidaysByUser($username);
                foreach ($takenHolidayEntities as $takenHoliday){
                    if($takenHoliday->getThHoliday()->getHId() == $holidayId && intval($takenHoliday->getThFrom()->format('Y')) == $year){
                        $this->takenHolidayService->deleteTakenHoliday($takenHoliday->getThId());
                    }
                }
                $availableHolidayEntities = $this->availableHolidayService->getAvailableHolidaysByUsername($username);
                foreach ($availableHolidayEntities as $availableHoliday){
                    if($availableHoliday->getAhHoliday()->getHId() == $holidayId && $availableHoliday->getAhYear() == $year){
                        $this->availableHolidayService->deleteAvailableHoliday($username, $holidayId, $year);
                    }
                }
                $this->addFlash(Constants::TWIG_NOTICE, $username."'s holiday successfully deleted!");
                return $this->redirectToRoute("listUserHolidays", array("username" => $username));
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "There is no such user: ".$username."!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }

    /**
     * @Route("/toggleadminrole/{username}", name="toggleAdminRole")
     * @param Request $request
     * @param string $username
     */
    public function toggleUserAdminRoleAction(Request $request, $username){
        if($this->checkAdmin()){
            $loggedUsername = $this->get('session')->get(Constants::USER_KEY);
            if($loggedUsername != $username){
                $user = $this->userService->getUser($username);
                if($user){
                    $user->setUAdmin(!$user->getUAdmin());
                    $this->userService->saveUser($user);
                    if($user->getUAdmin()){
                        $this->addFlash(Constants::TWIG_NOTICE, $username."'s admin role have been granted!");
                    }else{
                        $this->addFlash(Constants::TWIG_NOTICE, $username."'s admin privileges have been drawn!");
                    }
                    return $this->redirectToRoute("listUsers");
                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "There is no such user in the database!");
                    return $this->redirectToRoute("listUsers");
                }
            }else{
                $this->addFlash(Constants::TWIG_NOTICE, "You can't change your own role!");
                return $this->redirectToRoute("listUsers");
            }
        }else{
            $this->addFlash(Constants::TWIG_NOTICE, "You don't have administration privileges!");
            return $this->redirectToRoute("takenHolidayList");
        }
    }
}