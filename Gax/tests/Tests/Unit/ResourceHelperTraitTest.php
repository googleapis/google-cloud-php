<?php
/*
 * Copyright 2022 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\PathTemplate;
use Google\ApiCore\ResourceHelperTrait;
use Google\ApiCore\ValidationException;
use PHPUnit\Framework\TestCase;

class ResourceHelperTraitTest extends TestCase
{
    public function testRegisterPathTemplates()
    {
        $got = ResourceHelperTraitStub::testRegisterPathTemplates();
        $this->assertEquals(count($got), 4);
        $this->assertTrue($got['project'] instanceof PathTemplate);
    }

    public function testGetPathTemplate()
    {
        $got = ResourceHelperTraitStub::testGetPathTemplate('project');
        $this->assertNotNull($got);
        $this->assertTrue($got instanceof PathTemplate);
    }

    public function testGetPathTemplateNull()
    {
        $got = ResourceHelperTraitStub::testGetPathTemplate('does_not_exist');
        $this->assertNull($got);
    }

    public function testParseName()
    {
        $got = ResourceHelperTraitStub::parseName('projects/abc123', 'project');
        $this->assertEquals(count($got), 1);
        $this->assertEquals($got['project'], 'abc123');
    }

    public function testParseNameInvalidTemplate()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Template name does_not_exist does not exist');

        ResourceHelperTraitStub::parseName('projects/abc123', 'does_not_exist');
    }

    public function testParseNameNoMatchingPattern()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Input did not match any known format. Input: no/matching/pattern');

        ResourceHelperTraitStub::parseName('no/matching/pattern');
    }
    
}

class ResourceHelperTraitStub
{
    use ResourceHelperTrait;

    const CONFIG_PATH = __DIR__ . '/testdata/test_service_descriptor_config.php';
    const SERVICE_NAME = 'test.interface.v1.api';

    private static function getClientDefaults()
    {
        return ['descriptorsConfigPath' => self::CONFIG_PATH];
    }

    public static function parseName($formattedName, $template = null)
    {
        return self::parseFormattedName($formattedName, $template);
    }

    public static function testRegisterPathTemplates()
    {
        self::registerPathTemplates();
        return self::$templateMap;
    }

    public static function testGetPathTemplate($key)
    {
        return self::getPathTemplate($key);
    }
}
