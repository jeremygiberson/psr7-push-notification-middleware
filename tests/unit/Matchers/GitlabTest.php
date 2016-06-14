<?php

namespace Unit\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\GitlabNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers\Gitlab;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Unit\Factories\RequestStubFactory;

class GitlabTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testMatchReturnsAMatchedResultForAGitlabNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/gitlab-webhook-push.txt', $this);

        $matcher = new Gitlab();
        $result = $matcher->match($request);
        self::assertTrue($result->isMatched());
        self::assertInstanceOf(GitlabNotificationEvent::class, $result->getEvent());
    }

    /**
     * @depends testMatchReturnsAMatchedResultForAGitlabNotificationRequest
     */
    public function testMatchedEventsParametersHaveBeenMapped()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/gitlab-webhook-push.txt', $this);

        $matcher = new Gitlab();
        $result = $matcher->match($request);
        /** @var GitlabNotificationEvent $event */
        $event = $result->getEvent();

        self::assertEquals('Push Hook', $event->getGitlabEventName());
        self::assertEquals('push', $event->getObjectKind());

        $body = $event->getParams();
        self::assertArrayHasKey('before', $body);
        self::assertArrayHasKey('after', $body);
        self::assertArrayHasKey('ref', $body);
        self::assertArrayHasKey('checkout_sha', $body);
        self::assertArrayHasKey('user_id', $body);
        self::assertArrayHasKey('user_name', $body);
        self::assertArrayHasKey('user_email', $body);
        self::assertArrayHasKey('user_avatar', $body);
        self::assertArrayHasKey('project_id', $body);
        self::assertArrayHasKey('project', $body);
        self::assertArrayHasKey('repository', $body);
        self::assertArrayHasKey('commits', $body);
        self::assertArrayHasKey('commits', $body);
        self::assertArrayHasKey('total_commits_count', $body);


    }

    public function testMatchReturnsUnmatchedResultForANonGithubNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/github-webhook-issues.txt', $this);

        $matcher = new Gitlab();
        $result = $matcher->match($request);
        self::assertInstanceOf(UnmatchedResult::class, $result);
        self::assertFalse($result->isMatched());
        self::assertNull($result->getEvent());
    }
}
