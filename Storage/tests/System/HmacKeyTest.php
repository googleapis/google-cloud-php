<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Storage\HmacKey;

/**
 * @group storage
 * @group storage-hmac
 */
class HmacKeyTest extends StorageTestCase
{
    private static $serviceAccountEmail;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        self::$serviceAccountEmail = json_decode(
            file_get_contents(getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')),
            true
        )['client_email'];
    }

    public function testKeyLifecycle()
    {
        $res = $this->createHmacKey(self::$serviceAccountEmail);
        $this->assertEquals('ACTIVE', $res->hmacKey()->info()['state']);
        $this->assertNotNull($res->secret());

        $this->assertHasKey($res->hmacKey()->accessId());

        $this->deleteKey($res->hmacKey());

        $this->assertNotHasKey($res->hmacKey()->accessId());
    }

    public function testListWithServiceAccountEmail()
    {
        $altServiceAccount = getenv('GOOGLE_CLOUD_PHP_TESTS_ALT_KEY_PATH');
        if (!$altServiceAccount) {
            $this->markTestSkipped('Must provide `GOOGLE_CLOUD_PHP_TESTS_ALT_KEY_PATH` to run this test.');
            return;
        }

        $altServiceAccountEmail = json_decode(
            file_get_contents($altServiceAccount),
            true
        )['client_email'];

        $res1 = $this->createHmacKey(self::$serviceAccountEmail);
        $res2 = $this->createHmacKey($altServiceAccountEmail);

        $this->assertHasKey($res1->hmacKey()->accessId());
        $this->assertHasKey($res2->hmacKey()->accessId());

        $this->assertNotHasKey($res1->hmacKey()->accessId(), $altServiceAccountEmail);
        $this->assertHasKey($res2->hmacKey()->accessId(), $altServiceAccountEmail);

        $this->deleteKey($res1->hmacKey());
        $this->deleteKey($res2->hmacKey());
    }

    public function testListMaxResultsAndPage()
    {
        $this->flushKeys(self::$serviceAccountEmail);

        for ($i = 0; $i < 5; $i++) {
            self::$client->createHmacKey(self::$serviceAccountEmail);
        }

        $keys = self::$client->hmacKeys(['maxResults' => 2]);
        $pages = $keys->iterateByPage();
        $currentPage = $pages->current();
        $this->assertCount(2, $currentPage);
        $this->assertNotNull($pages->nextResultToken());
    }

    private function assertNotHasKey($accessId, $serviceAccountEmail = null)
    {
        return $this->runAssertHasKey('assertEmpty', $accessId, $serviceAccountEmail);
    }

    private function assertHasKey($accessId, $serviceAccountEmail = null)
    {
        return $this->runAssertHasKey('assertNotEmpty', $accessId, $serviceAccountEmail);
    }

    private function runAssertHasKey($assertion, $accessId, $serviceAccountEmail)
    {
        $opts = $serviceAccountEmail
            ? ['serviceAccountEmail' => $serviceAccountEmail]
            : [];

        $allKeys = iterator_to_array(self::$client->hmacKeys($opts));
        $this->$assertion(array_filter($allKeys, function ($key) use ($accessId) {
            return $key->accessId() === $accessId;
        }));
    }

    private function deleteKey(HmacKey $key)
    {
        $key->update('INACTIVE');
        $key->delete();
    }

    /**
     * Create HMAC key with flush and retry if quotas are exceeded.
     *
     * Quotas for each service account are low, and thus the test is subject to
     * quickly exceeding these limits. If the limits are hit, clear the keys and
     * try again.
     *
     * @param string $serviceAccountEmail
     * @return CreatedHmacKey
     */
    private function createHmacKey($serviceAccountEmail)
    {
        try {
            return self::$client->createHmacKey($serviceAccountEmail);
        } catch (ServiceException $e) {
            $this->flushKeys($serviceAccountEmail);

            return $this->createHmacKey($serviceAccountEmail);
        }
    }

    private function flushKeys($serviceAccountEmail)
    {
        foreach (self::$client->hmacKeys(['serviceAccountEmail' => $serviceAccountEmail]) as $key) {
            $key->update('INACTIVE');
            $key->delete();
        }
    }
}
