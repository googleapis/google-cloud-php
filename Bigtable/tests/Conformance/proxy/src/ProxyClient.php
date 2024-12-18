<?php

declare(strict_types=1);

use Google\Bigtable\Testproxy\CreateClientRequest;
use Google\Bigtable\Testproxy\CreateClientResponse;

class ProxyClient extends \Grpc\BaseStub
{
    public function CreateClient(CreateClientRequest $message, $metadata = [], $options = [])
    {
        return $this->_simpleRequest(
            '/google.bigtable.testproxy.CloudBigtableV2TestProxy/CreateClient',
            $message,
            [CreateClientResponse::class, 'decode'],
            $metadata,
            $options
        );
    }
}
