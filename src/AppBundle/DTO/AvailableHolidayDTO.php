<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/20/2018
 * Time: 11:51 PM
 */

namespace AppBundle\DTO;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

class AvailableHolidayDTO extends BaseDTO
{
    /**
     * @var int
     */
    private $year;

    /**
     * @var \DateTime
     * @Assert\Expression(
     *     "this.getFrom() <= this.getTo()",
     *     message="Start date should be less or equal to end date!"
     * )
     * @Assert\Expression(
     *     "this.getFrom().format('Y') == this.getYear()",
     *     message="From date year is not valid!"
     * )
     */
    private $from;

    /**
     * @var \DateTime
     * @Assert\Expression(
     *     "this.getTo() >= this.getFrom()",
     *     message="End date should be greater or equal to start date!"
     * )
     * @Assert\Expression(
     *     "this.getTo().format('Y') == this.getYear()",
     *     message="To date year is not valid!"
     * )
     */
    private $to;

    /**
     * @return \DateTime
     */
    public function getFrom(): \DateTime
    {
        return $this->from;
    }

    /**
     * @param \DateTime $from
     */
    public function setFrom(\DateTime $from)
    {
        $this->from = $from;
    }

    /**
     * @return \DateTime
     */
    public function getTo(): \DateTime
    {
        return $this->to;
    }

    /**
     * @param \DateTime $to
     */
    public function setTo(\DateTime $to)
    {
        $this->to = $to;
    }

    public function __construct($req, $container, $year)
    {
        parent::__construct($req, $container);
        $this->year = $year;
        $this->from = new \DateTime();
        $this->from->setDate($year, 1, 1);
        $this->to = new \DateTime($year);
        $this->to->setDate($year,1,1);
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);

        $builder->add('year', TextType::class, array(
            'disabled' => true
        ));

        $builder->add("from", DateType::class, array(
            'widget' => 'single_text',
            'placeholder' => 'Select a date',
        ));

        $builder->add("to", DateType::class, array(
            'widget' =>'single_text',
            'placeholder' => 'Select a date',
        ));

        $builder->add('Take', SubmitType::class);

        return $builder->getForm();
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }
}