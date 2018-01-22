<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 2:12 AM
 */

namespace AppBundle\Service\Implementation;


use AppBundle\Entity\User;
use AppBundle\Service\Declaration\IUserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class UserService extends CrudService implements IUserService
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param string $username
     * @return User|object
     */
    public function getUser($username)
    {
        return $this->getRepo()->findOneBy(array("u_name"=>$username));
    }

    /**
     * @return EntityRepository
     */
    function getRepo()
    {
        return $this->em->getRepository(User::class);
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @param $user User
     */
    public function saveUser($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param $username string
     */
    public function deleteUser($username)
    {
        $user = $this->getUser($username);
        $this->em->remove($user);
        $this->em->flush();
    }
}