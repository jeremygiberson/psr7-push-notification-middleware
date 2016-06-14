<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events\AwsSnsNotificationEvent;
use Psr\Http\Message\RequestInterface;

class AwsSns implements MatcherInterface
{

    /**
     * @param RequestInterface $request
     * @return MatchResultInterface
     */
    public function match(RequestInterface $request)
    {
        if ($request->hasHeader('x-amz-sns-message-type')) {
            return new MatchResult(true, $this->getNotificationEvent($request));
        }

        return new UnmatchedResult();
    }

    /**
     * @param RequestInterface $request
     * @return UnmatchedResult|AwsSnsNotificationEvent
     */
    private function getNotificationEvent(RequestInterface $request)
    {
        $notification = json_decode((string)$request->getBody(), true);

        $event = new AwsSnsNotificationEvent();
        $event->setType($notification['Type']);
        $event->setTopicArn($notification['TopicArn']);
        $event->setTimestamp($notification['Timestamp']);
        $event->setSubject($notification['Subject']);
        $event->setMessageId($notification['MessageId']);
        $event->setMessage($notification['Message']);
        $event->setSignature($notification['Signature']);
        $event->setSignatureVersion($notification['SignatureVersion']);
        $event->setSigningCertURL($notification['SigningCertURL']);
        $event->setUnsubscribeURL($notification['UnsubscribeURL']);

        return $event;
    }
}