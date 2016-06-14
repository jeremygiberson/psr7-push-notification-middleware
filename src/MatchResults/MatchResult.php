<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Events\NotificationEvent;
use JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResultInterface;

class MatchResult implements MatchResultInterface
{
    /** @var  bool */
    private $matched;
    /** @var  NotificationEvent */
    private $event;

    /**
     * MatchResult constructor.
     * @param bool $matched
     * @param NotificationEvent|null $event
     */
    public function __construct($matched, NotificationEvent $event = null)
    {
        $this->matched = $matched;
        $this->event = $event;
    }

    /**
     * @return boolean
     */
    public function isMatched()
    {
        return $this->matched;
    }

    /**
     * @return NotificationEvent
     */
    public function getEvent()
    {
        return $this->event;
    }
}