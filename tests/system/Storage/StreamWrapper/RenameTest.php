<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\Storage\StreamWrapper;

/**
 * @group storage
 * @group streamWrapper
 */
class RenameTest extends StreamWrapperTestCase
{
    const TEST_FILE = 'some_folder/foo.txt';
    const NEW_TEST_FILE = 'some_folder/bar.txt';

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // create file in folder
        self::$bucket->upload('somedata', ['name' => self::TEST_FILE]);
    }

    public function testRenameFile()
    {
        $oldFile = self::generateUrl(self::TEST_FILE);
        $newFile = self::generateUrl(self::NEW_TEST_FILE);
        $this->assertTrue(rename($oldFile, $newFile));
        $this->assertTrue(file_exists($newFile));
    }

    public function testRenameDirectory()
    {
        $oldFolder = self::generateUrl(dirname(self::TEST_FILE));
        $newFolder = self::generateUrl('new_folder');
        $newFile = $newFolder . '/bar.txt';
        $this->assertTrue(rename($oldFolder, $newFolder));
        $this->assertTrue(file_exists($newFile));
    }

}
