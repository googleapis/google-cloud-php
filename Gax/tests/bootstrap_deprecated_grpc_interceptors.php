<?php

namespace Google\ApiCore\Tests\Unit\Transport;

use Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface;
use Grpc\Interceptor;

class TestUnaryInterceptor implements UnaryInterceptorInterface
{
    public function interceptUnaryUnary(
        $method,
        $argument,
        $deserialize,
        array $metadata,
        array $options,
        callable $continuation
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }
}

class TestInterceptor extends Interceptor
{
    public function interceptUnaryUnary(
        $method,
        $argument,
        $deserialize,
        array $metadata = [],
        array $options = [],
        $continuation
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }

    public function interceptUnaryStream(
        $method,
        $argument,
        $deserialize,
        array $metadata = [],
        array $options = [],
        $continuation
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }
}