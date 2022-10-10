<?php

namespace Sammyjo20\Saloon\Tests\Fixtures\Connectors;

use Carbon\CarbonInterface;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Helpers\OAuth2\OAuthConfig;
use Sammyjo20\Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Sammyjo20\Saloon\Interfaces\OAuthAuthenticatorInterface;
use Sammyjo20\Saloon\Tests\Fixtures\Authenticators\CustomOAuthAuthenticator;

class CustomResponseOAuth2Connector extends SaloonConnector
{
    use AuthorizationCodeGrant;

    protected string $greeting;

    /**
     * @param string $greeting
     */
    public function __construct(string $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * Define the base URL.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        return 'https://oauth.saloon.dev';
    }

    /**
     * Define default Oauth config.
     *
     * @return OAuthConfig
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId('client-id')
            ->setClientSecret('client-secret')
            ->setRedirectUri('https://my-app.saloon.dev/oauth/redirect');
    }

    /**
     * Define a custom OAuth2 authenticator.
     *
     * @param string $accessToken
     * @param string $refreshToken
     * @param CarbonInterface $expiresAt
     * @return OAuthAuthenticatorInterface
     */
    protected function createOAuthAuthenticator(string $accessToken, string $refreshToken, CarbonInterface $expiresAt): OAuthAuthenticatorInterface
    {
        return new CustomOAuthAuthenticator($accessToken, $refreshToken, $expiresAt, $this->greeting);
    }
}
