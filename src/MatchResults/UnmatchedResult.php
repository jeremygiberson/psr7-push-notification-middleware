<?php


namespace JeremyGiberson\Psr7\PushNotificationMiddleware\MatchResults;

class UnmatchedResult extends MatchResult
{
    public function __construct()
    {
        parent::__construct(false);
    }

}