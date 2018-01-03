<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:27 AM
 */

namespace AppBundle\DTO;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class LoginDTO extends BaseDTO
{
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $password;

    public function __construct($req, $container, $em)
    {
        parent::__construct($req, $container, $em);
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);
        $builder->add("userName", TextType::class);
        $builder->add("password", PasswordType::class);
        $builder->add("Send", SubmitType::class);

        return $builder->getForm();
    }
}