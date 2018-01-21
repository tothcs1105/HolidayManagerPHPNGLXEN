<?php
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 12:42 AM
 */

namespace AppBundle\DataFixture\ORM;

use AppBundle\Entity\AvailableHoliday;
use AppBundle\Entity\Holiday;
use AppBundle\Entity\Role;
use AppBundle\Entity\TakenHoliday;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container=$container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var $manager EntityManager
         */
        $this->em = $manager;
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $stackLogger = new DebugStack();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($stackLogger);

        //roles
        $role1 = new Role();
        $role1->setRName("Normal");

        $role2 = new Role();
        $role2->setRName("Admin");

        $this->em->persist($role1);
        $this->em->persist($role2);

        //users
        $user1 = new User();
        $user1->setUName("Józsi");
        $user1->setUPass(sha1("admin"));
        $user1->setURole($role2);

        $user2 = new User();
        $user2->setUName("Béla");
        $user2->setUPass(sha1("user"));
        $user2->setURole($role1);

        $this->em->persist($user1);
        $this->em->persist($user2);

        //holidays
        $holiday1 = new Holiday();
        $holiday1->setHName("Sick Leave");

        $holiday2 = new Holiday();
        $holiday2->setHName("Annual Leave");

        $holiday3 = new Holiday();
        $holiday3->setHName("Family Responsibility Leave");

        $this->em->persist($holiday1);
        $this->em->persist($holiday2);
        $this->em->persist($holiday3);

        //availableholiday
        $availableHoliday = new AvailableHoliday();
        $availableHoliday->setAhYear(2018);
        $availableHoliday->setAhUser($user1);
        $availableHoliday->setAhDays(10);
        $availableHoliday->setAhHoliday($holiday1);

        $this->em->persist($availableHoliday);

        $availableHoliday2 = new AvailableHoliday();
        $availableHoliday2->setAhYear(2017);
        $availableHoliday2->setAhUser($user1);
        $availableHoliday2->setAhDays(9);
        $availableHoliday2->setAhHoliday($holiday1);

        $this->em->persist($availableHoliday2);

        $availableHoliday3 = new AvailableHoliday();
        $availableHoliday3->setAhYear(2018);
        $availableHoliday3->setAhUser($user1);
        $availableHoliday3->setAhDays(8);
        $availableHoliday3->setAhHoliday($holiday2);

        $this->em->persist($availableHoliday3);

        //takenholidays
        $takenHoliday1 = new TakenHoliday();
        $takenHoliday1->setThHoliday($holiday1);
        $takenHoliday1->setThFrom(new \DateTime('2018-01-01'));
        $takenHoliday1->setThTo(new \DateTime('2018-01-10'));
        $takenHoliday1->setThUser($user1);

        $this->em->persist($takenHoliday1);

        $this->em->flush();

        var_dump(count($stackLogger->queries));
        var_dump(count($this->em->getConnection()->getConfiguration()->getSQLLogger()->queries));
    }
}