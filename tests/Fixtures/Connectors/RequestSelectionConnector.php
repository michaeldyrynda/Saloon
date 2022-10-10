<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Connectors;

use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Tests\Fixtures\Requests\UserRequest;
use Sammyjo20\Saloon\Tests\Fixtures\Requests\ErrorRequest;

/**
 * @method getMyUser($userId, $groupId): UserRequest
 * @method errorRequest(...$args): UserRequest
 */
class RequestSelectionConnector extends SaloonConnector
{
    use AcceptsJson;

    public ?string $apiKey;

    /**
     * Manually specify requests that the connector will register as methods
     *
     * @var array|string[]
     */
    protected array $requests = [
        'getMyUser' => UserRequest::class,
        ErrorRequest::class,
    ];

    /**
     * Define the base url of the api.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        return apiUrl();
    }

    /**
     * Define the base headers that will be applied in every request.
     *
     * @return string[]
     */
    public function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Get the user from the system.
     *
     * @param ...$args
     * @return SaloonRequest
     * @throws \ReflectionException
     * @throws \Sammyjo20\Saloon\Exceptions\ClassNotFoundException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonInvalidRequestException
     */
    public function getUser(...$args): SaloonRequest
    {
        return $this->forwardCallToRequest(UserRequest::class, $args);
    }

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey;
    }
}
