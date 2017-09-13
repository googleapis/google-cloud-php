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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\SysvTrait;

/**
 * @group core
 */
class SysvTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->impl = new MySysvClass();
    }

    public function testGetSysvKey()
    {
        if (!$this->impl->isSysvIPCLoaded()) {
            $this->markTestSkipped(
                'SysV IPC extensions are not available, skipped'
            );
        }
        $key1 = $this->impl->getSysvKey(1);
        $key2 = $this->impl->getSysvKey(2);
        $this->assertEquals(1, $key2 - $key1);
    }

    public function testIsSysvIPCLoaded()
    {
        $expected = extension_loaded('sysvmsg')
            && extension_loaded('sysvsem')
            && extension_loaded('sysvshm');
        $this->assertEquals($expected, $this->impl->isSysvIPCLoaded());
    }
}

class MySysvClass
{
    use SysvTrait {
        isSysvIPCLoaded as privateIsSysvIPCLoaded;
        getSysvKey as privateGetSysvKey;
    }

    function isSysvIPCLoaded()
    {
        return $this->privateIsSysvIPCLoaded();
    }

    function getSysvKey($id)
    {
        return $this->privateGetSysvKey($id);
    }
}
