<?php

namespace StemsPageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends BaseFrontFrontControllerTest
{
	protected $client;

	public function __construct() 
	{
		$this->client = static::createClient();
	}

    public function testHome()
    {
    	// load the page
        $crawler = $this->client->request('GET', '/');

        // check any content loaded
        $this->assertTrue($crawler->filter('.cms-page')->count() > 0);

        // optional test cases based on restful or paginated loading
        if ($this->assertTrue($crawler->filter('.rest-load-more')->count() > 0)) {

        }
    }

    public function testRedirect()
    {
    	// load the page for the first ever blog post
        $crawler = $this->client->request('GET', '/magazine/the-wedding-guest-edit');

        // check any content loaded
        $this->assertTrue($crawler->filter('.cms-page')->count() > 0);
    }

    public function testPage()
    {
        // try to load the about page
        $crawler = $this->client->request('GET', '/about');

        // check any content loaded
        $this->assertTrue($crawler->filter('body')->count() > 0);
    }
}
