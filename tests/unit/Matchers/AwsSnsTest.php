<?php

namespace Unit\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\AwsSnsNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers\AwsSns;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Unit\Factories\RequestStubFactory;

class AwsSnsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testMatchReturnsAMatchedResultForAnAwsSnsNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/aws-sns-notification.txt', $this);

        $matcher = new AwsSns();
        $result = $matcher->match($request);
        self::assertTrue($result->isMatched());
        self::assertInstanceOf(AwsSnsNotificationEvent::class, $result->getEvent());
    }

    /**
     * @depends testMatchReturnsAMatchedResultForAnAwsSnsNotificationRequest
     */
    public function testMatchedEventsParametersHaveBeenMapped()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/aws-sns-notification.txt', $this);

        $matcher = new AwsSns();
        $result = $matcher->match($request);
        /** @var AwsSnsNotificationEvent $event */
        $event = $result->getEvent();
        
        self::assertEquals('Notification', $event->getType());
        self::assertEquals('arn:aws:sns:us-west-2:123456789012:MyTopic', $event->getTopicArn());
        self::assertEquals('2012-04-25T21:49:25.719Z', $event->getTimestamp());
        self::assertEquals('test', $event->getSubject());
        self::assertEquals('da41e39f-ea4d-435a-b922-c6aae3915ebe', $event->getMessageId());
        self::assertEquals('test message', $event->getMessage());
        self::assertEquals('1', $event->getSignatureVersion());
        self::assertEquals('https://sns.us-west-2.amazonaws.com/SimpleNotificationService-f3ecfb7224c7233fe7bb5f59f96de52f.pem', $event->getSigningCertURL());
        self::assertEquals('EXAMPLElDMXvB8r9R83tGoNn0ecwd5UjllzsvSvbItzfaMpN2nk5HVSw7XnOn/49IkxDKz8YrlH2qJXj2iZB0Zo2O71c4qQk1fMUDi3LGpij7RCW7AW9vYYsSqIKRnFS94ilu7NFhUzLiieYr4BKHpdTmdD6c0esKEYBpabxDSc=', $event->getSignature());
        self::assertEquals('https://sns.us-west-2.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:us-west-2:123456789012:MyTopic:2bcfbf39-05c3-41de-beaa-fcfcc21c8f55', $event->getUnsubscribeURL());

    }

    public function testMatchReturnsUnmatchedResultForANonGithubNotificationRequest()
    {
        $request = RequestStubFactory::fromFixture(
            __DIR__ . '/../../fixtures/requests/github-webhook-issues.txt', $this);

        $matcher = new AwsSns();
        $result = $matcher->match($request);
        self::assertInstanceOf(UnmatchedResult::class, $result);
        self::assertFalse($result->isMatched());
        self::assertNull($result->getEvent());
    }
}
