<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware;


use Psr\Http\Message\RequestInterface;

interface MatcherInterface
{
    /**
     * @param RequestInterface $request
     * @return MatchResultInterface
     */
    public function match(RequestInterface $request);

}