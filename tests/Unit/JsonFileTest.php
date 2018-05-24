<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Unit;

use Swaggest\JsonSchema\Schema;
use PHPUnit\Framework\TestCase;

/**
 * @group root
 */
class JsonFileTest extends TestCase
{
    const SCHEMA_PATH = '%s/fixtures/schema/%s';

    public function testComposer()
    {
        $file = file_get_contents(__DIR__ .'/../../composer.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $this->validateAndAssert($json, 'composer.json.schema');

    }

    /**
     * @dataProvider components
     */
    public function testComponentComposer($component)
    {
        $file = file_get_contents($component);
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $this->validateAndAssert($json, 'composer.json.schema');
    }

    public function components()
    {
        $files = glob(__DIR__ .'/../../*/composer.json');
        array_walk($files, function (&$file) {
            $file = [realpath($file)];
        });

        return $files;
    }

    public function testManifest()
    {
        $file = file_get_contents(__DIR__ .'/../../docs/manifest.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $this->validateAndAssert($json, 'manifest.json.schema');
    }

    public function testToc()
    {
        $file = file_get_contents(__DIR__ .'/../../docs/toc.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $this->validateAndAssert($json, 'toc.json.schema');
    }

    private function validateAndAssert($input, $schemaPath)
    {
        $schema = file_get_contents(sprintf(
            self::SCHEMA_PATH,
            __DIR__, $schemaPath
        ));

        $validator = Schema::import(json_decode($schema));

        $valid = false;
        $msg = '';
        try {
            $validator->in($input);
            $valid = true;
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }

        $this->assertTrue($valid, $msg);
    }
}
