<?php

namespace Google\ApiCore\Tests\Unit\Transport;

use Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface;

class TestUnaryInterceptor implements UnaryInterceptorInterface
{
    public function interceptUnaryUnary(
        $method,
        $argument,
        $deserialize,
        array $metadata,
        array $options,
        callable $continuation
    ) {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }
}
