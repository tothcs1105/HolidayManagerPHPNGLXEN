<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 9:16 AM
 */

namespace AppBundle\DTO;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDTO extends BaseDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 50,
     *      minMessage = "Username must be at least {{ limit }} characters long",
     *      maxMessage = "Username cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern = "/^\S+$/i",
     *     message = "Username contains illegal character(s)"
     * )
     */
    private $username;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 50,
     *      minMessage = "Password must be at least {{ limit }} characters long",
     *      maxMessage = "Password cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern = "/^\S+$/i",
     *     message = "Username contains illegal character(s)"
     * )
     */
    private $password;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->username = "";
        $this->password = "";
    }

    public function getForm()
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);

        $builder->add("username", TextType::class, array(
            'required' => true,
            'label' => "Username"
        ));

        $builder->add("password", RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'The password field must match.',
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Password Again'),
        ));

        $builder->add("Register", SubmitType::class);

        return $builder->getForm();
    }

    /**
     * @return string
     */
    public function getUsername(): string
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
    public function getPassword(): string
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
}