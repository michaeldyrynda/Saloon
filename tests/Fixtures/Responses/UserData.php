<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Responses;

class UserData
{
    /**
     * @var string
     */
    public string $foo;
    /**
     * CustomResponse constructor.
     * @param string $foo
     */
    public function __construct(
        string $foo
    ) {
        $this->foo = $foo;
        // ..
    }
}
