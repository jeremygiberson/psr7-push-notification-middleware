<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;


trait ImmutableParams
{
    /** @var  array */
    private $__params;

    public function __construct(array $params = [])
    {
        $this->__params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->__params;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public function getParam($name, $default = null)
    {
        return isset($this->__params[$name]) ? $this->__params[$name] : $default;
    }

    /**
     * @param array $params
     * @return self new instance with params replaced
     */
    public function withParams(array $params = [])
    {
        $newInstance = clone $this;
        $newInstance->__params = $params;
        return $newInstance;
    }

    /**
     * @param $name
     * @param $value
     * @return self new instance with additional parameter
     */
    public function withParam($name, $value)
    {
        $newInstance = clone $this;
        $newInstance->__params[$name] = $value;
        return $newInstance;
    }

}