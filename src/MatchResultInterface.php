<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware;


use JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events\NotificationEvent;

interface MatchResultInterface
{
    /**
     * @return boolean
     */
    public function isMatched();

    /**
     * @return NotificationEvent|null
     */
    public function getEvent();
}