<?php

namespace Google\ApiCore\Tests\Unit\Transport;

use Grpc\Interceptor;

class TestInterceptor extends Interceptor
{
    public function interceptUnaryUnary(
        $method,
        $argument,
        $deserialize,
        $continuation,
        array $metadata = [],
        array $options = []
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }

    public function interceptUnaryStream(
        $method,
        $argument,
        $deserialize,
        $continuation,
        array $metadata = [],
        array $options = []
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }
}

class TestUnaryInterceptor extends Interceptor
{
    public function interceptUnaryUnary(
        $method,
        $argument,
        $deserialize,
        $continuation = null,
        array $metadata = [],
        array $options = []
    )
    {
        $options['test-interceptor-insert'] = 'inserted-value';
        return $continuation($method, $argument, $deserialize, $metadata, $options);
    }
}