<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events;

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

    /**
     * @return mixed
     */
    public function getGithubEventName()
    {
        return $this->githubEventName;
    }

    /**
     * @param mixed $githubEventName
     */
    public function setGithubEventName($githubEventName)
    {
        $this->githubEventName = $githubEventName;
    }

    /**
     * @return mixed
     */
    public function getGithubSignature()
    {
        return $this->githubSignature;
    }

    /**
     * @param mixed $githubSignature
     */
    public function setGithubSignature($githubSignature)
    {
        $this->githubSignature = $githubSignature;
    }

    /**
     * @return mixed
     */
    public function getGithubDeliveryId()
    {
        return $this->githubDeliveryId;
    }

    /**
     * @param mixed $githubDeliveryId
     */
    public function setGithubDeliveryId($githubDeliveryId)
    {
        $this->githubDeliveryId = $githubDeliveryId;
    }

}