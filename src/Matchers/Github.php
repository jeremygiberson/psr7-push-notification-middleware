<?php

namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\GithubNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Psr\Http\Message\RequestInterface;

class Github implements MatcherInterface
{
    /**
     * @param RequestInterface $request
     * @return MatchResultInterface
     */
    public function match(RequestInterface $request)
    {
        if ($request->hasHeader('X-GitHub-Event')) {
            return new MatchResult(true, $this->getNotificationEvent($request));
        }

        return new UnmatchedResult();
    }

    private function getNotificationEvent(RequestInterface $request)
    {
        $notification = json_decode((string)$request->getBody(), true);

        $event = (new GithubNotificationEvent())
            ->withParams($notification)
            ->withGithubEventName($request->getHeaderLine('X-GitHub-Event'))
            ->withDeliveryId($request->getHeaderLine('X-Github-Delivery'))
            ->withSignature($request->getHeaderLine('X-Hub-Signature'));

        return $event;
    }
}