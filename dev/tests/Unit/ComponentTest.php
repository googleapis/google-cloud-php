<?php
/**
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit;

use Google\Cloud\Dev\Component;
use PHPUnit\Framework\TestCase;

/**
 */
class ComponentTest extends TestCase
{
    public function testGetComponents()
    {
        $components = Component::getComponents();
        $this->assertIsArray($components);
        $this->assertContainsOnlyInstancesOf(Component::class, $components);
    }

    /**
     * @dataProvider provideComponentProperties
     */
    public function testComponentProperties(string $componentName, array $details)
    {
        $component = new Component($componentName);
        foreach ($details as $key => $value) {
            $this->assertEquals($details[$key], $component->{'get' . ucfirst($key)}());
        }
    }

    public function provideComponentProperties()
    {
        return [
            [
                'Bigtable',
                [
                    'id' => 'cloud-bigtable',
                    'name' => 'Bigtable',
                    'path' => realpath(__DIR__ . '/../../../Bigtable'),
                    'repoName' => 'googleapis/google-cloud-php-bigtable',
                    'serviceAddresses' => ['bigtable.googleapis.com', 'bigtableadmin.googleapis.com'],
                    'apiShortnames' => ['bigtable', 'bigtableadmin'],
                    'issueTracker' => 'https://github.com/googleapis/google-cloud-php-bigtable/issues',
                    'packageName' => 'google/cloud-bigtable',
                    'releaseLevel' => 'stable',
                    'clientDocumentation' => 'https://cloud.google.com/php/docs/reference/cloud-bigtable/latest',
                    'productDocumentation' => '',
                    'description' => 'Cloud Bigtable Client for PHP',
                    'namespaces' => ['Google\Cloud\Bigtable' => 'src'],
                    'referenceDocumentationUid' => 'google-cloud-bigtable',
                ]
            ],
            [
                'Talent',
                [
                    'id' => 'cloud-talent',
                    'apiVersions' => ['V4', 'V4beta1'],
                    'protoPackages' => ['google/cloud/talent/v4', 'google/cloud/talent/v4beta1'],
                ]
            ]
        ];
    }
}