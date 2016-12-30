<?php
/**
 * Created by PhpStorm.
 * User: ILYASSE
 * Date: 29/12/2016
 * Time: 20:43
 */

namespace Ilyasse\BlogBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testAbout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');

        $this->assertEquals(1, $crawler->filter('h2:contains("About Us")')->count());
    }
}
