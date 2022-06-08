<?php
/**
 * Copyright 2019 Google LLC.
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

namespace Google\Cloud\Firestore\Tests\System\Admin\V1;

use Google\ApiCore\PagedListResponse;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Firestore\Admin\V1\FirestoreAdminClient;
use Google\Cloud\Firestore\FirestoreClient;

/**
 * @group firestore
 * @group firestore-admin
 * @group gapic
 *
 * This smoke test case currently only invokes ListIndexes API call.
 *
 */
class FirestoreAdminClientSmokeTest extends SystemTestCase
{
    protected static $adminClient;
    private static $projectId;
    private static $hasSetup = false;

    public static function set_up_before_class()
    {
        if (self::$hasSetup) {
            return;
        }
        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        self::$projectId = $keyFileData['project_id'];
        self::$adminClient = new FirestoreAdminClient([
            'credentials' => $keyFilePath
        ]);
    }

    public function testListIndex()
    {
        $parentName = self::$adminClient->parentName(
            self::$projectId,
            FirestoreClient::DEFAULT_DATABASE,
            uniqid('system-test')
        );
        $resp = self::$adminClient->listIndexes($parentName);
        $this->assertInstanceOf(PagedListResponse::class, $resp);
    }
}
