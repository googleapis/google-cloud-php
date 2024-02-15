<?php
/*
 * Copyright 2024 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\ClientOptionsTrait;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\GetUniverseDomainInterface;
use Grpc\Gcp\ApiConfig;
use Grpc\Gcp\Config;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ClientOptionsTraitTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    public function tearDown(): void
    {
        // Reset the static gapicVersion field between tests
        $client = new StubClientOptionsClient();
        $client->set('gapicVersionFromFile', null, true);
    }

    public function testGetGapicVersionWithVersionFile()
    {
        require_once __DIR__ . '/testdata/src/GapicClientStub.php';
        $version = '1.2.3-dev';
        $client = new \GapicClientStub();
        $this->assertEquals($version, $client->getGapicVersion([]));
    }

    public function testGetGapicVersionWithNoAvailableVersion()
    {
        $client = new StubClientOptionsClient();
        $this->assertSame('', $client->getGapicVersion([]));
    }

    public function testGetGapicVersionWithLibVersion()
    {
        $version = '1.2.3-dev';
        $client = new StubClientOptionsClient();
        $client->set('gapicVersionFromFile', $version, true);
        $options = ['libVersion' => $version];
        $this->assertEquals($version, $client->getGapicVersion(
            $options
        ));
    }

    /**
     * @dataProvider createCredentialsWrapperData
     */
    public function testCreateCredentialsWrapper($auth, $authConfig, $expectedCredentialsWrapper)
    {
        $client = new StubClientOptionsClient();
        $actualCredentialsWrapper = $client->createCredentialsWrapper(
            $auth,
            $authConfig,
            GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN
        );

        $this->assertEquals($expectedCredentialsWrapper, $actualCredentialsWrapper);
    }

    public function createCredentialsWrapperData()
    {
        $keyFilePath = __DIR__ . '/testdata/json-key-file.json';
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $credentialsWrapper = new CredentialsWrapper($fetcher);
        return [
            [null, [], CredentialsWrapper::build()],
            [$keyFilePath, [], CredentialsWrapper::build(['keyFile' => $keyFile])],
            [$keyFile, [], CredentialsWrapper::build(['keyFile' => $keyFile])],
            [$fetcher, [], new CredentialsWrapper($fetcher)],
            [$credentialsWrapper, [], $credentialsWrapper],
        ];
    }

    /**
     * @dataProvider createCredentialsWrapperValidationExceptionData
     */
    public function testCreateCredentialsWrapperValidationException($auth, $authConfig)
    {
        $client = new StubClientOptionsClient();

        $this->expectException(ValidationException::class);

        $client->createCredentialsWrapper(
            $auth,
            $authConfig,
            ''
        );
    }

    public function createCredentialsWrapperValidationExceptionData()
    {
        return [
            ['not a json string', []],
            [new \stdClass(), []],
        ];
    }

    /**
     * @dataProvider createCredentialsWrapperInvalidArgumentExceptionData
     */
    public function testCreateCredentialsWrapperInvalidArgumentException($auth, $authConfig)
    {
        $client = new StubClientOptionsClient();

        $this->expectException(InvalidArgumentException::class);

        $client->createCredentialsWrapper(
            $auth,
            $authConfig,
            ''
        );
    }

    public function createCredentialsWrapperInvalidArgumentExceptionData()
    {
        return [
            [['array' => 'without right keys'], []],
        ];
    }

    /**
     * @dataProvider buildClientOptionsProvider
     */
    public function testBuildClientOptions($options, $expectedUpdatedOptions)
    {
        if (!extension_loaded('sysvshm')) {
            $this->markTestSkipped('The sysvshm extension must be installed to execute this test.');
        }
        $client = new StubClientOptionsClient();
        $updatedOptions = $client->buildClientOptions($options);
        $this->assertEquals($expectedUpdatedOptions, $updatedOptions);
    }

    public function buildClientOptionsProvider()
    {
        $apiConfig = new ApiConfig();
        $apiConfig->mergeFromJsonString(
            file_get_contents(__DIR__ . '/testdata/test_service_grpc_config.json')
        );
        $grpcGcpConfig = new Config('test.address.com:443', $apiConfig);

        $defaultOptions = [
            'apiEndpoint' => 'test.address.com:443',
            'gcpApiConfigPath' => __DIR__ . '/testdata/test_service_grpc_config.json',
            'disableRetries' => false,
            'transport' => null,
            'transportConfig' => [
                'grpc' => [
                    'stubOpts' => [
                        'grpc_call_invoker' => $grpcGcpConfig->callInvoker(),
                        'grpc.service_config_disable_resolution' => 1
                    ]
                ],
                'rest' => [],
                'grpc-fallback' => [],
            ],
            'credentials' => null,
            'credentialsConfig' => [],
            'gapicVersion' => '',
            'libName' => null,
            'libVersion' => null,
            'clientCertSource' => null,
            'universeDomain' => 'googleapis.com',
        ];

        $restConfigOptions = $defaultOptions;
        $restConfigOptions['transportConfig']['rest'] += [
            'customRestConfig' => 'value'
        ];
        $grpcConfigOptions = $defaultOptions;
        $grpcConfigOptions['transportConfig']['grpc'] += [
            'customGrpcConfig' => 'value'
        ];
        return [
            [[], $defaultOptions],
            [
                [
                    'transportConfig' => [
                        'rest' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $restConfigOptions
            ],
            [
                [
                    'transportConfig' => [
                        'grpc' => [
                            'customGrpcConfig' => 'value'
                        ]
                    ]
                ], $grpcConfigOptions
            ],
        ];
    }

    /**
     * @dataProvider buildClientOptionsProviderRestOnly
     */
    public function testBuildClientOptionsRestOnly($options, $expectedUpdatedOptions)
    {
        if (!extension_loaded('sysvshm')) {
            $this->markTestSkipped('The sysvshm extension must be installed to execute this test.');
        }
        $client = new RestOnlyClient();
        $updatedOptions = $client->buildClientOptions($options);
        $this->assertEquals($expectedUpdatedOptions, $updatedOptions);
    }

    public function buildClientOptionsProviderRestOnly()
    {
        $defaultOptions = [
            'apiEndpoint' => null,
            'disableRetries' => false,
            'transport' => null,
            'transportConfig' => [
                'rest' => [],
                'fake-transport' => []
            ],
            'credentials' => null,
            'credentialsConfig' => [],
            'gapicVersion' => '',
            'libName' => null,
            'libVersion' => null,
            'clientCertSource' => null,
            'universeDomain' => 'googleapis.com',
        ];

        $restConfigOptions = $defaultOptions;
        $restConfigOptions['transportConfig']['rest'] += [
            'customRestConfig' => 'value'
        ];

        $fakeTransportConfigOptions = $defaultOptions;
        $fakeTransportConfigOptions['transportConfig']['fake-transport'] += [
            'customRestConfig' => 'value'
        ];
        return [
            [[], $defaultOptions],
            [
                [
                    'transportConfig' => [
                        'rest' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $restConfigOptions
            ],
            [
                [
                    'transportConfig' => [
                        'fake-transport' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $fakeTransportConfigOptions
            ],
        ];
    }

    public function testDefaultScopes()
    {
        $client = new DefaultScopeAndAudienceClientOptionsClient();

        // verify scopes are not set by default
        $defaultOptions = $client->buildClientOptions([]);
        $this->assertArrayNotHasKey('scopes', $defaultOptions['credentialsConfig']);

        // verify scopes are set when a custom api endpoint is used
        $defaultOptions = $client->buildClientOptions([
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]);
        $this->assertArrayHasKey('scopes', $defaultOptions['credentialsConfig']);
        $this->assertEquals(
            $client::$serviceScopes,
            $defaultOptions['credentialsConfig']['scopes']
        );

        // verify user-defined scopes override default scopes
        $defaultOptions = $client->buildClientOptions([
            'credentialsConfig' => ['scopes' => ['user-scope-1']],
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]);
        $this->assertArrayHasKey('scopes', $defaultOptions['credentialsConfig']);
        $this->assertEquals(
            ['user-scope-1'],
            $defaultOptions['credentialsConfig']['scopes']
        );

        // verify empty default scopes has no effect
        $client::$serviceScopes = null;
        $defaultOptions = $client->buildClientOptions([
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]);
        $this->assertArrayNotHasKey('scopes', $defaultOptions['credentialsConfig']);
    }

    /** @dataProvider provideDetermineMtlsEndpoint */
    public function testDetermineMtlsEndpoint($apiEndpoint, $expected)
    {
        $client = new StubClientOptionsClient();

        $this->assertEquals(
            $expected,
            $client->determineMtlsEndpoint($apiEndpoint)
        );
    }

    public function provideDetermineMtlsEndpoint()
    {
        return [
            ['foo', 'foo'],         // invalid no-op
            ['api.dev', 'api.dev'], // invalid no-op
            // normal endpoint
            ['vision.googleapis.com', 'vision.mtls.googleapis.com'],
            // endpoint with protocol
            ['https://vision.googleapis.com', 'https://vision.mtls.googleapis.com'],
            // endpoint with protocol and path
            ['https://vision.googleapis.com/foo', 'https://vision.mtls.googleapis.com/foo'],
            // regional endpoint
            ['us-documentai.googleapis.com', 'us-documentai.mtls.googleapis.com'],
        ];
    }

    /**
     * @runInSeparateProcess
     * @dataProvider provideShouldUseMtlsEndpoint
     */
    public function testShouldUseMtlsEndpoint($envVarValue, $options, $expected)
    {
        $client = new StubClientOptionsClient();

        putenv('GOOGLE_API_USE_MTLS_ENDPOINT=' . $envVarValue);
        $this->assertEquals(
            $expected,
            $client->shouldUseMtlsEndpoint($options)
        );
    }

    public function provideShouldUseMtlsEndpoint()
    {
        return [
            ['', [], false],
            ['always', [], true],
            ['never', [], false],
            ['never', ['clientCertSource' => true], false],
            ['auto', ['clientCertSource' => true], true],
            ['invalid', ['clientCertSource' => true], true],
            ['', ['clientCertSource' => true], true],
        ];
    }

    /**
     * @runInSeparateProcess
     * @dataProvider provideMtlsClientOptions
     */
    public function testMtlsClientOptions($envVars, $options, $expected)
    {
        foreach ($envVars as $envVar) {
            putenv($envVar);
        }

        $client = new StubClientOptionsClient();
        $options = $client->buildClientOptions($options);

        // Only check the keys we care about
        $options = array_intersect_key(
            $options,
            array_flip(['apiEndpoint', 'clientCertSource'])
        );

        $this->assertEquals($expected, $options);
    }

    public function provideMtlsClientOptions()
    {
        $defaultEndpoint = 'test.address.com:443';
        $mtlsEndpoint = 'test.mtls.address.com:443';
        return [
            [
                [],
                [],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=always'],
                [],
                ['apiEndpoint' => $mtlsEndpoint, 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=always'],
                ['apiEndpoint' => 'user.supplied.endpoint:443'],
                ['apiEndpoint' => 'user.supplied.endpoint:443', 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=never'],
                ['clientCertSource' => true],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => true]
            ],
            [
                [
                    'GOOGLE_API_USE_MTLS_ENDPOINT=auto'
                ],
                ['clientCertSource' => true],
                ['apiEndpoint' => $mtlsEndpoint, 'clientCertSource' => true]
            ],
            [
                [
                    'HOME=' . __DIR__ . '/testdata/nonexistant',
                    'GOOGLE_API_USE_MTLS_ENDPOINT', // no env var
                    CredentialsLoader::MTLS_CERT_ENV_VAR . '=true',
                ],
                [],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => null]
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testMtlsClientOptionWithDefaultClientCertSource()
    {
        putenv('HOME=' . __DIR__ . '/testdata/mtls');
        putenv('GOOGLE_API_USE_MTLS_ENDPOINT=auto');
        putenv(CredentialsLoader::MTLS_CERT_ENV_VAR . '=true');

        $client = new StubClientOptionsClient();
        $options = $client->buildClientOptions([]);

        $this->assertSame('test.mtls.address.com:443', $options['apiEndpoint']);
        $this->assertTrue(is_callable($options['clientCertSource']));
        $this->assertEquals(['foo', 'foo'], $options['clientCertSource']());
    }

    /**
     * @dataProvider provideServiceAddressTemplate
     * @runInSeparateProcess
     */
    public function testServiceAddressTemplate(array $options, string $expectedEndpoint, string $envVar = null)
    {
        if ($envVar) {
            putenv($envVar);
        }
        $client = new UniverseDomainStubClientOptionsClient();
        $updatedOptions = $client->buildClientOptions($options);

        $this->assertEquals($expectedEndpoint, $updatedOptions['apiEndpoint']);
    }

    public function provideServiceAddressTemplate()
    {
        return [
            [
                [],
                'stub.googleapis.com',  // defaults to "googleapis.com"
            ],
            [
                ['apiEndpoint' => 'new.test.address.com'],
                'new.test.address.com', // set through api endpoint
            ],
            [
                ['universeDomain' => 'foo.com'],
                'stub.foo.com', // set through universe domain
            ],
            [
                ['universeDomain' => 'foo.com', 'apiEndpoint' => 'new.test.address.com'],
                'new.test.address.com', // set through api endpoint (universe domain is not used)
            ],
            [
                [],
                'stub.googleapis.com',
                'GOOGLE_CLOUD_UNIVERSE_DOMAIN=', // env var is ignored when empty
            ],
            [
                ['universeDomain' => 'foo.com'],
                'stub.foo.com',
                'GOOGLE_CLOUD_UNIVERSE_DOMAIN=bar.com', // env var is ignored when client option is set
            ],
            [
                [],
                'stub.bar.com',
                'GOOGLE_CLOUD_UNIVERSE_DOMAIN=bar.com', // env var is used when client option isn't set
            ],
        ];
    }

    public function testMtlsWithUniverseDomainThrowsException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('mTLS is not supported outside the "googleapis.com" universe');

        $client = new UniverseDomainStubClientOptionsClient();
        $client->buildClientOptions([
            'universeDomain' => 'foo.com',
            'clientCertSource' => function () { $this->fail('this should not be called');},
        ]);
    }

    public function testBuildClientOptionsTwice()
    {
        $client = new StubClientOptionsClient();
        $options = $client->buildClientOptions([]);
        $options2 = $client->buildClientOptions($options);
        $this->assertEquals($options, $options2);
    }

}

class StubClientOptionsClient
{
    use ClientOptionsTrait {
        buildClientOptions as public;
        createCredentialsWrapper as public;
        determineMtlsEndpoint as public;
        getGapicVersion as public;
        shouldUseMtlsEndpoint as public;
    }

    public function set($name, $val, $static = false)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property not found: $name");
        }
        if ($static) {
            $this::$$name = $val;
        } else {
            $this->$name = $val;
        }
    }

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'gcpApiConfigPath' => __DIR__ . '/testdata/test_service_grpc_config.json',
        ];
    }
}

class RestOnlyClient
{
    use ClientOptionsTrait {
        buildClientOptions as public;
    }

    private static function supportedTransports()
    {
        return ['rest', 'fake-transport'];
    }

    private static function defaultTransport()
    {
        return 'rest';
    }
}

class DefaultScopeAndAudienceClientOptionsClient
{
    use ClientOptionsTrait {
        buildClientOptions as public;
    }

    const SERVICE_ADDRESS = 'service-address';

    public static $serviceScopes = [
        'default-scope-1',
        'default-scope-2',
    ];

    public static function getClientDefaults()
    {
        return [
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
        ];
    }
}

class UniverseDomainStubClientOptionsClient
{
    use ClientOptionsTrait {
        buildClientOptions as public;
    }

    private const SERVICE_ADDRESS_TEMPLATE = 'stub.UNIVERSE_DOMAIN';

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
        ];
    }
}
