<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events\GithubNotificationEvent;
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

        $event = new GithubNotificationEvent();
        $event->setGithubEventName($request->getHeaderLine('X-GitHub-Event'));
        $event->setGithubDeliveryId($request->getHeaderLine('X-GitHub-Delivery'));
        $event->setGithubSignature($request->getHeaderLine('X-Hub-Signature'));
        $event->setParams($notification);

        return $event;
    }
}