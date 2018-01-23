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
     * @var bool
     */
    private $admin;

    /**
     * UserViewModel constructor.
     * @param $username string
     */
    function __construct($username, $admin)
    {
        $this->username = $username;
        $this->admin = $admin;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin(bool $admin)
    {
        $this->admin = $admin;
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