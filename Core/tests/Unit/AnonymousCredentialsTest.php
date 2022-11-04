<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Core\AnonymousCredentials;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class AnonymousCredentialsTest extends TestCase
{
    private $credentials;
    private $token = [
        'access_token' => null
    ];

    public function set_up()
    {
        $this->credentials = new AnonymousCredentials();
    }

    public function testFetchAuthToken()
    {
        $this->assertEquals($this->token, $this->credentials->fetchAuthToken());
    }

    public function testGetCacheKey()
    {
        $this->assertNull($this->credentials->getCacheKey());
    }

    public function testGetLastReceivedToken()
    {
        $this->assertEquals($this->token, $this->credentials->getLastReceivedToken());
    }

    public function testUpdateMetadata()
    {
        $metadata = ['foo' => 'bar'];
        $this->assertEquals($metadata, $this->credentials->updateMetadata($metadata));
    }

    public function testGetQuotaProject()
    {
        $this->assertEquals(null, $this->credentials->getQuotaProject());
    }
}
