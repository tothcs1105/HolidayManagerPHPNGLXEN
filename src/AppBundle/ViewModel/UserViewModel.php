<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/22/2018
 * Time: 12:28 AM
 */

namespace AppBundle\ViewModel;


class UserViewModel
{
    /**
     * @var string
     */
    private $username;

    /**
     * UserViewModel constructor.
     * @param $username string
     */
    function __construct($username)
    {
        $this->username = $username;
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
}