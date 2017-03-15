<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\Storage;

use Google\Cloud\Storage\Acl;
use Google\Cloud\Core\Exception\NotFoundException;

/**
 * @group storage
 */
class ManageAclTest extends StorageTestCase
{
    public function testManageBucketAcl()
    {
        $kind = 'storage#bucketAccessControl';
        $this->assertAcl(self::$bucket->acl(), $kind);
    }

    public function testManageDefaultObjectAcl()
    {
        $kind = 'storage#objectAccessControl';
        $this->assertAcl(self::$bucket->defaultAcl(), $kind);
    }

    public function testManageObjectAcl()
    {
        $kind = 'storage#objectAccessControl';
        $this->assertAcl(self::$object->acl(), $kind);
    }

    private function assertAcl($acl, $kind)
    {
        $user = 'user-gcloud.php.tests@gmail.com';
        $found = true;
        $accessItems = $acl->get();

        foreach ($accessItems as $item) {
            $this->assertEquals($kind, $item['kind']);
        }

        $acl->add($user, Acl::ROLE_READER);
        $item = $acl->get(['entity' => $user]);
        $this->assertEquals($kind, $item['kind']);
        $this->assertEquals(Acl::ROLE_READER, $item['role']);

        $acl->update($user, Acl::ROLE_OWNER);
        $item = $acl->get(['entity' => $user]);
        $this->assertEquals($kind, $item['kind']);
        $this->assertEquals(Acl::ROLE_OWNER, $item['role']);

        $acl->delete($user);

        try {
            $acl->get(['entity' => $user]);
        } catch (NotFoundException $ex) {
            $found = false;
        }

        $this->assertFalse($found);
    }
}
