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

namespace Google\Cloud\Tests;

use League\JsonGuard\Dereferencer;
use League\JsonGuard\Validator;

/**
 * @group root
 */
class JsonFileTest extends \PHPUnit_Framework_TestCase
{
    public function testComposer()
    {
        $file = file_get_contents(__DIR__ .'/../composer.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference('https://getcomposer.org/schema.json');

        $validator = new Validator($json, $schema);

        $this->assertFalse($validator->fails());
    }

    public function testManifest()
    {
        $file = file_get_contents(__DIR__ .'/../docs/manifest.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference('https://raw.githubusercontent.com/GoogleCloudPlatform/gcloud-common/master/site/schemas/manifest.schema.json');

        $validator = new Validator($json, $schema);

        $this->assertFalse($validator->fails());
    }

    public function testToc()
    {
        $file = file_get_contents(__DIR__ .'/../docs/toc.json');
        $json = json_decode($file);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        $deref  = new Dereferencer();
        $schema = $deref->dereference('https://raw.githubusercontent.com/GoogleCloudPlatform/gcloud-common/master/site/schemas/toc.schema.json');

        $validator = new Validator($json, $schema);

        $this->assertFalse($validator->fails());
    }
}
