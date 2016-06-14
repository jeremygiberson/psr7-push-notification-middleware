<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;

/**
 * Class GitlabNotificationEvent
 * Event params will match the json content of the push event
 * TODO extract into an extension and specific events for each gitlab event type
 */
class GitlabNotificationEvent extends NotificationEvent
{
    const EVENT_NAME = 'gitlab-notification';

    public function __construct()
    {
        parent::__construct(self::EVENT_NAME, []);
    }

    /**
     * @return mixed
     */
    public function getGitlabEventName()
    {
        return $this->gitlabEventName;
    }

    /**
     * @param mixed $gitlabEventName
     */
    public function setGitlabEventName($gitlabEventName)
    {
        $this->gitlabEventName = $gitlabEventName;
    }

    /**
     * @return mixed
     */
    public function getObjectKind()
    {
        return $this->objectKind;
    }

    /**
     * @param mixed $objectKind
     */
    public function setObjectKind($objectKind)
    {
        $this->objectKind = $objectKind;
    }



}