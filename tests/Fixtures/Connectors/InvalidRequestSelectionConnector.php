<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Connectors;

use Sammyjo20\MissingClass;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Tests\Fixtures\Requests\UserRequest;
use Sammyjo20\Saloon\Tests\Fixtures\Requests\ErrorRequest;

/**
 * @method getMyUser($userId, $groupId): UserRequest
 * @method errorRequest(...$args): UserRequest
 */
class InvalidRequestSelectionConnector extends SaloonConnector
{
    use AcceptsJson;

    /**
     * Manually specify requests that the connector will register as methods
     *
     * @var array|string[]
     */
    protected array $requests = [
        MissingClass::class, // Invalid Class
        TestConnector::class, // Invalid Connector
    ];
    public ?string $apiKey = null;

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

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey;
        //
    }
}
