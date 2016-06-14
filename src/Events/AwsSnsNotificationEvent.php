<?php

namespace JeremyGiberson\Psr7\PushNotificationMiddleware\Events;


class AwsSnsNotificationEvent extends NotificationEvent
{
    const EVENT_NAME = 'aws-sns-notification';

    public function __construct()
    {
        parent::__construct(self::EVENT_NAME, []);
    }

    public function getTopicArn()
    {
        return $this->getParam('topic_arm');
    }

    public function withTopicArn($topicArn)
    {
        return $this->withParam('topic_arn', $topicArn);
    }

    public function getTimestamp()
    {
        return $this->getParam('timestamp');
    }

    public function withTimestamp($timestamp)
    {
        return $this->withParam('timestamp', $timestamp);
    }

    public function getType()
    {
        return $this->getParam('type');
    }

    public function withType($type)
    {
        return $this->withParam('type', $type);
    }

    public function getSubject()
    {
        return $this->getParam('subject');
    }

    public function withSubject($subject)
    {
        return $this->withParam('subject', $subject);
    }

    public function getMessageId()
    {
        return $this->getParam('message_id');
    }

    public function withMessageId($messageId)
    {
        return $this->withParam('message_id', $messageId);
    }

    public function getMessage()
    {
        return $this->getParam('message');
    }

    public function withMessage($message)
    {
        return $this->withParam('message',$message);
    }

    public function getSignatureVersion()
    {
        return $this->getParam('signature_version');
    }

    public function withSignatureVersion($signatureVersion)
    {
        return $this->withParam('signature_version', $signatureVersion);
    }

    public function getSignature()
    {
        return $this->getParam('signature');
    }

    public function withSignature($signature)
    {
        return $this->withParam('signature', $signature);
    }

    public function getSigningCertURL()
    {
        return $this->getParam('signing_cert_url');
    }

    public function withSigningCertURL($signingCertURL)
    {
        return $this->withParam('signing_cert_url', $signingCertURL);
    }

    public function getUnsubscribeURL()
    {
        return $this->getParam('unsubscribe_url');
    }

    public function withUnsubscribeURL($unsubscribeURL)
    {
        return $this->withParam('unsubscribe_url', $unsubscribeURL);
    }
}