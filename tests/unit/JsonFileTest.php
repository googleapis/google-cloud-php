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

use League\JsonGuard\Dereferencer;
use League\JsonGuard\Validator;

/**
 * @group root
 */
class JsonFileTest extends \PHPUnit_Framework_TestCase
{
    const SCHEMA_PATH = '%s/fixtures/schema/%s';

    public function testComposer()
    {
        $file = file_get_contents(__DIR__ .'/../../composer.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference(json_decode(file_get_contents(sprintf(
            self::SCHEMA_PATH,
            __DIR__, 'composer.json.schema'
        ))));

        $validator = new Validator($json, $schema);

        if ($validator->fails()) {
            print_r($validator->errors());
        }

        $this->assertFalse($validator->fails());
    }

    public function testComponentComposer()
    {
        $files = glob(__DIR__ .'/../../src/*/composer.json');
        foreach ($files as $file) {
            $json = json_decode(file_get_contents($file));
            $this->assertEquals(JSON_ERROR_NONE, json_last_error());

            $deref  = new Dereferencer();
            $schema = $deref->dereference(json_decode(file_get_contents(sprintf(
                self::SCHEMA_PATH,
                __DIR__, 'composer.json.schema'
            ))));

            $validator = new Validator($json, $schema);

            if ($validator->fails()) {
                print_r($validator->errors());
            }

            $this->assertFalse($validator->fails());
        }
    }

    public function testManifest()
    {
        $file = file_get_contents(__DIR__ .'/../../docs/manifest.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference(json_decode(file_get_contents(sprintf(
            self::SCHEMA_PATH,
            __DIR__, 'manifest.json.schema'
        ))));

        $validator = new Validator($json, $schema);

        if ($validator->fails()) {
            print_r($validator->errors());
        }

        $this->assertFalse($validator->fails());
    }

    public function testToc()
    {
        $file = file_get_contents(__DIR__ .'/../../docs/toc.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference(json_decode(file_get_contents(sprintf(
            self::SCHEMA_PATH,
            __DIR__, 'toc.json.schema'
        ))));

        $validator = new Validator($json, $schema);

        if ($validator->fails()) {
            print_r($validator->errors());
        }

        $this->assertFalse($validator->fails());
    }
}
