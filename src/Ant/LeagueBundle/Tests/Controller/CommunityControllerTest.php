<?php

namespace Ant\LeagueBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommunityControllerTest extends WebTestCase
{
    public function testPostcommunitys()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/postCommunitys');
    }

}
