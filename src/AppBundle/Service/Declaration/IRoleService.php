<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 9:33 AM
 */

namespace AppBundle\Service\Declaration;


use AppBundle\Entity\Role;

interface IRoleService
{
    /**
     * @return Role[]
     */
    function getRoles();

    /**
     * @return Role
     * @param $roleId int
     */
    function getRole($roleId);

    /**
     * @param $roleId int
     */
    function deleteRole($roleId);

    /**
     * @param $role Role
     */
    function saveRole($role);
}