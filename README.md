# psr7-push-notification-middleware
PSR7 middleware for handling push notifications. Detects push notifications and triggers a push notification event.

The middleware checks to see if it recognizes the incoming HTTP request
as a push notification. If the request is recognized an appropriate event
is dispatched. If the request is not recognized the next middleware is called.

By default when a push notification request is handled the middleware chain 
is terminated. That is, even if the request is pointed to a valid route like
`/do/something/route` or even `/`, that route functionality will not be executed.  

```
request -> push notification middleware
    if request is recognized push notification 
        -> dispatch notification event 
        -> return 200 response
    else 
        -> return $next_middleware(request, response)
```        

## Usage
Ideally, you will add notification event subscribers to the event dispatcher you
factory the middleware with. These listeners will do interesting things when a
push notification arrives.

The default

# Supported Push Notifications
The library provides support for some common services that provide push notifications.

## AWS SNS Notifications
http://docs.aws.amazon.com/sns/latest/dg/SendMessageToHttp.html

## Github Webhook Notifications
https://developer.github.com/webhooks/#events

## Gitlab Webhook Notifications
https://gitlab.com/gitlab-org/gitlab-ce/blob/master/doc/web_hooks/web_hooks.md

## Slack Webhook Notifications [todo]
https://api.slack.com/outgoing-webhooks

## Jenkins Notification Plugin [todo]
https://wiki.jenkins-ci.org/display/JENKINS/Notification+Plugin

## Any Other Notification via Custom Matcher
Write a matcher that implements MatcherInterface and you can support any notification.