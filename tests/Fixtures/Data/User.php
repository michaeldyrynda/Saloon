<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Data;

use Sammyjo20\Saloon\Http\SaloonResponse;

class User
{
    public string $name;
    public string $actualName;
    public string $twitter;

    /**
     * @param string $name
     * @param string $actualName
     * @param string $twitter
     */
    public function __construct(string $name, string $actualName, string $twitter)
    {
        $this->name = $name;
        $this->actualName = $actualName;
        $this->twitter = $twitter;
    }

    /**
     * @param SaloonResponse $response
     * @return static
     */
    public static function fromSaloon(SaloonResponse $response): self
    {
        $data = $response->json();

        return new static($data['name'], $data['actual_name'], $data['twitter']);
    }
}
