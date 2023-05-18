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
        $this->assertEquals($details['id'], $component->getId());
        $this->assertEquals($details['name'], $component->getName());
        $this->assertEquals($details['path'], $component->getPath());
        $this->assertEquals($details['repo_name'], $component->getRepoName());
        $this->assertEquals($details['service_address'], $component->getServiceAddresses());
        $this->assertEquals($details['api_shortnames'], $component->getApiShortnames());
        $this->assertEquals($details['issue_tracker'], $component->getIssueTracker());
        $this->assertEquals($details['package_name'], $component->getPackageName());
        $this->assertEquals($details['release_level'], $component->getReleaseLevel());
        $this->assertEquals($details['client_documentation'], $component->getClientDocumentation());
        $this->assertEquals($details['product_documentation'], $component->getProductDocumentation());
        $this->assertEquals($details['description'], $component->getDescription());
        $this->assertEquals($details['namespaces'], $component->getNamespaces());
        $this->assertEquals($details['reference_documentation_uid'], $component->getReferenceDocumentationUid());
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
                    'repo_name' => 'googleapis/google-cloud-php-bigtable',
                    'service_address' => ['bigtableadmin.googleapis.com', 'bigtable.googleapis.com'],
                    'api_shortnames' => ['bigtableadmin', 'bigtable'],
                    'issue_tracker' => 'https://github.com/googleapis/google-cloud-php-bigtable/issues',
                    'package_name' => 'google/cloud-bigtable',
                    'release_level' => 'stable',
                    'client_documentation' => 'https://cloud.google.com/php/docs/reference/cloud-bigtable/latest',
                    'product_documentation' => '',
                    'description' => 'Cloud Bigtable Client for PHP',
                    'namespaces' => ['Google\Cloud\Bigtable'],
                    'reference_documentation_uid' => 'google-cloud-bigtable',
                ]
            ],
        ];
    }
}