<?php

namespace Sammyjo20\Saloon\Traits\Auth;

use Sammyjo20\Saloon\Exceptions\SaloonInvalidConnectorException;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Exceptions\MissingAuthenticatorException;

trait RequiresDigestAuth
{
    use RequiresAuth;

    /**
     * @throws MissingAuthenticatorException
     * @throws SaloonInvalidConnectorException
     */
    public function bootRequiresDigestAuth(SaloonRequest $request): void
    {
        $this->bootRequiresAuth($request);
    }

    /**
     * Default message.
     *
     * @param SaloonRequest $request
     * @return string
     */
    protected function getRequiresAuthMessage(SaloonRequest $request): string
    {
        return sprintf('The "%s" request requires authentication. Please provide authentication using the `withDigestAuth` method or return a default authenticator in your connector/request.', get_class($request));
    }
}
