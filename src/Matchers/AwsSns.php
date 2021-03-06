<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\AwsSnsNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
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

        $event = (new AwsSnsNotificationEvent())
            ->withType($notification['Type'])
            ->withTopicArn($notification['TopicArn'])
            ->withTimestamp($notification['Timestamp'])
            ->withSubject($notification['Subject'])
            ->withMessageId($notification['MessageId'])
            ->withMessage($notification['Message'])
            ->withSignature($notification['Signature'])
            ->withSignatureVersion($notification['SignatureVersion'])
            ->withSigningCertURL($notification['SigningCertURL'])
            ->withUnsubscribeURL($notification['UnsubscribeURL']);

        return $event;
    }
}