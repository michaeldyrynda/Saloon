<?php

namespace Sammyjo20\Saloon\Traits\Plugins;

use Sammyjo20\Saloon\Exceptions\SaloonInvalidConnectorException;
use Sammyjo20\Saloon\Http\SaloonRequest;

trait HasJsonBody
{
    /**
     * @param SaloonRequest $request
     * @return void
     * @throws SaloonInvalidConnectorException
     */
    public function bootHasJsonBody(SaloonRequest $request): void
    {
        $this->addConfig('json', $this->getData());
    }

    /**
     * Check if the connector has a trait
     *
     * @return bool
     * @throws SaloonInvalidConnectorException
     */
    protected function connectorHasDataTrait(): bool
    {
        return $this->traitExistsOnConnector(HasJsonBody::class);
    }
}
