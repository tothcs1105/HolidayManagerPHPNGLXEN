<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/22/2018
 * Time: 1:35 AM
 */

namespace AppBundle\ViewModel;


class UserHolidayViewModel
{
    /**
     * @var int
     */
    private $holidayId;
    /**
     * @var string
     */
    private $holidayName;
    /**
     * @var string
     */
    private $username;
    /**
     * @var int
     */
    private $year;
    /**
     * @var int
     */
    private $days;

    /**
     * UserHolidayViewModel constructor.
     * @param $holidayId int
     * @param $holidayName string
     * @param $username string
     * @param $year int
     * @param $days int
     */
    function __construct($holidayId, $holidayName, $username, $year, $days)
    {
        $this->holidayId = $holidayId;
        $this->holidayName = $holidayName;
        $this->username = $username;
        $this->year = $year;
        $this->days = $days;
    }

    /**
     * @return int
     */
    public function getHolidayId(): int
    {
        return $this->holidayId;
    }

    /**
     * @param int $holidayId
     */
    public function setHolidayId(int $holidayId)
    {
        $this->holidayId = $holidayId;
    }

    /**
     * @return string
     */
    public function getHolidayName(): string
    {
        return $this->holidayName;
    }

    /**
     * @param string $holidayName
     */
    public function setHolidayName(string $holidayName)
    {
        $this->holidayName = $holidayName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays(int $days)
    {
        $this->days = $days;
    }
}
