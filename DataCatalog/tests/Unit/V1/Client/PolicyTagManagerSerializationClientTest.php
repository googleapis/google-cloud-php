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

namespace Google\Cloud\DataCatalog\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DataCatalog\V1\Client\PolicyTagManagerSerializationClient;
use Google\Cloud\DataCatalog\V1\ExportTaxonomiesRequest;
use Google\Cloud\DataCatalog\V1\ExportTaxonomiesResponse;
use Google\Cloud\DataCatalog\V1\ImportTaxonomiesRequest;
use Google\Cloud\DataCatalog\V1\ImportTaxonomiesResponse;
use Google\Cloud\DataCatalog\V1\ReplaceTaxonomyRequest;
use Google\Cloud\DataCatalog\V1\SerializedTaxonomy;
use Google\Cloud\DataCatalog\V1\Taxonomy;
use Google\Rpc\Code;
use stdClass;

/**
 * @group datacatalog
 *
 * @group gapic
 */
class PolicyTagManagerSerializationClientTest extends GeneratedTest
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

    /** @return PolicyTagManagerSerializationClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new PolicyTagManagerSerializationClient($options);
    }

    /** @test */
    public function exportTaxonomiesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ExportTaxonomiesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedTaxonomies = [
            $gapicClient->taxonomyName('[PROJECT]', '[LOCATION]', '[TAXONOMY]'),
        ];
        $request = (new ExportTaxonomiesRequest())
            ->setParent($formattedParent)
            ->setTaxonomies($formattedTaxonomies);
        $response = $gapicClient->exportTaxonomies($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ExportTaxonomies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTaxonomies();
        $this->assertProtobufEquals($formattedTaxonomies, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function exportTaxonomiesExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedTaxonomies = [
            $gapicClient->taxonomyName('[PROJECT]', '[LOCATION]', '[TAXONOMY]'),
        ];
        $request = (new ExportTaxonomiesRequest())
            ->setParent($formattedParent)
            ->setTaxonomies($formattedTaxonomies);
        try {
            $gapicClient->exportTaxonomies($request);
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
    public function importTaxonomiesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ImportTaxonomiesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ImportTaxonomiesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->importTaxonomies($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ImportTaxonomies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importTaxonomiesExceptionTest()
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
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ImportTaxonomiesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->importTaxonomies($request);
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
    public function replaceTaxonomyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $policyTagCount = 1074340189;
        $expectedResponse = new Taxonomy();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPolicyTagCount($policyTagCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taxonomyName('[PROJECT]', '[LOCATION]', '[TAXONOMY]');
        $serializedTaxonomy = new SerializedTaxonomy();
        $serializedTaxonomyDisplayName = 'serializedTaxonomyDisplayName1493662264';
        $serializedTaxonomy->setDisplayName($serializedTaxonomyDisplayName);
        $request = (new ReplaceTaxonomyRequest())
            ->setName($formattedName)
            ->setSerializedTaxonomy($serializedTaxonomy);
        $response = $gapicClient->replaceTaxonomy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ReplaceTaxonomy', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getSerializedTaxonomy();
        $this->assertProtobufEquals($serializedTaxonomy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function replaceTaxonomyExceptionTest()
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
        // Mock request
        $formattedName = $gapicClient->taxonomyName('[PROJECT]', '[LOCATION]', '[TAXONOMY]');
        $serializedTaxonomy = new SerializedTaxonomy();
        $serializedTaxonomyDisplayName = 'serializedTaxonomyDisplayName1493662264';
        $serializedTaxonomy->setDisplayName($serializedTaxonomyDisplayName);
        $request = (new ReplaceTaxonomyRequest())
            ->setName($formattedName)
            ->setSerializedTaxonomy($serializedTaxonomy);
        try {
            $gapicClient->replaceTaxonomy($request);
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
    public function exportTaxonomiesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ExportTaxonomiesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedTaxonomies = [
            $gapicClient->taxonomyName('[PROJECT]', '[LOCATION]', '[TAXONOMY]'),
        ];
        $request = (new ExportTaxonomiesRequest())
            ->setParent($formattedParent)
            ->setTaxonomies($formattedTaxonomies);
        $response = $gapicClient->exportTaxonomiesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ExportTaxonomies', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTaxonomies();
        $this->assertProtobufEquals($formattedTaxonomies, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
