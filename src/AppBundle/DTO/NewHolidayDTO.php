<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/22/2018
 * Time: 6:02 PM
 */

namespace AppBundle\DTO;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class NewHolidayDTO extends BaseDTO
{
    /**
     * @var bool
     */
    private $editing;

    /**
     * @var int
     * @Assert\Expression(
     *     "this.getYear() >= this.getValidMinimumYear()",
     *     message="Selected year should be greater or equal to the current year!"
     * )
     */
    private $year;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     * @Assert\LessThanOrEqual(365)
     */
    private $days;

    public function __construct(ContainerInterface $container, $year = null)
    {
        parent::__construct($container);
        $this->editing = $year != null;
        $this->year = $this->editing ? $year : date('Y');
        $this->days = 0;
    }

    /**
     * @return int
     */
    public function getValidMinimumYear() : int
    {
        return date('Y');
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

    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);

        $builder->add('year', ChoiceType::class, array(
            'choices' => $this->createYearChoices(),
            'choice_label' => function ($value, $key, $index) {
                return $value;
            },
            'disabled' => $this->editing
        ));

        $builder->add('days', NumberType::class, array(
            'required' => true
        ));

        $builder->add('Add', SubmitType::class);

        return $builder->getForm();
    }

    /**
     * @return int []
     */
    private function createYearChoices()
    {
        $result = array();
        $nowYear = date('Y');
        for ($i = $nowYear; $i < $nowYear + 100; $i++){
            array_push($result, $i);
        }
        return $result;
    }
}