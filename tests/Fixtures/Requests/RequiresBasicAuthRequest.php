<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Requests;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Auth\RequiresBasicAuth;
use Sammyjo20\Saloon\Tests\Fixtures\Connectors\TestConnector;

class RequiresBasicAuthRequest extends SaloonRequest
{
    use RequiresBasicAuth;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * The connector.
     *
     * @var string|null
     */
    protected ?string $connector = TestConnector::class;
    public ?int $userId = null;
    public ?int $groupId = null;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/user';
    }

    public function __construct(?int $userId = null, ?int $groupId = null)
    {
        $this->userId = $userId;
        $this->groupId = $groupId;
        //
    }
}
