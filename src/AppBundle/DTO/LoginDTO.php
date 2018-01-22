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
use Symfony\Component\Validator\Constraints as Assert;

class LoginDTO extends BaseDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $userName;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $password;

    public function __construct($req, $container)
    {
        parent::__construct($req, $container);
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
        $builder->add("userName", TextType::class, array(
            'required' => true,
            'label' => "Username"
        ));
        $builder->add("password", PasswordType::class, array(
            'required' => true,
            'label' => "Password"
        ));
        $builder->add("Login", SubmitType::class);

        return $builder->getForm();
    }
}