<?php

namespace Ilyasse\UserBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Username")')->count()
        );
    }
}
