<?php

namespace Sammyjo20\Saloon\Clients;

use Illuminate\Support\Str;
use Sammyjo20\Saloon\Exceptions\SaloonInvalidMockResponseCaptureMethodException;
use Sammyjo20\Saloon\Exceptions\SaloonNoMockResponseFoundException;
use Sammyjo20\Saloon\Exceptions\SaloonNoMockResponsesProvidedException;
use Sammyjo20\Saloon\Http\MockResponse;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Http\SaloonRequest;
use ReflectionClass;
use Spatie\Url\Url;

class BaseMockClient
{
    protected array $sequenceResponses = [];

    protected array $connectorResponses = [];

    protected array $requestResponses = [];

    protected array $urlResponses = [];

    protected mixed $callableResponse = null;

    /**
     * @param array $responses
     * @throws SaloonNoMockResponsesProvidedException
     */
    public function __construct(array|callable $mockData = [])
    {
        if (is_callable($mockData)) {
            $this->addCallableResponse($mockData);
            return;
        }

        $this->addResponses($mockData);
    }

    /**
     * Store the mock responses in the correct places.
     *
     * @param array $responses
     * @return void
     * @throws SaloonInvalidMockResponseCaptureMethodException
     */
    private function addResponses(array $responses): void
    {
        foreach ($responses as $key => $response) {
            if (is_int($key)) {
                $key = null;
            }

            $this->addResponse($response, $key);
        }
    }

    private function addResponse(MockResponse $response, ?string $captureMethod = null): void
    {
        if (is_null($captureMethod)) {
            $this->sequenceResponses[] = $response;
            return;
        }

        if (! is_string($captureMethod)) {
            throw new SaloonInvalidMockResponseCaptureMethodException;
        }

        // Let's detect if the capture method is either a connector or
        // a request. If so we'll put them in their designated arrays.

        if ($captureMethod && class_exists($captureMethod)) {
            $reflection = new ReflectionClass($captureMethod);

            if ($reflection->isSubclassOf(SaloonConnector::class)) {
                $this->connectorResponses[$captureMethod] = $response;
                return;
            }

            if ($reflection->isSubclassOf(SaloonRequest::class)) {
                $this->requestResponses[$captureMethod] = $response;
                return;
            }
        }

        // Otherwise, the keys must be a URL.

        $this->urlResponses[$captureMethod] = $response;
    }

    /**
     * Add a callable response
     *
     * @param callable $callable
     * @return $this
     */
    private function addCallableResponse(callable $callable): self
    {
        $this->callableResponse = $callable;

        return $this;
    }

    public function getNextFromSequence(): mixed
    {
        return array_shift($this->sequenceResponses);
    }

    /**
     * Guess the next response based on the request.
     *
     * @param SaloonRequest $request
     * @return MockResponse
     */
    public function guessNextResponse(SaloonRequest $request): MockResponse
    {
        // Check if there is an explicit response for this request
        // Check if there is an explicit response for the request's connector
        // Check if there is a response for the url
        // Otherwise, use the sequence.

        if (is_callable($this->callableResponse)) {
            dd('Process callable');
        }

        $requestClass = get_class($request);

        if (array_key_exists($requestClass, $this->requestResponses)) {
            return $this->requestResponses[$requestClass];
        }

        $connectorClass = get_class($request->getConnector());

        if (array_key_exists($connectorClass, $this->connectorResponses)) {
            return $this->connectorResponses[$connectorClass];
        }

        $guessedUrl = $this->guessUrlResponse($request);

        dd($guessedUrl);

        if (empty($this->sequenceResponses)) {
            throw new SaloonNoMockResponseFoundException;
        }

        return $this->getNextFromSequence();
    }

    private function guessUrlResponse(SaloonRequest $request): ?MockResponse
    {
        dd('guesisgn work', $request->getFullRequestUrl());
    }

    /**
     * Check if the responses are empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->sequenceResponses) && empty($this->connectorResponses) && empty($this->requestResponses) && empty($this->urlResponses) && empty($this->callableResponse);
    }
}
