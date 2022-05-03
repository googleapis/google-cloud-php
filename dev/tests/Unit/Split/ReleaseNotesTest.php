<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit;

use Google\Cloud\Dev\Split\ReleaseNotes;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;

/**
 * @group dev
 * @group dev-split
 */
class ReleaseNotesTest extends TestCase
{
    use AssertStringContains;

    private $releaseNotes;

    public function set_up()
    {
        $this->releaseNotes = new ReleaseNotes(
            file_get_contents(__DIR__ . '/../../fixtures/split/release-notes.md')
        );
    }

    public function testGet()
    {
        $note = $this->releaseNotes->get('cloud-automl');
        $this->assertNotNull($note);
        $this->assertStringContainsString("Miscellaneous Chores", $note);

        $this->assertNull($this->releaseNotes->get('cloud-foobar'));
    }
}
