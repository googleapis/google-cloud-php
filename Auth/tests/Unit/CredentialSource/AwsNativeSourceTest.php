<?php
/*
 * Copyright 2023 Google Inc.
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

namespace Google\Auth\Tests\CredentialSource;

use Google\Auth\CredentialSource\AwsNativeSource;
use LogicException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @group credentialsource
 * @group credentialsource-aws
 */
class AwsNativeSourceTest extends TestCase
{
    use ProphecyTrait;

    private string $audience = '"//iam.googleapis.com/projects/PROJECT_NUMBER/locations/global/'
        . 'workloadIdentityPools/byoid-pool-php/providers/PROJECT_ID';
    private string $regionUrl = 'https://test.regional.url';
    private string $regionalCredVerificationUrl = 'https://{region}.regional.cred.verification.url';
    private string $securityCredentialsUrl = 'https://test.security.credentials.url';
    private string $imdsv2SessionTokenUrl = 'https://test.imdsv2.session.token.url';

    public function testGetRegionFromUrl()
    {
        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals($this->regionUrl, (string) $request->getUri());

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn('us-east-2b');
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $region = AwsNativeSource::getRegionFromUrl($httpHandler, $this->regionUrl, []);
        $this->assertEquals('us-east-2', $region);
    }

    /** @runInSeparateProcess */
    public function testGetRegionFromEnv()
    {
        // Without any environment variables set, getRegionFromEnv should return null
        $this->assertNull(AwsNativeSource::getRegionFromEnv());

        // Requires AWS_REGION or AWS_DEFAULT_REGION to be set
        putenv('AWS_REGION=aws-region');
        $this->assertEquals('aws-region', AwsNativeSource::getRegionFromEnv());

        // Setting the default region does not hvae an effect
        putenv('AWS_DEFAULT_REGION=aws-default-region');
        $this->assertEquals('aws-region', AwsNativeSource::getRegionFromEnv());

        // Unsetting the AWS_REGION uses AWS_DEFAULT_REGION instead
        putenv('AWS_REGION=');
        $this->assertEquals('aws-default-region', AwsNativeSource::getRegionFromEnv());
    }

    public function testGetRoleName()
    {
        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals($this->securityCredentialsUrl, (string) $request->getUri());

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn('expected-role-name');
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $roleName = AwsNativeSource::getRoleName($httpHandler, $this->securityCredentialsUrl, []);

        $this->assertEquals('expected-role-name', $roleName);
    }

    public function testGetImdsV2SessionToken()
    {
        $imdsV2Url = 'http://some-metadata-url/latest/api/token';
        $httpHandler = function (RequestInterface $request) use ($imdsV2Url): ResponseInterface {
            $this->assertEquals('PUT', $request->getMethod());
            $this->assertEquals($imdsV2Url, (string) $request->getUri());
            $this->assertEquals('21600', $request->getHeaderLine('X-aws-ec2-metadata-token-ttl-seconds'));

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn('expected-aws-token');
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $roleName = AwsNativeSource::getImdsV2SessionToken($imdsV2Url, $httpHandler);

        $this->assertEquals('expected-aws-token', $roleName);
    }

    public function testGetSigningVarsFromUrl()
    {
        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals(
                $this->securityCredentialsUrl . '/test-role-name',
                (string) $request->getUri()
            );

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
                'Token' => 'expected-token',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $signingVars = AwsNativeSource::getSigningVarsFromUrl(
            $httpHandler,
            $this->securityCredentialsUrl,
            'test-role-name',
            []
        );

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertEquals('expected-token', $signingVars[2]);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEnv()
    {
        // Without any environment variables set, getSigningVarsFromEnv should return null
        $signingVars = AwsNativeSource::getSigningVarsFromEnv();

        $this->assertNull($signingVars);

        // Requires AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY to be set
        putenv('AWS_ACCESS_KEY_ID=expected-access-key-id');
        putenv('AWS_SECRET_ACCESS_KEY=expected-secret-access-key');

        $signingVars = AwsNativeSource::getSigningVarsFromEnv();

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertNull($signingVars[2]);

        // AWS_SESSION_TOKEN is optional
        putenv('AWS_SESSION_TOKEN=expected-session-token');

        $signingVars = AwsNativeSource::getSigningVarsFromEnv();
        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertEquals('expected-session-token', $signingVars[2]);
    }

    public function testGetSignedRequestHeaders()
    {
        $region = 'us-east-2';
        $host = 'sts.us-east-2.amazonaws.com';
        $accessKeyId = 'expected-access-key-id';
        $secretAccessKey = 'expected-secret-access-key';
        $securityToken = null;
        $headers = AwsNativeSource::getSignedRequestHeaders(
            $region,
            $host,
            $accessKeyId,
            $secretAccessKey,
            $securityToken
        );

        $this->assertEquals($host, $headers['host']);
        $this->assertArrayHasKey('x-amz-date', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertArrayNotHasKey('x-amz-security-token', $headers);
        $this->assertStringStartsWith('AWS4-HMAC-SHA256 ', $headers['Authorization']);
        $this->assertStringContainsString(
            ' Credential=expected-access-key-id/',
            $headers['Authorization']
        );
        $this->assertStringContainsString(
            sprintf('/%s/sts/aws4_request, SignedHeaders=host;x-amz-date, ', $region),
            $headers['Authorization']
        );
        $this->assertStringContainsString(
            ', Signature=',
            $headers['Authorization']
        );

        $securityToken = 'extected-security-token';
        $headers = AwsNativeSource::getSignedRequestHeaders(
            $region,
            $host,
            $accessKeyId,
            $secretAccessKey,
            $securityToken
        );

        $this->assertEquals($host, $headers['host']);
        $this->assertArrayHasKey('x-amz-date', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertArrayHasKey('x-amz-security-token', $headers);
        $this->assertStringStartsWith('AWS4-HMAC-SHA256 ', $headers['Authorization']);
        $this->assertStringContainsString(
            ' Credential=expected-access-key-id/',
            $headers['Authorization']
        );
        $this->assertStringContainsString(
            sprintf('/%s/sts/aws4_request, SignedHeaders=host;x-amz-date;x-amz-security-token, ', $region),
            $headers['Authorization']
        );
        $this->assertStringContainsString(
            ', Signature=',
            $headers['Authorization']
        );
    }

    public function testFetchSubjectTokenWithoutSecurityCredentialsUrlOrEnvThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'Unable to get credentials from ENV, and no security credentials URL provided'
        );

        $aws = new AwsNativeSource(
            $this->audience,
            $this->regionalCredVerificationUrl,
            $this->regionUrl,
            null,
            $this->imdsv2SessionTokenUrl,
        );
        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->fail('HTTP handler should not be called');
        };
        $aws->fetchSubjectToken($httpHandler);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsWithRelativeUri()
    {
        putenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=/v2/credentials/test');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals(
                'http://169.254.170.2/v2/credentials/test',
                (string) $request->getUri()
            );

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
                'Token' => 'expected-token',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $signingVars = AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertEquals('expected-token', $signingVars[2]);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsWithFullUri()
    {
        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals(
                'http://localhost:8080/credentials',
                (string) $request->getUri()
            );

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $signingVars = AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertNull($signingVars[2]);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsWithAuthToken()
    {
        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');
        putenv('AWS_CONTAINER_AUTHORIZATION_TOKEN=auth-token-123');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('auth-token-123', $request->getHeaderLine('Authorization'));

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsWithAuthTokenFile()
    {
        $tokenFile = tempnam(sys_get_temp_dir(), 'aws_token');
        file_put_contents($tokenFile, 'auth-token-file-123');

        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');
        putenv('AWS_CONTAINER_AUTHORIZATION_TOKEN_FILE=' . $tokenFile);
        putenv('AWS_CONTAINER_AUTHORIZATION_TOKEN=auth-token-123'); // File should take precedence

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('auth-token-file-123', $request->getHeaderLine('Authorization'));

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        try {
            AwsNativeSource::getSigningVarsFromEcs($httpHandler);
        } finally {
            if (file_exists($tokenFile)) {
                unlink($tokenFile);
            }
        }
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsWithUnreadableAuthTokenFile()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Token file /does/not/exist/token is not readable');

        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');
        putenv('AWS_CONTAINER_AUTHORIZATION_TOKEN_FILE=/does/not/exist/token');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->fail('HTTP handler should not be called');
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsThrowsUnexpectedValueExceptionOnInvalidResponse()
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Invalid or missing ECS credentials in response');

        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode(['invalid' => 'response']));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsThrowsExceptionOnServerError()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Server error');

        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            throw new \RuntimeException('Server error');
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsRelativeUriTakesPrecedenceOverFullUri()
    {
        putenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=/v2/credentials/relative');
        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=http://localhost:8080/credentials');

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals(
                'http://169.254.170.2/v2/credentials/relative',
                (string) $request->getUri()
            );

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
                'Token' => 'expected-token',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $signingVars = AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertEquals('expected-token', $signingVars[2]);
    }

    /**
     * @dataProvider provideInvalidRelativeUris
     * @runInSeparateProcess
     */
    public function testGetSigningVarsFromEcsWithInvalidRelativeUri(string $relativeUri)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid AWS_CONTAINER_CREDENTIALS_RELATIVE_URI');

        putenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=' . $relativeUri);

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->fail('HTTP handler should not be called');
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    public function provideInvalidRelativeUris(): array
    {
        return [
            ['v2/credentials/test'],
            ['@evil.com/credentials'],
            [':80@evil.com/credentials'],
        ];
    }

    /**
     * @dataProvider provideValidFullUris
     * @runInSeparateProcess
     */
    public function testGetSigningVarsFromEcsWithValidFullUris(string $fullUri, ?string $expectedUri = null)
    {
        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=' . $fullUri);

        $httpHandler = function (RequestInterface $request) use ($fullUri, $expectedUri): ResponseInterface {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals($expectedUri ?? $fullUri, (string) $request->getUri());

            $body = $this->prophesize(StreamInterface::class);
            $body->__toString()->willReturn(json_encode([
                'AccessKeyId' => 'expected-access-key-id',
                'SecretAccessKey' => 'expected-secret-access-key',
            ]));
            $response = $this->prophesize(ResponseInterface::class);
            $response->getBody()->willReturn($body->reveal());

            return $response->reveal();
        };

        $signingVars = AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        $this->assertEquals('expected-access-key-id', $signingVars[0]);
        $this->assertEquals('expected-secret-access-key', $signingVars[1]);
        $this->assertNull($signingVars[2]);
    }

    public function provideValidFullUris(): array
    {
        return [
            ['https://example.com/credentials'],
            ['http://localhost:8080/credentials'],
            ['http://127.0.0.1:51679/v2/credentials'],
            ['http://127.255.255.254/credentials'],
            ['http://[::1]:8080/credentials'],
            ['http://[0:0:0:0:0:0:0:1]:8080/credentials', 'http://[::1]:8080/credentials'],
            ['http://169.254.170.2/v2/credentials'],
            ['http://169.254.170.23/v1/credentials'],
            ['http://[fd00:ec2::23]/v1/credentials'],
            ['http://[fd00:ec2:0:0:0:0:0:23]/v1/credentials', 'http://[fd00:ec2::23]/v1/credentials'],
        ];
    }

    /**
     * @dataProvider provideInvalidFullUris
     * @runInSeparateProcess
     */
    public function testGetSigningVarsFromEcsWithInvalidFullUri(string $fullUri)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid AWS_CONTAINER_CREDENTIALS_FULL_URI');

        putenv('AWS_CONTAINER_CREDENTIALS_FULL_URI=' . $fullUri);

        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->fail('HTTP handler should not be called');
        };

        AwsNativeSource::getSigningVarsFromEcs($httpHandler);
    }

    public function provideInvalidFullUris(): array
    {
        return [
            ['http://example.com/credentials'],
            ['http://169.254.169.254/latest/meta-data/'],
            ['http://169.254.170.3/credentials'],
            ['http://10.0.0.1/credentials'],
            ['http://[fd00:ec2::24]/v1/credentials'],
            ['ftp://localhost/credentials'],
            ['not-a-valid-uri'],
        ];
    }

    /** @runInSeparateProcess */
    public function testGetSigningVarsFromEcsReturnsNullWhenUrisNotSet()
    {
        // No environment variables set
        $httpHandler = function (RequestInterface $request): ResponseInterface {
            $this->fail('HTTP handler should not be called');
        };

        $signingVars = AwsNativeSource::getSigningVarsFromEcs($httpHandler);

        $this->assertNull($signingVars);
    }

    /**
     * @runInSeparateProcess
     */
    public function testFetchSubjectTokenFromEcsWithRegionInEnvSkipsImdsV2()
    {
        $aws = new AwsNativeSource(
            $this->audience,
            $this->regionalCredVerificationUrl,
            $this->regionUrl,
            $this->securityCredentialsUrl,
            $this->imdsv2SessionTokenUrl,
        );

        putenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=/v2/credentials/test');
        putenv('AWS_REGION=us-east-2');

        // Mock response from AWS ECS Metadata Server
        $awsTokenBody = $this->prophesize(StreamInterface::class);
        $awsTokenBody->__toString()->willReturn(json_encode([
            'AccessKeyId' => 'expected-access-key-id',
            'SecretAccessKey' => 'expected-secret-access-key',
            'Token' => 'expected-token',
        ]));
        $awsTokenResponse = $this->prophesize(ResponseInterface::class);
        $awsTokenResponse->getBody()->willReturn($awsTokenBody->reveal());

        $requestCount = 0;
        $httpHandler = function (RequestInterface $request) use (
            $awsTokenResponse,
            &$requestCount
        ): ResponseInterface {
            $requestCount++;
            $this->assertEquals(1, $requestCount);
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('http://169.254.170.2/v2/credentials/test', (string) $request->getUri());
            return $awsTokenResponse->reveal();
        };

        $subjectToken = $aws->fetchSubjectToken($httpHandler);
        $this->assertEquals(1, $requestCount);
        $unserializedToken = json_decode(urldecode($subjectToken), true);
        $this->assertArrayHasKey('headers', $unserializedToken);
        $this->assertEquals('POST', $unserializedToken['method']);
        $this->assertEquals('https://us-east-2.regional.cred.verification.url', $unserializedToken['url']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testFetchSubjectTokenFromEcs()
    {
        $aws = new AwsNativeSource(
            $this->audience,
            $this->regionalCredVerificationUrl,
            $this->regionUrl,
            $this->securityCredentialsUrl,
            $this->imdsv2SessionTokenUrl,
        );

        putenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI=/v2/credentials/test');

        // Mock response from AWS ECS Metadata Server
        $ecsCredsBody = $this->prophesize(StreamInterface::class);
        $ecsCredsBody->__toString()->willReturn(json_encode([
            'AccessKeyId' => 'expected-access-key-id',
            'SecretAccessKey' => 'expected-secret-access-key',
            'Token' => 'expected-token',
        ]));
        $ecsCredsResponse = $this->prophesize(ResponseInterface::class);
        $ecsCredsResponse->getBody()->willReturn($ecsCredsBody->reveal());

        // Mock response from AWS IMDSv2 Session Token URL (for Region URL fallback)
        $imdsTokenBody = $this->prophesize(StreamInterface::class);
        $imdsTokenBody->__toString()->willReturn('aws-token');
        $imdsTokenResponse = $this->prophesize(ResponseInterface::class);
        $imdsTokenResponse->getBody()->willReturn($imdsTokenBody->reveal());

        // Mock response from Region URL
        $regionBody = $this->prophesize(StreamInterface::class);
        $regionBody->__toString()->willReturn('us-east-2b');
        $regionResponse = $this->prophesize(ResponseInterface::class);
        $regionResponse->getBody()->willReturn($regionBody->reveal());

        $requestCount = 0;
        $httpHandler = function (RequestInterface $request) use (
            $ecsCredsResponse,
            $imdsTokenResponse,
            $regionResponse,
            &$requestCount
        ): ResponseInterface {
            $requestCount++;
            switch ($requestCount) {
                case 1:
                    $this->assertEquals('GET', $request->getMethod());
                    $this->assertEquals('http://169.254.170.2/v2/credentials/test', (string) $request->getUri());
                    return $ecsCredsResponse->reveal();
                case 2:
                    $this->assertEquals('PUT', $request->getMethod());
                    $this->assertEquals($this->imdsv2SessionTokenUrl, (string) $request->getUri());
                    return $imdsTokenResponse->reveal();
                case 3:
                    $this->assertEquals('GET', $request->getMethod());
                    $this->assertEquals($this->regionUrl, (string) $request->getUri());
                    $this->assertEquals('aws-token', $request->getHeaderLine('X-aws-ec2-metadata-token'));
                    return $regionResponse->reveal();
            }
            throw new \Exception('Unexpected request');
        };

        $subjectToken = $aws->fetchSubjectToken($httpHandler);
        $this->assertEquals(3, $requestCount);
        $unserializedToken = json_decode(urldecode($subjectToken), true);
        $this->assertArrayHasKey('headers', $unserializedToken);
        $this->assertEquals('POST', $unserializedToken['method']);
        $this->assertEquals('https://us-east-2.regional.cred.verification.url', $unserializedToken['url']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testFetchSubjectTokenFromEnv()
    {
        $aws = new AwsNativeSource(
            $this->audience,
            $this->regionalCredVerificationUrl,
            $this->regionUrl,
        );

        // Set minimum number of environment variables required
        putenv('AWS_ACCESS_KEY_ID=expected-access-key-id');
        putenv('AWS_SECRET_ACCESS_KEY=expected-secret-access-key');

        // Mock response from Region URL
        $regionBody = $this->prophesize(StreamInterface::class);
        $regionBody->__toString()->willReturn('us-east-2b');
        $regionResponse = $this->prophesize(ResponseInterface::class);
        $regionResponse->getBody()->willReturn($regionBody->reveal());

        $requestCount = 0;
        $httpHandler = function (RequestInterface $request) use (
            $regionResponse,
            &$requestCount
        ): ResponseInterface {
            $requestCount++;
            $this->assertEquals(1, $requestCount);
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals($this->regionUrl, (string) $request->getUri());
            return $regionResponse->reveal();
        };

        $subjectToken = $aws->fetchSubjectToken($httpHandler);
        $this->assertEquals(1, $requestCount);
        $unserializedToken = json_decode(urldecode($subjectToken), true);
        $this->assertArrayHasKey('headers', $unserializedToken);
        $this->assertEquals('POST', $unserializedToken['method']);
        $this->assertEquals('https://us-east-2.regional.cred.verification.url', $unserializedToken['url']);
    }

    public function testFetchSubjectTokenFromUrl()
    {
        $aws = new AwsNativeSource(
            $this->audience,
            $this->regionalCredVerificationUrl,
            $this->regionUrl,
            $this->securityCredentialsUrl,
            $this->imdsv2SessionTokenUrl,
        );

        // Mock response from AWS Metadata Server
        $awsTokenBody = $this->prophesize(StreamInterface::class);
        $awsTokenBody->__toString()->willReturn('aws-token');
        $awsTokenResponse = $this->prophesize(ResponseInterface::class);
        $awsTokenResponse->getBody()->willReturn($awsTokenBody->reveal());

        // Mock response from Role Name request
        $roleBody = $this->prophesize(StreamInterface::class);
        $roleBody->__toString()->willReturn('test-role-name');
        $roleResponse = $this->prophesize(ResponseInterface::class);
        $roleResponse->getBody()->willReturn($roleBody->reveal());

        // Mock response from Security Credentials URL
        $securityCredentialsBody = $this->prophesize(StreamInterface::class);
        $securityCredentialsBody->__toString()->willReturn(json_encode([
            'AccessKeyId' => 'test-access-key-id',
            'SecretAccessKey' => 'test-secret-access-key',
            'Token' => 'test-token',
        ]));
        $securityCredentialsResponse = $this->prophesize(ResponseInterface::class);
        $securityCredentialsResponse->getBody()->willReturn($securityCredentialsBody->reveal());

        // Mock response from Region URL
        $regionBody = $this->prophesize(StreamInterface::class);
        $regionBody->__toString()->willReturn('us-east-2b');
        $regionResponse = $this->prophesize(ResponseInterface::class);
        $regionResponse->getBody()->willReturn($regionBody->reveal());

        $requestCount = 0;
        $httpHandler = function (RequestInterface $request) use (
            $awsTokenResponse,
            $roleResponse,
            $securityCredentialsResponse,
            $regionResponse,
            &$requestCount
        ): ResponseInterface {
            $requestCount++;
            switch ($requestCount) {
                case 1:
                    return $awsTokenResponse->reveal();
                case 2:
                    return $roleResponse->reveal();
                case 3:
                    return $securityCredentialsResponse->reveal();
                case 4:
                    return $regionResponse->reveal();
            }
            throw new \Exception('Unexpected request');
        };

        $subjectToken = $aws->fetchSubjectToken($httpHandler);
        $this->assertEquals(4, $requestCount);
        $unserializedToken = json_decode(urldecode($subjectToken), true);
        $this->assertArrayHasKey('headers', $unserializedToken);
        $this->assertEquals('POST', $unserializedToken['method']);
        $this->assertEquals('https://us-east-2.regional.cred.verification.url', $unserializedToken['url']);
    }
}
