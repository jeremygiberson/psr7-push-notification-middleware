<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Middlewares\Events;


class AwsSnsNotificationEvent extends NotificationEvent
{
    const EVENT_NAME = 'aws-sns-notification';

    public function __construct()
    {
        parent::__construct(self::EVENT_NAME, []);
    }

    /**
     * @return mixed
     */
    public function getTopicArn()
    {
        return $this->topicArn;
    }

    /**
     * @param mixed $topicArn
     */
    public function setTopicArn($topicArn)
    {
        $this->topicArn = $topicArn;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param mixed $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSignatureVersion()
    {
        return $this->signatureVersion;
    }

    /**
     * @param mixed $signatureVersion
     */
    public function setSignatureVersion($signatureVersion)
    {
        $this->signatureVersion = $signatureVersion;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getSigningCertURL()
    {
        return $this->signingCertURL;
    }

    /**
     * @param mixed $signingCertURL
     */
    public function setSigningCertURL($signingCertURL)
    {
        $this->signingCertURL = $signingCertURL;
    }

    /**
     * @return mixed
     */
    public function getUnsubscribeURL()
    {
        return $this->unsubscribeURL;
    }

    /**
     * @param mixed $unsubscribeURL
     */
    public function setUnsubscribeURL($unsubscribeURL)
    {
        $this->unsubscribeURL = $unsubscribeURL;
    }
}