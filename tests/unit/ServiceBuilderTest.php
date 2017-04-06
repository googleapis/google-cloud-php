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
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Language\LanguageClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\ServiceBuilder;
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Vision\VisionClient;

/**
 * @group servicebuilder
 */
class ServiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider serviceProvider
     */
    public function testBuildsClients($serviceName, $expectedClient, array $args = [])
    {
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

    public function testBuildsTranslateClient()
    {
        $config = ['key' => 'test_key'];
        $serviceBuilder = new ServiceBuilder($config);

        $this->assertInstanceOf(TranslateClient::class, $serviceBuilder->translate());
        $this->assertInstanceOf(TranslateClient::class, $serviceBuilder->translate($config));
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
                'logging',
                LoggingClient::class
            ], [
                'language',
                LanguageClient::class
            ], [
                'pubsub',
                PubSubClient::class
            ], [
                'speech',
                SpeechClient::class,
                ['languageCode' => 'en-US']
            ], [
                'storage',
                StorageClient::class
            ], [
                'vision',
                VisionClient::class
            ]
        ];
    }
}
