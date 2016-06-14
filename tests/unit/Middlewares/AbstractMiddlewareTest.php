<?php


namespace Unit\Middlewares;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\NotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatcherInterface;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults\MatchResult;
use JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class AbstractMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractMiddleware */
    private $middleware;
    /** @var  MatcherInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $matcher;
    /** @var  EventDispatcher|\PHPUnit_Framework_MockObject_MockObject */
    private $dispatcher;

    public function setUp()
    {
        parent::setUp();

        $this->matcher = self::createMock(MatcherInterface::class);

        $this->dispatcher = self::createMock(EventDispatcher::class);

        $this->middleware = new AbstractMiddleware($this->matcher,
            $this->dispatcher);
    }

    public function testMatchedRequestDispatchesEvent()
    {
        $matchResult = new MatchResult(true, $event = new NotificationEvent('my-event'));
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);
        /** @var ResponseInterface $response */
        $response = self::createMock(ResponseInterface::class);

        $this->matcher->expects(self::any())
            ->method('match')
            ->willReturn($matchResult);

        $this->dispatcher->expects(self::once())
            ->method('dispatch')
            ->with($event->getName(), $event);

        $this->middleware->__invoke($request, $response);
    }

    public function testMatchedRequestRespondsWithStatusCode200()
    {
        $matchResult = new MatchResult(true, $event = new NotificationEvent('my-event'));
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);
        /** @var ResponseInterface|\PHPUnit_Framework_MockObject_MockObject $response */
        $response = self::createMock(ResponseInterface::class);

        $response->expects(self::any())
            ->method('withStatus')
            ->with(200, self::anything())
            ->willReturn($response);

        $response->expects(self::any())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->matcher->expects(self::any())
            ->method('match')
            ->willReturn($matchResult);

        $result = $this->middleware->__invoke($request, $response);
        self::assertInstanceOf(ResponseInterface::class, $result);
        self::assertEquals(200, $result->getStatusCode());
    }

    public function testUnmatchedRequestReturnsCallablesResponse()
    {
        $matchResult = new MatchResult(false);
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);
        /** @var ResponseInterface $response */
        $response = self::createMock(ResponseInterface::class);

        $this->matcher->expects(self::any())
            ->method('match')
            ->willReturn($matchResult);

        $callable = self::getMockBuilder('\stdClass')
            ->setMethods(['next'])
            ->getMock();

        $callable->expects(self::once())
            ->method('next')
            ->willReturn($callableResponse = 'foo');

        $result = $this->middleware->__invoke($request, $response, [$callable, 'next']);
        self::assertEquals($callableResponse, $result);
    }

    public function testUnmatchedRequestReturnsResponseIfCallableNotProvided()
    {
        $matchResult = new MatchResult(false);
        /** @var RequestInterface $request */
        $request = self::createMock(RequestInterface::class);
        /** @var ResponseInterface $response */
        $response = self::createMock(ResponseInterface::class);

        $this->matcher->expects(self::any())
            ->method('match')
            ->willReturn($matchResult);

        $result = $this->middleware->__invoke($request, $response);
        self::assertEquals($response, $result);
    }
}
