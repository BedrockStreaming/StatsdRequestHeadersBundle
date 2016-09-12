<?php

namespace M6Web\Bundle\StatsdRequestHeadersBundle\Tests\Units\EventListener;

use atoum\AtoumBundle\Test\Units;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use M6Web\Bundle\StatsdRequestHeadersBundle\EventListener\StatsdRequestHeadersListener as TestedClass;

/**
 * StatsdREquestHeadersListener test class.
 */
class StatsdRequestHeadersListener extends Units\Test
{
    /**
     * Test onKernelController method.
     *
     * @dataProvider testOnKernelRequestDataProvider
     *
     * @param array $request
     */
    public function testOnKernelRequest(array $request, array $statsdCalls)
    {
        $eventName = 'foo';
        $headers = ['head1', 'head2'];
        $routes = ['route1', 'route2'];

        $this
            ->given(
                $clientMock = $this->getStatsdClientMock(),
                $requestMock = $this->getRequestMock($request),
                $getResponseEventMock = $this->getGetResponseEventMock($requestMock),
                $testedClass = new TestedClass($clientMock, $eventName, $headers, $routes),
                $result = $testedClass->onKernelRequest($getResponseEventMock)
            )
        ;

        foreach($statsdCalls as $call){
            $this
                ->then
                    ->mock($clientMock)
                        ->call('increment')
                            ->withAtLeastArguments($call)
                                ->once()
            ;
        }
    }

    /**
     * Data provider for testOnKernelController() method
     *
     * @return array
     */
    protected function testOnKernelRequestDataProvider()
    {
        return [
            // Good route and 2 good headers
            [
                'request' => [
                    'headers' => [
                        'head1' => 'head1-content',
                        'head2' => 'head2-content',
                        'head3' => 'head3-content',
                    ],
                    'route' => 'route1',
                ],
                'statsdCalls' => [
                    ['foo.head1'],
                    ['foo.head2'],
                ]
            ],
            // Wrong route
            [
                'request' => [
                    'headers' => [
                        'head1' => 'head1-content',
                    ],
                    'route' => 'route3',
                ],
                'statsdCalls' => []
            ]
        ];
    }


    /**
     * @return \M6Web\Component\Statsd\Client
     */
    protected function getStatsdClientMock()
    {
        $this->mockGenerator->orphanize('__construct');
        $this->mockGenerator->shuntParentClassCalls();

        $mock = new \mock\M6Web\Component\Statsd\Client();

        return $mock;
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpKernel\Event\GetResponseEvent
     */
    protected function getGetResponseEventMock($request)
    {
        $this->mockGenerator->orphanize('__construct');
        $this->mockGenerator->shuntParentClassCalls();

        $mock = new \mock\Symfony\Component\HttpKernel\Event\GetResponseEvent();
        $this->calling($mock)->getRequest = $request;

        return $mock;
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequestMock($request)
    {
        $this->mockGenerator->orphanize('__construct');
        $this->mockGenerator->shuntParentClassCalls();

        $mock = new \mock\Symfony\Component\HttpFoundation\Request();
        $mock->headers = new HeaderBag($request['headers']);
        $mock->attributes = new ParameterBag(['_route' => $request['route']]);

        return $mock;
    }
}
