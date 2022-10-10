<?php

namespace Sammyjo20\Saloon\Http\Auth;

use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Interfaces\AuthenticatorInterface;

class TokenAuthenticator implements AuthenticatorInterface
{
    public string $token;
    public string $prefix = 'Bearer';

    /**
     * @param string $token
     * @param string $prefix
     */
    public function __construct(string $token, string $prefix = 'Bearer')
    {
        $this->token = $token;
        $this->prefix = $prefix;
    }

    /**
     * Apply the authentication to the request.
     *
     * @param SaloonRequest $request
     * @return void
     */
    public function set(SaloonRequest $request): void
    {
        $request->addHeader('Authorization', trim($this->prefix . ' ' . $this->token));
    }
}
