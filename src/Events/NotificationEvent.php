<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;


use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    use ImmutableParams {
        __construct as parent__construct;
    }

    /** @var  string */
    private $name;

    /**
     * NotificationEvent constructor.
     * @param string $name
     * @param array $params
     */
    public function __construct($name, array $params = [])
    {
        $this->name = $name;
        $this->parent__construct($params);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



}