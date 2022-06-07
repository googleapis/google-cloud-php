<?php
/*
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Monitoring\Tests\Unit\V3;

use Google\Cloud\Monitoring\V3\AlertPolicyServiceClient;
use Google\Cloud\Monitoring\V3\GroupServiceClient;
use Google\Cloud\Monitoring\V3\NotificationChannelServiceClient;
use Google\Cloud\Monitoring\V3\ServiceMonitoringServiceClient;
use Google\Cloud\Monitoring\V3\UptimeCheckServiceClient;
use PHPUnit\Framework\TestCase;

class CustomMethodsTest extends TestCase
{
    public function testProjectName()
    {
        $projectId = 'my-project-id';
        $projectName = 'projects/' . $projectId;
        $this->assertEquals($projectName, AlertPolicyServiceClient::projectName($projectId));
        $this->assertEquals($projectName, GroupServiceClient::projectName($projectId));
        $this->assertEquals($projectName, NotificationChannelServiceClient::projectName($projectId));
        $this->assertEquals($projectName, ServiceMonitoringServiceClient::projectName($projectId));
        $this->assertEquals($projectName, UptimeCheckServiceClient::projectName($projectId));
    }
}