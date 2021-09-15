<?php
/**
 * Copyright 2021 Google Inc.
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

namespace Google\Cloud\Compute\Tests\System\V1;

use Google\Cloud\Compute\V1\InstancesClient;
use Google\Cloud\Compute\V1\ZonesClient;
use Google\Cloud\Compute\V1\AcceleratorTypesClient;
use PHPUnit\Framework\TestCase;

/**
 * @group compute
 * @group gapic
 */
class PaginationTest extends TestCase
{
    private static $instancesClient;
    private static $acceleratorTypesClient;
    private static $zonesClient;
    private static $projectId;
    private static $zone;

    public static function setUpBeforeClass(): void
    {
        self::$projectId = getenv('PROJECT_ID');
        if (self::$projectId === false) {
            self::fail('Environment variable PROJECT_ID must be set for smoke test');
        }
        self::$instancesClient = new InstancesClient();
        self::$zonesClient = new ZonesClient();
        self::$acceleratorTypesClient = new AcceleratorTypesClient();
        self::$zone = 'us-central1-a';
    }

    public static function tearDownAfterClass(): void
    {
        self::$instancesClient->close();
        self::$zonesClient->close();
        self::$acceleratorTypesClient->close();
    }

    public function testPageToken()
    {
        $response = self::$zonesClient->list(
            self::$projectId,
            ['maxResults' => 5]
        );
        $page = $response->getPage();
        $pageToken = $page->getNextPageToken();
        $nextPage = self::$zonesClient->list(
            self::$projectId,
            ['pageToken'=>$pageToken, 'maxResults' => 5]
        )->getPage();
        $arrToken = iterator_to_array($nextPage->getIterator());
        $arr = iterator_to_array($page->getNextPage(5)->getIterator());
        self::assertEquals($arr, $arrToken);
    }

    public function testNextPage()
    {
        $response = self::$zonesClient->list(
            self::$projectId,
            ['maxResults' => 1]
        );
        $page = $response->getPage();
        $nextPage = $page->getNextPage(1);
        $content = iterator_to_array($page->getIterator());
        $nextContent = iterator_to_array($nextPage->getIterator());
        self::assertNotEquals($content, $nextContent);
    }

    public function  testNextPageSize()
    {
        $response = self::$zonesClient->list(
            self::$projectId,
            ['maxResults' => 5]
        );
        $page = $response->getPage();
        $nextPage = $page->getNextPage(1);
        $nextContent = iterator_to_array($nextPage->getIterator());
        self::assertCount(1, $nextContent);
    }

    public function testMaxResults()
    {
        $response = self::$zonesClient->list(
            self::$projectId,
            ['maxResults' => 10]
        );
        $page = $response->getPage();
        $arr = iterator_to_array($page->getIterator());
        self::assertCount(10, $arr);
    }

    public function testAutoPaginationList()
    {
        $response = self::$acceleratorTypesClient->list(
            self::$projectId,
            self::$zone,
            ['maxResults' => 2]
        );
        $presented = false;
        foreach ($response->iterateAllElements() as $element){
            if ($element->getName() == 'nvidia-tesla-t4'){
                $presented = true;
            }
        }
        self::assertTrue($presented);
    }

    public function testAutoPaginationMapResponse()
    {
        $response = self::$acceleratorTypesClient->aggregatedList(
            self::$projectId,
            ['maxResults' => 2]
        );
        $presented = false;
        foreach ($response->iterateAllElements() as $zone => $element){
            $types = $element->getAcceleratorTypes();
            foreach ($types as $type){
                if ($type->getName() == 'nvidia-tesla-t4'){
                    $presented = true;
                }
            }
        }
        self::assertTrue($presented);
    }

    public function testAggregatedPageToken()
    {
        $response = self::$instancesClient->aggregatedList(
            self::$projectId,
            ['maxResults' => 2]
        );
        $page = $response->getPage();
        $pageToken = $page->getNextPageToken();
        $nextPage = self::$instancesClient->aggregatedList(
            self::$projectId,
            ['pageToken'=>$pageToken, 'maxResults' => 2]
        )->getPage();
        $arrToken = iterator_to_array($nextPage->getIterator());
        $arr = iterator_to_array($page->getNextPage(2)->getIterator());
        self::assertEquals($arr, $arrToken);
    }

    public function testAggregatedNextPage()
    {
        $response = self::$instancesClient->aggregatedList(
            self::$projectId,
            ['maxResults' => 1]
        );
        $page = $response->getPage();
        $nextPage = $page->getNextPage(1);
        $content = iterator_to_array($page->getIterator());
        $nextContent = iterator_to_array($nextPage->getIterator());
        self::assertNotEquals($content, $nextContent);
    }

    public function  testAggregatedNextPageSize()
    {
        $response = self::$instancesClient->aggregatedList(
            self::$projectId,
            ['maxResults' => 2]
        );
        $page = $response->getPage();
        $nextPage = $page->getNextPage(2);
        $nextContent = [];
        foreach ($nextPage->getIterator() as $zone => $instancesList) {
            $pageResults = iterator_to_array($instancesList->getInstances());
            $nextContent = array_merge($nextContent, $pageResults);
        }
        self::assertCount(2, $nextContent);
    }

    public function testAggregatedMaxResults()
    {
        $response = self::$instancesClient->aggregatedList(
            self::$projectId,
            ['maxResults' => 3]
        );
        $page = $response->getPage();
        $allResults = [];
        foreach ($page->getIterator() as $zone => $instancesList) {
            $zoneResults = iterator_to_array($instancesList->getInstances());
            $allResults = array_merge($allResults, $zoneResults);
        }
        self::assertCount(3, $allResults);
    }
}
