<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserFixtures extends AbstractFixture
{
    public const DEFAULT_USER_PASS = '123456';
    public const DEFAULT_USER_USERNAME = 'default_user';

    protected UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $defaultUser = $this->createSchema(self::DEFAULT_USER_USERNAME);

        $this->addReference('user_ref_' . 1, $defaultUser);
        $manager->persist($defaultUser);

        for ($i = 1; $i < 100; $i++) {
            $userName = $this->faker->userName;

            $user = $this->createSchema($userName);

            $this->addReference('user_ref_' . ($i + 1), $user);
            $manager->persist($user);
        }

        $manager->flush();
    }

    // Factory method
    private function createSchema(string $userName): User
    {
        $user = new User();

        $user->setUsername($userName);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                self::DEFAULT_USER_PASS
            )
        );

        return $user;
    }
}
