<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Tests\Unit\Report;

use Google\Cloud\Core\Report\CloudRunMetadataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class CloudRunMetadataProviderTest extends TestCase
{
    public function testMetadataProvider()
    {
        $provider = new CloudRunMetadataProvider([
            'K_SERVICE' => 'my-service',
            'K_REVISION' => 'my-revision'
        ]);
        $this->assertEquals('my-service', $provider->serviceId());
        $this->assertEquals('my-revision', $provider->versionId());
    }

    public function testDefaults()
    {
        $provider = new CloudRunMetadataProvider([]);
        $this->assertEquals('unknown-service', $provider->serviceId());
        $this->assertEquals('unknown-revision', $provider->versionId());
    }
}
