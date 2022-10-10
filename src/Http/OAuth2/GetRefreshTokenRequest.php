<?php

namespace Sammyjo20\Saloon\Http\OAuth2;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Helpers\OAuth2\OAuthConfig;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasFormParams;

class GetRefreshTokenRequest extends SaloonRequest
{
    use HasFormParams;
    use AcceptsJson;

    protected OAuthConfig $oauthConfig;
    protected string $refreshToken;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::POST;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return $this->oauthConfig->getTokenEndpoint();
    }

    /**
     * Requires the authorization code and OAuth 2 config.
     *
     * @param OAuthConfig $oauthConfig
     * @param string $refreshToken
     */
    public function __construct(OAuthConfig $oauthConfig, string $refreshToken)
    {
        $this->oauthConfig = $oauthConfig;
        $this->refreshToken = $refreshToken;
    }

    /**
     * Register the default data.
     *
     * @return array
     */
    public function defaultData(): array
    {
        return [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->oauthConfig->getClientId(),
            'client_secret' => $this->oauthConfig->getClientSecret(),
        ];
    }
}
