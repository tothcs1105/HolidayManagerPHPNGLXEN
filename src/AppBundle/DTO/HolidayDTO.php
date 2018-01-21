<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:19 AM
 */

namespace AppBundle\DTO;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class HolidayDTO extends BaseDTO
{
    /**
     * @var string
     */
    private $holidayName;

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

    public function __construct($req, $container, $holidayName = "")
    {
        parent::__construct($req, $container);
        $this->holidayName = $holidayName;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);

        $builder->add("holidayName", TextType::class, array(
            'required' => true,
            'label' => "Name"
        ));
        $builder->add("Ok", SubmitType::class);

        return $builder->getForm();
    }
}
