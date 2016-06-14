<?php


namespace Unit\MatchResults;


use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;

class UnmatchedResultTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testIsMatchedReturnsFalse()
    {
        $result = new UnmatchedResult();
        self::assertFalse($result->isMatched());
    }

    public function testGetEventReturnsNull()
    {
        $result = new UnmatchedResult();
        self::assertNull($result->getEvent());
    }
}
