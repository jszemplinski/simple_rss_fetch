<?php

namespace JacekSzemplinski\test;

use JacekSzemplinski\src\services\RSSService;
use PHPUnit\Framework\TestCase;

final class RSSServiceTest extends TestCase
{

    private function getRSSService()
    {
        return new RSSService();
    }

    public function testItGetsDataFromFeedAndStoresItInArray()
    {
        // Instantiate RSS Service.
        $service = $this->getRSSService();

        // Get our data.
        $data = $service->getDataFromFeed("http://feeds.nationalgeographic.com/ng/News/News_Main");

        // Make sure we got something back.
        $this->assertTrue(is_array($data));
    }

    public function testItReturnsNullIfItCannotFindFeed()
    {
        // Instantiate RSS Service.
        $service = $this->getRSSService();

        // Try to get our data from nonexisting url
        $data = $service->getDataFromFeed("193293180");
        $this->assertNull($data);

        // Try to get our data from existing url, but without feed
        $data = $service->getDataFromFeed("https://google.com");
        $this->assertNull($data);
    }

}