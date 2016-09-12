<?php

namespace M6Web\Bundle\StatsdRequestHeadersBundle\EventListener;

use M6Web\Component\Statsd\Client;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class StatsdRequestHeadersListener listening for kernel.request event.
 *
 * @package M6Web\Bundle\StatsdRequestHeaders\EventListener
 */
class StatsdRequestHeadersListener
{
    /**
     * Statsd event for headers
     *
     * @var string
     */
    protected $eventName;

    /**
     * Statsd
     *
     * @var Client
     */
    protected $statsd;

    /**
     * Accepted headers
     *
     * @var array
     */
    protected $headers;

    /**
     * Accepted routes
     *
     * @var array
     */
    protected $routes;

    /**
     * StatsdRequestHeadersListener constructor.
     *
     * @param Client $statsd
     * @param string $eventName
     * @param array  $headers
     * @param array  $routes
     */
    public function __construct(Client $statsd, $eventName, array $headers, array $routes)
    {
        $this->statsd = $statsd;
        $this->eventName = $eventName;
        $this->headers = $headers;
        $this->routes = $routes;
    }

    /**
     * Called on kernel request
     *
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $headers = $request->headers->all();
        $route   = $request->attributes->get('_route');

        if (!$this->isRouteAccepted($route)) {
            return;
        }

        array_walk($headers, [$this, 'manageHeader']);
    }

    /**
     * Check submitted header & increment statsd if accepted
     *
     * @param $headerValue
     * @param $headerName
     */
    protected function manageHeader($headerValue, $headerName)
    {
        if (!$this->isHeaderAccepted($headerName)) {
            return;
        }

        $this->statsd->increment(sprintf('%s.%s', $this->eventName, $headerName));
    }

    /**
     * Check if header is accepted (case is insensitive)
     * If "*" all headers are accepted
     *
     * @param string $header
     *
     * @return bool
     */
    protected function isHeaderAccepted($header)
    {
        return
            (sizeof($this->headers) === 1 && $this->headers[0] === '*') ||
            preg_grep(sprintf('/%s/i', $header), $this->headers)
        ;
    }

    /**
     * Check if route is accepted
     * If "*" all routes are accepted
     *
     * @param string $currentRoute
     *
     * @return bool
     */
    protected function isRouteAccepted($currentRoute)
    {
        return (sizeof($this->routes) === 1 && $this->routes[0] === '*') || in_array($currentRoute, $this->routes);
    }
}
