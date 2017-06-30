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

namespace Google\Cloud\Tests\Unit\Core\Report;

use Google\Cloud\Core\Report\EmptyMetadataProvider;
use Google\Cloud\Core\Report\GAEFlexMetadataProvider;
use Google\Cloud\Core\Report\MetadataProviderUtils;

/**
 * @group core
 */
class MetadataProviderUtilsTest extends \PHPUnit_Framework_TestCase
{
    private $envs = ['GAE_SERVICE' => 'my-service'];

    public function testAutoSelect()
    {
        $metadataProvider = MetadataProviderUtils::autoSelect($this->envs);
        $this->assertInstanceOf(
            GaeFlexMetadataProvider::class,
            $metadataProvider
        );
        $metadataProvider = MetadataProviderUtils::autoSelect([]);
        $this->assertInstanceOf(
            EmptyMetadataProvider::class,
            $metadataProvider
        );
    }
}
