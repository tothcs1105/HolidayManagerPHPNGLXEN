<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 1:27 AM
 */

namespace AppBundle\DTO;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDTO extends BaseDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $username;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * LoginDTO constructor.
     * @param Request $req
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        parent::__construct($container);
    }

    /**
     * @return string
     */
    public function getUsername()
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
        $builder->add("username", TextType::class, array(
            'required' => true,
            'label' => "Username"
        ));
        $builder->add("password", PasswordType::class, array(
            'required' => true,
            'label' => "Password"
        ));
        $builder->add("Log In", SubmitType::class);

        return $builder->getForm();
    }
}