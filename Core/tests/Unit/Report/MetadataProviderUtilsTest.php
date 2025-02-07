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

namespace Google\Cloud\Core\Tests\Unit\Report;

use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Compute\Metadata\Readers\ReaderInterface;
use Google\Cloud\Core\Report\CloudRunJobMetadataProvider;
use Google\Cloud\Core\Report\CloudRunServiceMetadataProvider;
use Google\Cloud\Core\Report\EmptyMetadataProvider;
use Google\Cloud\Core\Report\GAEFlexMetadataProvider;
use Google\Cloud\Core\Report\GAEStandardMetadataProvider;
use Google\Cloud\Core\Report\MetadataProviderUtils;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class MetadataProviderUtilsTest extends TestCase
{
    private $envs = ['GAE_SERVICE' => 'my-service'];
    private $std_envs = ['GAE_SERVICE' => 'my-service', 'GAE_ENV' => 'standard'];
    private $configuration;
    private $jobName;

    protected function setUp(): void
    {
        $this->configuration = \getenv('K_CONFIGURATION');
        $this->jobName = \getenv('CLOUD_RUN_JOB');
    }

    protected function tearDown(): void
    {
        \putenv('K_CONFIGURATION=' . $this->configuration);
        \putenv('CLOUD_RUN_JOB=' . $this->jobName);
    }

    public function testAutoSelect()
    {
        $metadataProvider = MetadataProviderUtils::autoSelect($this->envs);
        $this->assertInstanceOf(
            GAEFlexMetadataProvider::class,
            $metadataProvider
        );
        $metadataProvider = MetadataProviderUtils::autoSelect($this->std_envs);
        $this->assertInstanceOf(
            GAEStandardMetadataProvider::class,
            $metadataProvider
        );
        $metadataProvider = MetadataProviderUtils::autoSelect([]);
        $this->assertInstanceOf(
            EmptyMetadataProvider::class,
            $metadataProvider
        );
    }

    public function testAutoSelectReturnsCloudRunJobMetadataProvider(): void
    {
        \putenv('CLOUD_RUN_JOB=my-job');
        $metadataProvider = MetadataProviderUtils::autoSelect(
            [],
            new Metadata(self::createStub(ReaderInterface::class))
        );
        $this->assertInstanceOf(
            CloudRunJobMetadataProvider::class,
            $metadataProvider
        );
    }

    public function testAutoSelectReturnsCloudRunServiceMetadataProvider(): void
    {
        \putenv('K_CONFIGURATION=my-configuration');
        $metadataProvider = MetadataProviderUtils::autoSelect(
            [],
            new Metadata(self::createStub(ReaderInterface::class))
        );
        $this->assertInstanceOf(
            CloudRunServiceMetadataProvider::class,
            $metadataProvider
        );
    }
}
