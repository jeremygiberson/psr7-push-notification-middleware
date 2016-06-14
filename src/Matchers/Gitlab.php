<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\GitlabNotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Psr\Http\Message\RequestInterface;

class Gitlab implements MatcherInterface
{
    /**
     * @param RequestInterface $request
     * @return MatchResultInterface
     */
    public function match(RequestInterface $request)
    {
        if ($request->hasHeader('X-Gitlab-Event')) {
            return new MatchResult(true, $this->getNotificationEvent($request));
        }

        return new UnmatchedResult();
    }

    private function getNotificationEvent(RequestInterface $request)
    {
        $notification = json_decode((string)$request->getBody(), true);

        $event = new GitlabNotificationEvent();
        $event->setGitlabEventName($request->getHeaderLine('X-Gitlab-Event'));
        $event->setObjectKind($notification['object_kind']);
        $event->setParams($notification);

        return $event;
    }
}