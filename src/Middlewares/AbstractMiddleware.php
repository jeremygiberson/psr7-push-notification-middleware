<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares;

use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class AbstractMiddleware
{
    /** @var  MatcherInterface */
    private $matcher;
    /** @var  EventDispatcher */
    private $dispatcher;

    /**
     * AbstractMiddleware constructor.
     * @param MatcherInterface $matcher
     * @param EventDispatcher $dispatcher
     */
    public function __construct(MatcherInterface $matcher, EventDispatcher $dispatcher)
    {
        $this->matcher = $matcher;
        $this->dispatcher = $dispatcher;
    }


    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $match = $this->matcher->match($request);
        if ($match->isMatched())
        {
            $this->dispatcher->dispatch($match->getEvent()->getName(), $match->getEvent());
            return $response->withStatus(200, 'push notification has been accepted');
        }

        if( ! $next) {
            return $response;
        }

        return $next($request, $response);
    }
}