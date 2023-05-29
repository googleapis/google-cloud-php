<?php
/**
 * Copyright 2022 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Tests\System;

use Google\Auth\CredentialsLoader;
use Google\Auth\Middleware\AuthTokenMiddleware;
use Google\Cloud\Datastore\DatastoreClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Datastore does not use the default deletion queue. Because of the way
 * datastore entities are deleted, a local queue is required.
 * Be sure to use `self::$localDeletionQueue` for all datastore entities
 * created during Multiple DB tests.
 */
class DatastoreMultipleDbTestCase extends DatastoreTestCase
{
    use ProphecyTrait;

    const TEST_DB_NAME = 'gcloud-test-multidb';

    protected static $restMultiDbClient;
    protected static $grpcMultiDbClient;
    protected static $returnInt64AsObjectMultiDbClient;
    private static $hasSetUp = false;
    private static $projectId;
    private static $multipleDbValidationResult = false;

    public static function setUpMultiDbBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }
        self::$projectId = getenv('PROJECT_ID');

        $config = [
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH'),
            'namespaceId' => uniqid(self::TESTING_PREFIX),
            'databaseId' => self::TEST_DB_NAME,
        ];

        self::$restMultiDbClient = new DatastoreClient($config + [
            'transport' => 'rest',
        ]);
        self::$grpcMultiDbClient = new DatastoreClient($config + [
            'transport' => 'grpc',
        ]);
        self::$returnInt64AsObjectMultiDbClient = new DatastoreClient($config + [
            'returnInt64AsObject' => true,
        ]);
        self::$hasSetUp = true;
    }

    public function multiDbClientProvider()
    {
        self::setUpBeforeClass();
        self::setUpMultiDbBeforeClass();

        if (!self::$multipleDbValidationResult) {
            $fsAdminClient = $this->getFirestoreAdminClient();
            if (!$this->checkTestDbExists($fsAdminClient) && !$this->createDb($fsAdminClient)) {
                throw new \Exception('Could not create DB: ' . self::TEST_DB_NAME);
            }
            self::$multipleDbValidationResult = true;
        }

        return [
            'multiDbRestClient' => [self::$restMultiDbClient],
            'multiDbGrpcClient' => [self::$grpcMultiDbClient],
        ];
    }

    public function clientProvider()
    {
        return self::multiDbClientProvider() + self::defaultDbClientProvider();
    }

    private function checkTestDbExists($client)
    {
        $response = $client->request(
            'GET',
            sprintf(
                '/v1/projects/%s/databases',
                self::$projectId,
            )
        );
        if ($response->getStatusCode() != 200) {
            return false;
        }
        $response = json_decode($response->getBody(), true);
        if (!array_key_exists('databases', $response)) {
            return false;
        }
        $dbId = self::getDbId();
        foreach ($response['databases'] as $database) {
            if (!array_key_exists('name', $database)) {
                continue;
            }
            if ($database['name'] === $dbId) {
                return true;
            }
        }
        return false;
    }

    private function getFirestoreAdminClient()
    {
        $emulatorHost = getenv('DATASTORE_EMULATOR_HOST');
        if ((bool) $emulatorHost) {
            // datastore emulator does not support firestore admin operations
            // such as create DB or get DB in Datastore mode.
            return $this->getMockedFirestoreAdminClient();
        }
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $jsonKey = json_decode(file_get_contents($keyFilePath), true);
        $scopes = [DatastoreClient::FULL_CONTROL_SCOPE];
        $creds = CredentialsLoader::makeCredentials($scopes, $jsonKey);
        $middleware = new AuthTokenMiddleware($creds);
        if (!class_exists(HandlerStack::class)) {
            throw new \Exception(
                'HandlerStack is required for Multiple DB tests but was not found.'
            );
        }
        $stack = HandlerStack::create();
        $stack->push($middleware);

        return new Client([
            'handler' => $stack,
            'base_uri' => 'https://firestore.googleapis.com',
            'auth' => 'google_auth', // authorize all requests
        ]);
    }

    private function createDb($client)
    {
        $response = $client->request(
            'POST',
            sprintf(
                '/v1/projects/%s/databases?databaseId=%s',
                self::$projectId,
                self::TEST_DB_NAME,
            ),
            [
                'json' => [
                    'type' => 'DATASTORE_MODE',
                    'locationId' => 'nam5',
                ],
            ]
        );
        if ($response->getStatusCode() != 200) {
            return false;
        }
        $dbId = self::getDbId();
        $response = json_decode($response->getBody(), true);
        if (!array_key_exists('name', $response) ||
            substr($response['name'], 0, strlen($dbId)) !== $dbId
        ) {
            return false;
        }
        return true;
    }

    private static function getDbId()
    {
        return sprintf(
            'projects/%s/databases/%s',
            self::$projectId,
            self::TEST_DB_NAME
        );
    }

    private function getMockedFirestoreAdminClient()
    {
        $client = self::prophesize(Client::class);
        $getResponse = new Response(
            200,
            [],
            sprintf(
                '{"databases":[{"name":"%s","type":"DATASTORE_MODE","locationId":"nam5"}]}',
                self::getDbId(),
                uniqid()
            )
        );

        $client->request('GET', Argument::any())
            ->shouldBeCalledOnce()
            ->willReturn($getResponse);
        return $client->reveal();
    }
}
