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
     *     message="From date should be less or equal to to date!"
     * )
     */
    private $from;

    /**
     * @var \DateTime
     * @Assert\Expression(
     *     "this.getTo() >= this.getFrom()",
     *     message="To date should be greater or equal to from date!"
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
        $this->to = new \DateTime();
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