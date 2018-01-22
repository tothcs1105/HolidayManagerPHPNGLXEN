<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 11:18 PM
 */

namespace AppBundle\Controller;


use AppBundle\Common\Constants;
use AppBundle\Service\Declaration\IAvailableHolidayService;
use AppBundle\Service\Declaration\IHolidayService;
use AppBundle\Service\Declaration\ITakenHolidayService;
use AppBundle\Service\Declaration\IUserService;
use AppBundle\ViewModel\AvailableHolidayViewModel;
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
     * @Route("/listUsers", name="listUsers")
     */
    public function listUsersAction(Request $request){
        if($this->checkAdmin()){
            $params = array();
            $userEntities = $this->userService->getUsers();
            $params["users"] = array();
            if($userEntities){
                foreach ($userEntities as $userEntity){
                    $userTmp = new UserViewModel($userEntity->getUName());
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
     * @Route("/listHolidays/{username}", name="listUserHolidays")
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
     * @Route("/addUserHoliday/{username}", name="addUserHoliday")
     * @Route("/updateUserHoliday/{username}/{holidayId}/{year}", name="updateUserHoliday")
     * @param $username string
     * @param $holidayId int
     * @param $year int
     */
    public function addUpdateUserHolidayAction(Request $request, $username, $holidayId, $year){
        if($this->checkAdmin()){
            $user = $this->userService->getUser($username);
            if($user){
                $holiday = $this->holidayService->getHoliday($holidayId);
                if($holiday){

                }else{
                    $this->addFlash(Constants::TWIG_NOTICE, "There is no holiday with the given id: ".$holidayId."!");
                    return $this->redirectToRoute("listUsers");
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
     * @Route("/deleteUserHoliday/{username}/{holidayId}/{year}", name="deleteUserHoliday")
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
}