<?php
/*
 * Copyright 2023 Google LLC
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

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\WebSecurityScanner\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\WebSecurityScanner\V1\Client\WebSecurityScannerClient;
use Google\Cloud\WebSecurityScanner\V1\CrawledUrl;
use Google\Cloud\WebSecurityScanner\V1\CreateScanConfigRequest;
use Google\Cloud\WebSecurityScanner\V1\DeleteScanConfigRequest;
use Google\Cloud\WebSecurityScanner\V1\Finding;
use Google\Cloud\WebSecurityScanner\V1\GetFindingRequest;
use Google\Cloud\WebSecurityScanner\V1\GetScanConfigRequest;
use Google\Cloud\WebSecurityScanner\V1\GetScanRunRequest;
use Google\Cloud\WebSecurityScanner\V1\ListCrawledUrlsRequest;
use Google\Cloud\WebSecurityScanner\V1\ListCrawledUrlsResponse;
use Google\Cloud\WebSecurityScanner\V1\ListFindingTypeStatsRequest;
use Google\Cloud\WebSecurityScanner\V1\ListFindingTypeStatsResponse;
use Google\Cloud\WebSecurityScanner\V1\ListFindingsRequest;
use Google\Cloud\WebSecurityScanner\V1\ListFindingsResponse;
use Google\Cloud\WebSecurityScanner\V1\ListScanConfigsRequest;
use Google\Cloud\WebSecurityScanner\V1\ListScanConfigsResponse;
use Google\Cloud\WebSecurityScanner\V1\ListScanRunsRequest;
use Google\Cloud\WebSecurityScanner\V1\ListScanRunsResponse;
use Google\Cloud\WebSecurityScanner\V1\ScanConfig;
use Google\Cloud\WebSecurityScanner\V1\ScanRun;
use Google\Cloud\WebSecurityScanner\V1\StartScanRunRequest;
use Google\Cloud\WebSecurityScanner\V1\StopScanRunRequest;
use Google\Cloud\WebSecurityScanner\V1\UpdateScanConfigRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group websecurityscanner
 *
 * @group gapic
 */
class WebSecurityScannerClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return WebSecurityScannerClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new WebSecurityScannerClient($options);
    }

    /** @test */
    public function createScanConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $maxQps = 844445913;
        $managedScan = false;
        $staticIpScan = true;
        $ignoreHttpStatusErrors = true;
        $expectedResponse = new ScanConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxQps($maxQps);
        $expectedResponse->setManagedScan($managedScan);
        $expectedResponse->setStaticIpScan($staticIpScan);
        $expectedResponse->setIgnoreHttpStatusErrors($ignoreHttpStatusErrors);
        $transport->addResponse($expectedResponse);
        $request = new CreateScanConfigRequest();
        $response = $gapicClient->createScanConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/CreateScanConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createScanConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new CreateScanConfigRequest();
        try {
            $gapicClient->createScanConfig($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteScanConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteScanConfigRequest();
        $gapicClient->deleteScanConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/DeleteScanConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteScanConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new DeleteScanConfigRequest();
        try {
            $gapicClient->deleteScanConfig($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $findingType = 'findingType274496048';
        $httpMethod = 'httpMethod820747384';
        $fuzzedUrl = 'fuzzedUrl-2120677666';
        $body = 'body3029410';
        $description = 'description-1724546052';
        $reproductionUrl = 'reproductionUrl-244934180';
        $frameUrl = 'frameUrl545464221';
        $finalUrl = 'finalUrl355601190';
        $trackingId = 'trackingId1878901667';
        $expectedResponse = new Finding();
        $expectedResponse->setName($name2);
        $expectedResponse->setFindingType($findingType);
        $expectedResponse->setHttpMethod($httpMethod);
        $expectedResponse->setFuzzedUrl($fuzzedUrl);
        $expectedResponse->setBody($body);
        $expectedResponse->setDescription($description);
        $expectedResponse->setReproductionUrl($reproductionUrl);
        $expectedResponse->setFrameUrl($frameUrl);
        $expectedResponse->setFinalUrl($finalUrl);
        $expectedResponse->setTrackingId($trackingId);
        $transport->addResponse($expectedResponse);
        $request = new GetFindingRequest();
        $response = $gapicClient->getFinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetFinding', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFindingExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new GetFindingRequest();
        try {
            $gapicClient->getFinding($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getScanConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $maxQps = 844445913;
        $managedScan = false;
        $staticIpScan = true;
        $ignoreHttpStatusErrors = true;
        $expectedResponse = new ScanConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxQps($maxQps);
        $expectedResponse->setManagedScan($managedScan);
        $expectedResponse->setStaticIpScan($staticIpScan);
        $expectedResponse->setIgnoreHttpStatusErrors($ignoreHttpStatusErrors);
        $transport->addResponse($expectedResponse);
        $request = new GetScanConfigRequest();
        $response = $gapicClient->getScanConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetScanConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getScanConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new GetScanConfigRequest();
        try {
            $gapicClient->getScanConfig($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getScanRunTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $urlsCrawledCount = 1749797253;
        $urlsTestedCount = 1498664068;
        $hasVulnerabilities = false;
        $progressPercent = 2137894861;
        $expectedResponse = new ScanRun();
        $expectedResponse->setName($name2);
        $expectedResponse->setUrlsCrawledCount($urlsCrawledCount);
        $expectedResponse->setUrlsTestedCount($urlsTestedCount);
        $expectedResponse->setHasVulnerabilities($hasVulnerabilities);
        $expectedResponse->setProgressPercent($progressPercent);
        $transport->addResponse($expectedResponse);
        $request = new GetScanRunRequest();
        $response = $gapicClient->getScanRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetScanRun', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getScanRunExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new GetScanRunRequest();
        try {
            $gapicClient->getScanRun($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCrawledUrlsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $crawledUrlsElement = new CrawledUrl();
        $crawledUrls = [
            $crawledUrlsElement,
        ];
        $expectedResponse = new ListCrawledUrlsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCrawledUrls($crawledUrls);
        $transport->addResponse($expectedResponse);
        $request = new ListCrawledUrlsRequest();
        $response = $gapicClient->listCrawledUrls($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCrawledUrls()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListCrawledUrls', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCrawledUrlsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new ListCrawledUrlsRequest();
        try {
            $gapicClient->listCrawledUrls($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingTypeStatsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListFindingTypeStatsResponse();
        $transport->addResponse($expectedResponse);
        $request = new ListFindingTypeStatsRequest();
        $response = $gapicClient->listFindingTypeStats($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListFindingTypeStats', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingTypeStatsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new ListFindingTypeStatsRequest();
        try {
            $gapicClient->listFindingTypeStats($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $findingsElement = new Finding();
        $findings = [
            $findingsElement,
        ];
        $expectedResponse = new ListFindingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFindings($findings);
        $transport->addResponse($expectedResponse);
        $request = new ListFindingsRequest();
        $response = $gapicClient->listFindings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFindings()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListFindings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new ListFindingsRequest();
        try {
            $gapicClient->listFindings($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listScanConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $scanConfigsElement = new ScanConfig();
        $scanConfigs = [
            $scanConfigsElement,
        ];
        $expectedResponse = new ListScanConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setScanConfigs($scanConfigs);
        $transport->addResponse($expectedResponse);
        $request = new ListScanConfigsRequest();
        $response = $gapicClient->listScanConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getScanConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListScanConfigs', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listScanConfigsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new ListScanConfigsRequest();
        try {
            $gapicClient->listScanConfigs($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listScanRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $scanRunsElement = new ScanRun();
        $scanRuns = [
            $scanRunsElement,
        ];
        $expectedResponse = new ListScanRunsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setScanRuns($scanRuns);
        $transport->addResponse($expectedResponse);
        $request = new ListScanRunsRequest();
        $response = $gapicClient->listScanRuns($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getScanRuns()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListScanRuns', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listScanRunsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new ListScanRunsRequest();
        try {
            $gapicClient->listScanRuns($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startScanRunTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $urlsCrawledCount = 1749797253;
        $urlsTestedCount = 1498664068;
        $hasVulnerabilities = false;
        $progressPercent = 2137894861;
        $expectedResponse = new ScanRun();
        $expectedResponse->setName($name2);
        $expectedResponse->setUrlsCrawledCount($urlsCrawledCount);
        $expectedResponse->setUrlsTestedCount($urlsTestedCount);
        $expectedResponse->setHasVulnerabilities($hasVulnerabilities);
        $expectedResponse->setProgressPercent($progressPercent);
        $transport->addResponse($expectedResponse);
        $request = new StartScanRunRequest();
        $response = $gapicClient->startScanRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/StartScanRun', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startScanRunExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new StartScanRunRequest();
        try {
            $gapicClient->startScanRun($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function stopScanRunTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $urlsCrawledCount = 1749797253;
        $urlsTestedCount = 1498664068;
        $hasVulnerabilities = false;
        $progressPercent = 2137894861;
        $expectedResponse = new ScanRun();
        $expectedResponse->setName($name2);
        $expectedResponse->setUrlsCrawledCount($urlsCrawledCount);
        $expectedResponse->setUrlsTestedCount($urlsTestedCount);
        $expectedResponse->setHasVulnerabilities($hasVulnerabilities);
        $expectedResponse->setProgressPercent($progressPercent);
        $transport->addResponse($expectedResponse);
        $request = new StopScanRunRequest();
        $response = $gapicClient->stopScanRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/StopScanRun', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function stopScanRunExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new StopScanRunRequest();
        try {
            $gapicClient->stopScanRun($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateScanConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $maxQps = 844445913;
        $managedScan = false;
        $staticIpScan = true;
        $ignoreHttpStatusErrors = true;
        $expectedResponse = new ScanConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxQps($maxQps);
        $expectedResponse->setManagedScan($managedScan);
        $expectedResponse->setStaticIpScan($staticIpScan);
        $expectedResponse->setIgnoreHttpStatusErrors($ignoreHttpStatusErrors);
        $transport->addResponse($expectedResponse);
        $request = new UpdateScanConfigRequest();
        $response = $gapicClient->updateScanConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/UpdateScanConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateScanConfigExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        $request = new UpdateScanConfigRequest();
        try {
            $gapicClient->updateScanConfig($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createScanConfigAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $maxQps = 844445913;
        $managedScan = false;
        $staticIpScan = true;
        $ignoreHttpStatusErrors = true;
        $expectedResponse = new ScanConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxQps($maxQps);
        $expectedResponse->setManagedScan($managedScan);
        $expectedResponse->setStaticIpScan($staticIpScan);
        $expectedResponse->setIgnoreHttpStatusErrors($ignoreHttpStatusErrors);
        $transport->addResponse($expectedResponse);
        $request = new CreateScanConfigRequest();
        $response = $gapicClient->createScanConfigAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.websecurityscanner.v1.WebSecurityScanner/CreateScanConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
