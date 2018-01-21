<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 1/21/2018
 * Time: 9:35 AM
 */

namespace AppBundle\Service\Implementation;


use AppBundle\Entity\Role;
use AppBundle\Service\Declaration\IRoleService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class RoleService extends CrudService implements IRoleService
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    function getRepo()
    {
        return $this->em->getRepository(Role::class);
    }

    function getRoles()
    {
        return $this->getRepo()->findAll();
    }

    function getRole($roleId)
    {
        return $this->getRepo()->findOneBy("r_id");
    }

    function deleteRole($roleId)
    {
        $role = $this->getRole($roleId);
        $this->em->remove($role);
        $this->em->flush();
    }

    function saveRole($role)
    {
        $this->em->persist($role);
        $this->em->flush();
    }
}