<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Tests\Unit;

use Google\ApiCore\CredentialsWrapper;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use UnexpectedValueException;

/**
 * @group core
 */
class GrpcTraitTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    private $implementation;
    private $requestWrapper;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->implementation = TestHelpers::impl(GrpcTrait::class);
        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
    }

    public function testSetGetRequestWrapper()
    {
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $this->assertInstanceOf(GrpcRequestWrapper::class, $this->implementation->requestWrapper());
    }

    public function testSendsRequest()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $message = ['successful' => 'message'];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willReturn($message);

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return true;
        }, [['grpcOptions' => $grpcOptions]]);

        $this->assertEquals($message, $actualResponse);
    }

    public function testSendsRequestWithOptions()
    {
        $options = [
            'requestTimeout' => 3.5,
            'grpcOptions' => ['timeoutMs' => 100],
            'retries' => 0
        ];
        $message = ['successful' => 'message'];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            $options
        )->willReturn($message);

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return true;
        }, [$options]);

        $this->assertEquals($message, $actualResponse);
    }

    public function testSendsRequestWithRetryFunction()
    {
        $timesCalled = 0;
        $options = [
            'retries' => 1,
            'grpcRetryFunction' => function (\Exception $ex) {
                return $ex->getMessage() === 'test retry';
            }
        ];
        $requestWrapper = new GrpcRequestWrapper();
        $this->implementation->setRequestWrapper($requestWrapper);
        $actualResponse = $this->implementation->send(
            function () use (&$timesCalled) {
                if (2 === ++$timesCalled) {
                    // succeed on second try
                    return;
                }
                throw new NotFoundException('test retry');
            },
            [$options]
        );

        $this->assertEquals(2, $timesCalled);
    }

    public function testSendsRequestNotFoundWhitelisted()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send($this->noop(), [['grpcOptions' => $grpcOptions]], true);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    public function testSendsRequestNotFoundNotWhitelisted()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send($this->noop(), [['grpcOptions' => $grpcOptions]], false);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringNotContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    public function testGetsGaxConfig()
    {
        $version = '1.0.0';

        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $this->requestWrapper->getCredentialsFetcher()->willReturn($fetcher);
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $expected = [
            'libName' => 'gccl',
            'libVersion' => $version,
            'transport' => 'grpc',
            'credentials' => new CredentialsWrapper($fetcher, function () {
                return true;
            })
        ];

        $this->assertEquals(
            $expected,
            $this->implementation->call(
                'getGaxConfig',
                [
                    $version,
                    function () {
                        return true;
                    }
                ]
            )
        );
    }

    /**
     * @dataProvider provideGetGaxConfig
     */
    public function testUniverseDomainFromGaxConfig(
        ?string $universeDomain,
        string $expectedUniverseDomain,
        string $envUniverse = null
    ) {
        if ($envUniverse) {
            putenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN=' . $envUniverse);
        }

        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $this->requestWrapper->getCredentialsFetcher()->willReturn($fetcher);

        $impl = new class() {
            use GrpcTrait {
                getGaxConfig as public;
            }
        };
        $impl->setRequestWrapper($this->requestWrapper->reveal());

        $config = $impl->getGaxConfig('1.2.3', null, $universeDomain);
        $refl = new \ReflectionClass($config['credentials']);
        $prop = $refl->getProperty('universeDomain');
        $prop->setAccessible(true);
        $universeDomain = $prop->getValue($config['credentials']);

        if ($envUniverse) {
            // We have to do this instead of using "@runInSeparateProcess" because in the case of
            // an error, PHPUnit throws a "Serialization of 'ReflectionClass' is not allowed" error.
            // @TODO: Remove this once we've updated to PHPUnit 10.
            putenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN');
        }

        $this->assertEquals($expectedUniverseDomain, $universeDomain);
    }

    public function provideGetGaxConfig()
    {
        return [
            [null, 'googleapis.com'], // default
            ['ab.cd', 'ab.cd'], // explicitly set
            [null, 'ab.cd', 'ab.cd'], // from env var
            ['googleapis.com', 'googleapis.com', 'ab.cd'], // explicitly set takes priority over env var
        ];
    }

    private function noop()
    {
        return function () {
            return;
        };
    }
}
