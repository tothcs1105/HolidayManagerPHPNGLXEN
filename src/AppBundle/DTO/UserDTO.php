<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:33 AM
 */

namespace AppBundle\DTO;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;

class UserDTO extends BaseDTO
{
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $password;
    /**
     * @var integer
     */
    private $roleId;

    public function __construct($req, $container)
    {
        parent::__construct($req, $container);
    }

    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);

        $builder->add("userName", TextType::class);
        $builder->add("password", TextType::class);
        //$builder->add("roleId", ChoiceType::class, array)
        $builder->add("Send", SubmitType::class);

        return $builder->getForm();
    }
}