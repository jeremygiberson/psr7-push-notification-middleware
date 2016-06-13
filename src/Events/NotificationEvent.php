<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events;


use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    /** @var  string */
    private $name;
    /** @var  array */
    private $params;

    /**
     * NotificationEvent constructor.
     * @param string $name
     * @param array $params
     */
    public function __construct($name, array $params = [])
    {
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public function getParam($name, $default = null)
    {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }

}