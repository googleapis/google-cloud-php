<?php

namespace Google\Cloud\Spanner\Tests\Unit\GapicBackoff;

use PHPUnit\Framework\TestCase;
use Google\Cloud\Spanner\SpannerClient;

/**
 * @group spanner
 * @group spanner-gapic-backoff
 */
class GapicBackoffTest extends TestCase {

    /**
     * @param array $config
     * @return \Google\Cloud\Core\GrpcRequestWrapper
     */
    private function getWrapper($config)
    {
        $config += [
            'apiEndpoint' => '127.0.0.1:10',
            'hasEmulator' => true,
        ];

        $spanner = new SpannerClient($config);
        $reflection = new \ReflectionObject($spanner);
        $connection = $reflection->getProperty('connection');
        $connection->setAccessible(true);
        $connection = $connection->getValue($spanner);
        return $connection->requestWrapper();
    }

    public function provideDisabledBackoffConfigs()
    {
        return [
            [[]],
            [['useGapicBackoffs' => false]],
        ];
    }

    /**
     * @dataProvider provideDisabledBackoffConfigs
     * @param array $config
     */
    public function testBackoffDisabledByDefault($config)
    {
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]])->options;
        $this->assertTrue(
            array_key_exists('retrySettings', $response) and
            array_key_exists('retriesEnabled', $response['retrySettings']) and
            $response['retrySettings']['retriesEnabled'] === false
        );
    }

    public function testBackoffEnabledManually()
    {
        $config = [
            'useGapicBackoffs' => true,
        ];
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]])->options;
        $this->assertTrue(
            array_key_exists('retrySettings', $response) and
            is_array($response['retrySettings']) and
            empty($response['retrySettings'])
        );
    }
}
