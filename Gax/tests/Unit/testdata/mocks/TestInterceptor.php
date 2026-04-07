<?php

namespace Google\ApiCore\Tests\Unit\Transport;

use Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface;
use Grpc\Interceptor;

$useDeprecatedInterceptors = (new \ReflectionClass(Interceptor::class))
    ->getMethod('interceptUnaryUnary')
    ->getParameters()[3]
    ->getName() === 'metadata';

if ($useDeprecatedInterceptors) {
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
} else {
    class TestInterceptor extends Interceptor
    {
        public function interceptUnaryUnary(
            $method,
            $argument,
            $deserialize,
            $continuation,
            array $metadata = [],
            array $options = []
        ) {
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
        ) {
            $options['test-interceptor-insert'] = 'inserted-value';
            return $continuation($method, $argument, $deserialize, $metadata, $options);
        }
    }
}
