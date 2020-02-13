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
        $connection = $spanner->instance('nonexistent')->database('nonexistent')->connection();
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
        $response = $wrapper->send($handler, [[]]);
        $expected = [
            'retriesEnabled' => false,
        ];
        $this->assertEquals($expected, $response->options['retrySettings']);
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
        $response = $wrapper->send($handler, [[]]);
        $expected = [];
        $this->assertEquals($expected, $response->options['retrySettings']);
    }

    public function testUserConfigsAreNotRuined()
    {
        $retrySettings = [
            'retriesEnabled' => false,
            'noRetriesRpcTimeoutMillis' => 1234,
        ];
        $config = [
            'useGapicBackoffs' => true,
            'grpcOptions' => [
                'retrySettings' => $retrySettings,
            ],
        ];
        $wrapper = $this->getWrapper($config);
        $handler = function () {
            $args = func_get_args();
            return new MockOperationResponse('test', null, array_pop($args));
        };
        $response = $wrapper->send($handler, [[]]);
        $this->assertEquals($retrySettings, $response->options['retrySettings']);
    }
}
