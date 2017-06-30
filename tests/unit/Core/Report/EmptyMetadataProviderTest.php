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

/**
 * @group core
 */
class EmptyMetadataProviderTest extends \PHPUnit_Framework_TestCase
{
    private $metadataProvider;

    public function setup()
    {
        $this->metadataProvider = new EmptyMetadataProvider();
    }

    public function testMonitoredResource()
    {
        $this->assertEquals(
            [],
            $this->metadataProvider->monitoredResource()
        );
    }

    public function testProjectId()
    {
        $this->assertEquals('', $this->metadataProvider->projectId());
    }

    public function testServiceId()
    {
        $this->assertEquals('', $this->metadataProvider->serviceId());
    }

    public function testVersionId()
    {
        $this->assertEquals('', $this->metadataProvider->versionId());
    }

    public function testLabels()
    {
        $this->assertEquals([], $this->metadataProvider->labels());
    }
}

