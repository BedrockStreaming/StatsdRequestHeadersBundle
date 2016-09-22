# M6WebStatsdRequestHeadersBundle

Symfony Bundle which fetches some HTTP headers from current request and logs them in statsd.

Configured headers on selected routes are automatically logged as increment in desired statsd event.

## Configuration

```yml
m6_web_statsd_request_headers:
    headers: ['X-my-header', 'X-my-other-header']
    routes: ['my-route']
    event: 'my.statsd.event'
```

In statsd the event will look like : `my.statsd.event.route.currentroute.header.currentheader`. (With "currentroute" and "currentheader" depending of your request)

You can select every route or every header by setting :
`headers: ['*']`
or
`routes: ['*']`