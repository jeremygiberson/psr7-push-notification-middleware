<?php


namespace Unit\MatchResults;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\NotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;

class MatchResultTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testIsMatchedReturnsConstructedValue()
    {
        $result = new MatchResult(true);
        self::assertTrue($result->isMatched());

        $result2 = new MatchResult(false);
        self::assertFalse($result2->isMatched());
    }

    public function testGetEventReturnsConstructedValue()
    {
        $result = new MatchResult(true, $event = new NotificationEvent('foo'));
        self::assertSame($result->getEvent(), $event);
    }
}
