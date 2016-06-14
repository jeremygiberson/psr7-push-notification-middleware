<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;

/**
 * Class GithubNotificationEvent
 * Event params will match the json content of the push event
 * TODO extract into an extension and specific events for each github event type
 */
class GithubNotificationEvent extends NotificationEvent
{
    const EVENT_NAME = 'github-notification';

    public function __construct()
    {
        parent::__construct(self::EVENT_NAME, []);
    }

    public function getGithubEventName()
    {
        return $this->getParam('event_name');
    }

    public function withGithubEventName($githubEventName)
    {
        return $this->withParam('event_name', $githubEventName);
    }

    public function getSignature()
    {
        return $this->getParam('signature');
    }

    public function withSignature($signature)
    {
        return $this->withParam('signature', $signature);
    }

    public function getDeliveryId()
    {
        return $this->getParam('delivery_id');
    }

    public function withDeliveryId($deliveryId)
    {
        return $this->withParam('delivery_id', $deliveryId);
    }

}