<?php

namespace Sammyjo20\Saloon\Traits;

use Sammyjo20\Saloon\Exceptions\SaloonInvalidConnectorException;
use Sammyjo20\Saloon\Exceptions\SaloonMissingMockException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as GuzzleClient;
use Sammyjo20\Saloon\Http\Middleware\MockMiddleware;
use Sammyjo20\Saloon\Exceptions\SaloonInvalidHandlerException;
use Sammyjo20\Saloon\Exceptions\SaloonDuplicateHandlerException;

trait ManagesGuzzle
{
    /**
     * The list of booted handlers
     *
     * @var array
     */
    private array $bootedHandlers = [];

    /**
     * Create the Guzzle request
     *
     * @return Request
     * @throws SaloonInvalidConnectorException
     */
    public function createGuzzleRequest(): Request
    {
        return new Request($this->request->getMethod(), $this->request->getFullRequestUrl());
    }

    /**
     * Create a new Guzzle client
     *
     * @return GuzzleClient
     * @throws SaloonDuplicateHandlerException
     * @throws SaloonInvalidHandlerException
     * @throws SaloonMissingMockException
     */
    private function createGuzzleClient(): GuzzleClient
    {
        $clientConfig = [
            'connect_timeout' => 10,
            'timeout' => 30,
            'http_errors' => true,
        ];

        $clientConfig['handler'] = $this->bootHandlers(HandlerStack::create());

        return new GuzzleClient($clientConfig);
    }

    /**
     * Boot each of the handlers
     *
     * @param HandlerStack $handlerStack
     * @return HandlerStack
     * @throws SaloonDuplicateHandlerException
     * @throws SaloonInvalidHandlerException
     */
    private function bootHandlers(HandlerStack $handlerStack): HandlerStack
    {
        foreach ($this->getHandlers() as $handler => $handlerClosure) {
            if (empty($handler) || empty($handlerClosure)) {
                continue;
            }

            // Let's make sure the handler isn't already added to the list of handlers
            // if it is - this is bad, so we should throw an exception.

            if (in_array($handler, $this->bootedHandlers, false)) {
                throw new SaloonDuplicateHandlerException($handler);
            }

            // Once that's all good, push the handler onto the stack.

            $handlerStack->push($handlerClosure, $handler);

            // Add the booted handler here, so it can't be loaded again.

            $this->bootedHandlers[] = $handler;
        }

        if ($this->isMocking()) {
            $mockResponse = $this->mockClient->guessNextResponse($this->request);

            $handlerStack->push(new MockMiddleware($mockResponse), 'saloonMockMiddleware');
        }

        return $handlerStack;
    }
}
