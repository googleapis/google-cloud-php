<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Dev\Tests\Snippet\ProductNeutralGuides;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\VideoIntelligence\V1\Client\VideoIntelligenceServiceClient;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;

/**
 * @group docs
 */
class AuthenticationTest extends SnippetTestCase
{
    private const AUTHENTICATION_FILE = __DIR__ . '/../../../../AUTHENTICATION.md';

    use ProphecyTrait;

    public function testAuthenticationCredentialsOption()
    {
        $snippet = $this->snippetFromMarkdown(
            self::AUTHENTICATION_FILE,
            'Credentials Options',
        );

        $clientEmail = 'testing-sa@test.com';
        $tmpfile = tempnam(sys_get_temp_dir(), 'service-account-json');
        file_put_contents($tmpfile, json_encode([
            'type' => 'service_account',
            'private_key' => '',
            'client_email' => $clientEmail,
        ]));

        $snippet->replace('/path/to/service-account.json', $tmpfile);

        $res = $snippet->invoke('video');
        $client = $res->returnVal();
        $this->assertInstanceOf(VideoIntelligenceServiceClient::class, $client);
        $credsWrapper = (new ReflectionClass($client))->getProperty('credentialsWrapper')->getValue($client);
        $creds = (new ReflectionClass($credsWrapper))->getProperty('credentialsFetcher')->getValue($credsWrapper);
        $this->assertInstanceOf(ServiceAccountCredentials::class, $creds);
        $this->assertEquals($clientEmail, $creds->getClientName());
    }

    public function testAuthenticationCredentialsFetcherOption()
    {
        $snippet = $this->snippetFromMarkdown(
            self::AUTHENTICATION_FILE,
            'Credentials Options',
            1 // second example in this section
        );

        $clientEmail = 'testing-sa2@test.com';
        $tmpfile = tempnam(sys_get_temp_dir(), 'service-account-json');
        file_put_contents($tmpfile, json_encode([
            'type' => 'service_account',
            'private_key' => '',
            'client_email' => $clientEmail,
        ]));

        $snippet->replace('/path/to/keyfile.json', $tmpfile);

        $res = $snippet->invoke('storage');
        $client = $res->returnVal();
        $this->assertInstanceOf(StorageClient::class, $client);
        $connection = (new ReflectionClass($client))->getProperty('connection')->getValue($client);
        $requestWrapper = (new ReflectionClass($connection))->getProperty('requestWrapper')->getValue($connection);
        $creds = (new ReflectionClass($requestWrapper))->getProperty('credentialsFetcher')->getValue($requestWrapper);
        $this->assertInstanceOf(ServiceAccountCredentials::class, $creds);
        $this->assertEquals($clientEmail, $creds->getClientName());
    }
}
