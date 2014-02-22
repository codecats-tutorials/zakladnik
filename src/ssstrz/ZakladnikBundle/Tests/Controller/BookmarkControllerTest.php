<?php

namespace ssstrz\ZakladnikBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookmarkControllerTest extends WebTestCase
{
    public function testMy()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/my');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove');
    }

    public function testSuggestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/suggestion');
    }

}
