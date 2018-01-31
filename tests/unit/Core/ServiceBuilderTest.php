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
namespace Google\Cloud\Tests\Unit;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Core\Testing\CheckForClassTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Language\LanguageClient;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Tests\Unit\Core\Fixtures;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Vision\VisionClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @group servicebuilder
 */
class ServiceBuilderTest extends TestCase
{

    use GrpcTestTrait;
    use CheckForClassTrait;

    /**
     * @dataProvider serviceProvider
     */
    public function testBuildsClients($serviceName, $expectedClient, array $args = [], callable $beforeCallable = null)
    {
        $this->checkAndSkipTest([$expectedClient]);

        if ($beforeCallable) {
            call_user_func($beforeCallable);
        }

        $serviceBuilder = new ServiceBuilder(['projectId' => 'myProject']);
        $config = [
            'projectId' => 'myProject',
            'scopes' => ['somescope'],
            'httpHandler' => function() {
                return;
            }
        ] + $args;

        $localConfigClient = $serviceBuilder->$serviceName($config);

        $this->assertInstanceOf($expectedClient, $localConfigClient);
    }

    public function testTranslateClientWithApiKey()
    {
        $this->checkAndSkipTest([TranslateClient::class]);

        $config = ['key' => 'test_key'];
        $serviceBuilder = new ServiceBuilder($config);

        $this->assertInstanceOf(TranslateClient::class, $serviceBuilder->translate());
        $this->assertInstanceOf(TranslateClient::class, $serviceBuilder->translate($config));
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testKeyfilePathAuthPassthrough(
        $serviceName,
        $expectedClient,
        array $args = [],
        callable $beforeCallable = null
    ) {
        $this->checkAndSkipTest([$expectedClient]);

        if ($beforeCallable) {
            call_user_func($beforeCallable);
        }

        $kfPath = Fixtures::JSON_KEY_FIXTURE();
        $kf = json_decode(file_get_contents($kfPath), true);

        $adc = getenv('GOOGLE_APPLICATION_CREDENTIALS');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=');

        $serviceBuilder = new ServiceBuilder([
            'keyFilePath' => $kfPath
        ]);

        $client = $serviceBuilder->$serviceName($args);

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('connection');
        $prop->setAccessible(true);
        $conn = $prop->getValue($client);
        $conn->requestWrapper()
            ->getCredentialsFetcher()
            ->fetchAuthToken($this->stub($kf));

        putenv('GOOGLE_APPLICATION_CREDENTIALS='. $adc);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testKeyfileAuthPassthrough(
        $serviceName, $expectedClient,
        array $args = [],
        callable $beforeCallable = null
    ) {
        $this->checkAndSkipTest([$expectedClient]);

        if ($beforeCallable) {
            call_user_func($beforeCallable);
        }

        $kfPath = Fixtures::JSON_KEY_FIXTURE();
        $kf = json_decode(file_get_contents($kfPath), true);

        $adc = getenv('GOOGLE_APPLICATION_CREDENTIALS');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=');

        $serviceBuilder = new ServiceBuilder([
            'keyFile' => $kf
        ]);

        $client = $serviceBuilder->$serviceName($args);

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('connection');
        $prop->setAccessible(true);
        $conn = $prop->getValue($client);
        $conn->requestWrapper()
            ->getCredentialsFetcher()
            ->fetchAuthToken($this->stub($kf));

        putenv('GOOGLE_APPLICATION_CREDENTIALS='. $adc);
    }

    public function serviceProvider()
    {
        return [
            [
                'bigQuery',
                BigQueryClient::class
            ], [
                'datastore',
                DatastoreClient::class
            ], [
                'firestore',
                FirestoreClient::class,
                [],
                [$this, 'checkAndSkipGrpcTests']
            ], [
                'logging',
                LoggingClient::class
            ], [
                'language',
                LanguageClient::class
            ], [
                'pubsub',
                PubSubClient::class
            ], [
                'spanner',
                SpannerClient::class,
                [],
                [$this, 'checkAndSkipGrpcTests']
            ], [
                'speech',
                SpeechClient::class,
                ['languageCode' => 'en-US']
            ], [
                'storage',
                StorageClient::class
            ], [
                'translate',
                TranslateClient::class
            ], [
                'vision',
                VisionClient::class
            ]
        ];
    }

    public function stub($kf)
    {
        return function (RequestInterface $request) use ($kf) {
            parse_str((string)$request->getBody(), $result);

            $exp = [
                'grant_type' => 'refresh_token',
                'refresh_token' => $kf['refresh_token'],
                'client_id' => $kf['client_id'],
                'client_secret' => $kf['client_secret']
            ];

            $this->assertEquals($result, $exp);

            return new Response(200, [], json_encode([
                'access_token' => 'foo'
            ]));
        };
    }
}
