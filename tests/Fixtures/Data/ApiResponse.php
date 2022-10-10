<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Data;

use Sammyjo20\Saloon\Http\SaloonResponse;

class ApiResponse
{
    public array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param SaloonResponse $response
     * @return static
     */
    public static function fromSaloon(SaloonResponse $response): self
    {
        return new static($response->json());
    }
}
