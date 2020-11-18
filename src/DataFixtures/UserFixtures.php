<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const DEFAULT_USER_PASS = '123456';
    public const DEFAULT_USER_USERNAME = 'default_user';

    protected UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername(self::DEFAULT_USER_USERNAME);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                self::DEFAULT_USER_PASS
            )
        );

        $manager->persist($user);

        $manager->flush();
    }
}
