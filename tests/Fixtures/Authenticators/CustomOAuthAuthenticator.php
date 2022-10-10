<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Authenticators;

use Carbon\CarbonInterface;
use Sammyjo20\Saloon\Http\Auth\AccessTokenAuthenticator;

class CustomOAuthAuthenticator extends AccessTokenAuthenticator
{
    public string $accessToken;
    public string $refreshToken;
    public CarbonInterface $expiresAt;
    public string $greeting;

    /**
     * @param string $accessToken
     * @param string $refreshToken
     * @param CarbonInterface $expiresAt
     * @param string $greeting
     */
    public function __construct(
        string $accessToken,
        string $refreshToken,
        CarbonInterface $expiresAt,
        string $greeting
    ) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresAt = $expiresAt;
        $this->greeting = $greeting;
    }

    /**
     * @return string
     */
    public function getGreeting(): string
    {
        return $this->greeting;
    }
}
