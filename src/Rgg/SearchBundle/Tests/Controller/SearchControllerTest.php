<?php

namespace Rgg\SearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class SearchControllerTest extends WebTestCase
{
    private $client = null;
    
    public function setUp()
    {
        $this->client = static::createClient([], [
        	'PHP_AUTH_USER' => 'ssss',
        	'PHP_AUTH_PW'	=> 'ssss',
        	]);
    }

    public function testQuery()
    {
        $this->client->request('GET', '/search/query');
		var_dump($this->client->getResponse());
		die;

		$this->assertTrue($this->client->getResponse()->isSuccessful());
		//get form
		$form = $crawler->selectButton('Search')->form();

		$form->setValues([
			'query' => 'test'
			]);
		$this->client->submit($form);

		$this->assetTrue($this->client->getResponse()->isSuccessful());
    }
}