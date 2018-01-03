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
     * @param string $userName
     * @return User|object
     */
    public function getUserByUserName($userName)
    {
        return $this->getRepo()->findOneBy(array("u_name"=>$userName));
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
     * @param $userId int
     * @return User|object
     */
    public function getUser($userId)
    {
        return $this->getRepo()->findOneBy(array("u_id"=>$userId));
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
     * @param $userId int
     */
    public function deleteUser($userId)
    {
        $user = $this->getUser($userId);
        $this->em->remove($user);
        $this->em->flush();
    }
}