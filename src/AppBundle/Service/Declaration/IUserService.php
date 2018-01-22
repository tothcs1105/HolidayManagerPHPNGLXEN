<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 2:05 AM
 */

namespace AppBundle\Service\Declaration;


use AppBundle\Entity\User;

interface IUserService
{
    /**
     * @return User[]
     */
    public function getUsers();

    /**
     * @param $username string
     * @return User
     */
    public function getUser($username);

    /**
     * @param $user User
     */
    public function saveUser($user);

    /**
     * @param $username string
     */
    public function deleteUser($username);
}