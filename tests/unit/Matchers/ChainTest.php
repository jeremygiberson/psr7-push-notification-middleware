<?php


namespace Unit\Matchers;


use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Matchers\Chain;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\UnmatchedResult;
use Psr\Http\Message\RequestInterface;

class ChainTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Chain */
    private $chain;
    /** @var  MatcherInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $matcher;


    public function setUp()
    {
        parent::setUp();

        $this->chain = new Chain();
        $this->matcher = self::createMock(MatcherInterface::class);
    }

    public function testMatchIteratesMatchers()
    {
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);

        $this->matcher->expects(self::exactly(3))
            ->method('match')
            ->willReturn(new UnmatchedResult());

        $this->chain->add($this->matcher);
        $this->chain->add($this->matcher);
        $this->chain->add($this->matcher);

        $this->chain->match($request);
    }

    public function testMatchReturnsUnmatchedResultWhenThereAreNoMatches()
    {
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);

        $this->matcher->expects(self::exactly(3))
            ->method('match')
            ->willReturn(new UnmatchedResult());

        $this->chain->add($this->matcher);
        $this->chain->add($this->matcher);
        $this->chain->add($this->matcher);

        $result = $this->chain->match($request);
        self::assertInstanceOf(UnmatchedResult::class, $result);
    }

    public function testMatchReturnsSuccessfulMatch()
    {
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);

        $this->matcher->expects(self::once())
            ->method('match')
            ->willReturn($matchResult = new MatchResult(true));

        $this->chain->add($this->matcher);
        $this->chain->add($this->matcher);

        $result = $this->chain->match($request);
        self::assertSame($matchResult, $result);
    }

}
