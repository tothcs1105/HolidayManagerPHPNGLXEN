<?php

namespace AppBundle\ViewModel;

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
     * TakenHolidayViewModel constructor.
     * @param $holidayId int
     * @param $holidayName string
     * @param $from string
     * @param $to string
     */
    function __construct($holidayId, $holidayName, $from, $to)
    {
        parent::__construct($holidayName);
        $this->holidayId = $holidayId;
        $this->from = $from;
        $this->to = $to;
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