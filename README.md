# M6WebStatsdRequestHeadersBundle

Symfony Bundle which fetches some HTTP headers from current request and logs them in statsd.

Configured headers on selected routes are automatically logged as increment in desired statsd event.

## Configuration

```yml
m6_web_statsd_request_headers:
    headers: ['X-my-header', 'X-my-other-header']
    routes: ['my-route']
    event: 'my.statsd.event'
 
m6_statsd:
    [...]
    clients:
        default:
            [...]
            events:    
                my.statsd.event:
                    increment: my.statsd.event.<value>

```
You can select every route or every header by setting :
`headers: ['*']`
or
`routes: ['*']`