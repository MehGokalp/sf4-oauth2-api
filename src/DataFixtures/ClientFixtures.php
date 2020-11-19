<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;

final class ClientFixtures extends Fixture
{
    public const DEFAULT_IDENTIFIER = 'client_default_id';
    public const DEFAULT_SECRET = 'client_default_secret';


    public function load(ObjectManager $manager)
    {
        $client = new Client(self::DEFAULT_IDENTIFIER, self::DEFAULT_SECRET);
        $client->setActive(true);
        $client->setGrants(...array_map(static function (string $grant) : Grant {
            return new Grant($grant);
        }, ['password']));

        $manager->persist($client);
        $manager->flush();
    }
}
