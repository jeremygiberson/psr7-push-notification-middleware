<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;


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
     * @param array $params
     */
    public function setParams(array $params = [])
    {
        $this->params = $params;
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

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : null;
    }


}