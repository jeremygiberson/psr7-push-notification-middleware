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

    public function getGitlabEventName()
    {
        return $this->getParam('event_name');
    }

    public function withGitlabEventName($gitlabEventName)
    {
        return $this->withParam('event_name', $gitlabEventName);
    }

    public function getObjectKind()
    {
        return $this->getParam('object_kind');
    }

    public function withObjectKind($objectKind)
    {
        return $this->withParam('object_kind', $objectKind);
    }

}