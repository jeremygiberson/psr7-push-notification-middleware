<?php

namespace Unit\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\GithubNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers\Github;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Unit\Factories\RequestStubFactory;

class GithubTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testMatchReturnsAMatchedResultForAGithubNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/github-webhook-issues.txt', $this);

        $matcher = new Github();
        $result = $matcher->match($request);
        self::assertTrue($result->isMatched());
        self::assertInstanceOf(GithubNotificationEvent::class, $result->getEvent());
    }

    /**
     * @depends testMatchReturnsAMatchedResultForAGithubNotificationRequest
     */
    public function testMatchedEventsParametersHaveBeenMapped()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/github-webhook-issues.txt', $this);

        $matcher = new Github();
        $result = $matcher->match($request);
        /** @var GithubNotificationEvent $event */
        $event = $result->getEvent();

        self::assertEquals('issues', $event->getGithubEventName());
        self::assertEquals('72d3162e-cc78-11e3-81ab-4c9367dc0958', $event->getDeliveryId());
        self::assertEquals('45ca7ef1-cc78-11e3-81ab-4c9367dc0958', $event->getSignature());

        $body = $event->getParams();
        self::assertArrayHasKey('action', $body);
        self::assertArrayHasKey('issue', $body);
        self::assertArrayHasKey('repository', $body);
        self::assertArrayHasKey('sender', $body);

    }

    public function testMatchReturnsUnmatchedResultForANonGithubNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/gitlab-webhook-push.txt', $this);

        $matcher = new Github();
        $result = $matcher->match($request);
        self::assertInstanceOf(UnmatchedResult::class, $result);
        self::assertFalse($result->isMatched());
        self::assertNull($result->getEvent());
    }
}
