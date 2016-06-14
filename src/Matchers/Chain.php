<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Psr\Http\Message\RequestInterface;

class Chain implements MatcherInterface
{
    /** @var  MatcherInterface[] */
    private $matchers;

    /**
     * Chain constructor.
     * @param MatcherInterface[] $matchers
     */
    public function __construct(array $matchers = [])
    {
        foreach($matchers as $matcher) {
            $this->add($matcher);
        }
    }

    /**
     * @param MatcherInterface $matcher
     */
    public function add(MatcherInterface $matcher)
    {
        $this->matchers[] = $matcher;
    }



    /**
     * @param RequestInterface $request
     * @return MatchResultInterface
     */
    public function match(RequestInterface $request)
    {
        foreach($this->matchers as $matcher) {
            $match = $matcher->match($request);
            if($match->isMatched()) {
                return $match;
            }
        }

        return new UnmatchedResult();
    }
}