<?php

namespace AppBundle\ViewModel;

use AppBundle\Common\Constants;

class TakenHolidayViewModel extends HolidayViewModel
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var int
     */
    private $days;

    /**
     * TakenHolidayViewModel constructor.
     * @param $holidayId int
     * @param $holidayName string
     * @param $from \DateTime
     * @param $to \DateTime
     */
    function __construct($holidayId, $holidayName, $from, $to)
    {
        parent::__construct($holidayId, $holidayName);
        $this->from = $from->format(Constants::DATE_FORMAT);
        $this->to = $to->format(Constants::DATE_FORMAT);
        $this->days = $from->diff($to)->d+1;
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

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to)
    {
        $this->to = $to;
    }
}