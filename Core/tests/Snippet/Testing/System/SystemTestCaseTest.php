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

namespace Google\Cloud\Core\Tests\Snippet\Testing\System;

use Foobar\FoobarTestCase;
use Foobar\Sub\SubTestCase;
use Foobar\Sub\Sub\SubSubTestCase;
use Foobar\Tests\System\Admin\AdminTestCase;
use Foobar\Tests\System\Admin\Sub\AdminSubTestCase;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use PHPUnit\Framework\SkippedTestError;

/**
 * @group core
 */
class SystemTestCaseTest extends SnippetTestCase
{
    const ENV = 'FOOBAR_EMULATOR_HOST';

    public function testSetUsingEmulator()
    {
        $snippet = $this->snippetFromMethod(SystemTestCase::class, 'setUsingEmulator');
        $snippet->replace('self', FoobarTestCase::class);
        putenv(self::ENV . '=localhost');
        $this->assertFalse(FoobarTestCase::isEmulatorUsed());
        $snippet->invoke();
        $this->assertTrue(FoobarTestCase::isEmulatorUsed());
        putenv(self::ENV . '=');
        $snippet->invoke();
        $this->assertFalse(FoobarTestCase::isEmulatorUsed());
    }

    public function testSetUsingEmulatorForClassPrefix()
    {
        putenv(self::ENV . '=localhost');

        $snippet = $this->snippetFromMethod(SystemTestCase::class, 'setUsingEmulatorForClassPrefix', 0);
        $snippet->replace('self', FoobarTestCase::class);
        $snippet->invoke();
        $this->assertTrue(SubTestCase::isEmulatorUsed());
        $this->assertTrue(SubSubTestCase::isEmulatorUsed());

        $snippet = $this->snippetFromMethod(SystemTestCase::class, 'setUsingEmulatorForClassPrefix', 1);
        $snippet->replace('self', FoobarTestCase::class);
        $snippet->invoke();
        $this->assertTrue(AdminTestCase::isEmulatorUsed());
        $this->assertTrue(AdminSubTestCase::isEmulatorUsed());

        putenv(self::ENV . '=');
    }

    public function testIsEmulatorUsed()
    {
        $snippet = $this->snippetFromMethod(SystemTestCase::class, 'isEmulatorUsed');
        $snippet->replace('self', FoobarTestCase::class);

        FoobarTestCase::setUsingEmulator(true);
        $res = $snippet->invoke('transports');
        $this->assertEquals([['grpc']], $res->returnVal());

        FoobarTestCase::setUsingEmulator(false);
        $res = $snippet->invoke('transports');
        $this->assertEquals([['grpc'], ['rest']], $res->returnVal());
    }

    public function testSkipIfEmulatorUsed()
    {
        $defaultSnippet = $this->snippetFromMethod(SystemTestCase::class, 'skipIfEmulatorUsed', 0);
        $customSnippet =  $this->snippetFromMethod(SystemTestCase::class, 'skipIfEmulatorUsed', 1);
        $defaultSnippet->replace('self', FoobarTestCase::class);
        $customSnippet->replace('self', FoobarTestCase::class);

        FoobarTestCase::setUsingEmulator(false);
        $defaultSnippet->invoke();
        $customSnippet->invoke();

        FoobarTestCase::setUsingEmulator(true);

        // For backwards compatibility with PHPUnit 4.8 and 5.0
        // This can be removed once support for PHP 5.5, 5.6, 7.0, and 7.1 is dropped
        if (!class_exists('PHPUnit\Framework\SkippedTestError')) {
            class_alias('PHPUnit_Framework_SkippedTestError', 'PHPUnit\Framework\SkippedTestError');
        }

        try {
            $defaultSnippet->invoke();
        } catch (SkippedTestError $e) {
            $this->assertStringStartsWith('This test is not supported', $e->getMessage());
        }
        try {
            $customSnippet->invoke();
        } catch (SkippedTestError $e) {
            $this->assertStringStartsWith('Administration functions are not supported', $e->getMessage());
        }
    }
}

//@codingStandardsIgnoreStart
namespace Foobar;

class FoobarTestCase extends \Google\Cloud\Core\Testing\System\SystemTestCase
{
}

namespace Foobar\Sub;

class SubTestCase extends \Foobar\FoobarTestCase
{
}

namespace Foobar\Sub\Sub;

class SubSubTestCase extends \Foobar\FoobarTestCase
{
}

namespace Foobar\Tests\System\Admin;

class AdminTestCase extends \Foobar\FoobarTestCase
{
}

namespace Foobar\Tests\System\Admin\Sub;

class AdminSubTestCase extends \Foobar\FoobarTestCase
{
}
//@codingStandardsIgnoreEnd
