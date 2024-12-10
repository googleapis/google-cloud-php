<?php
/*
 * Copyright 2024 Google LLC
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

namespace Google\Cloud\Support\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Support\V2\CaseClassification;
use Google\Cloud\Support\V2\Client\CaseServiceClient;
use Google\Cloud\Support\V2\CloseCaseRequest;
use Google\Cloud\Support\V2\CreateCaseRequest;
use Google\Cloud\Support\V2\EscalateCaseRequest;
use Google\Cloud\Support\V2\GetCaseRequest;
use Google\Cloud\Support\V2\ListCasesRequest;
use Google\Cloud\Support\V2\ListCasesResponse;
use Google\Cloud\Support\V2\PBCase;
use Google\Cloud\Support\V2\SearchCaseClassificationsRequest;
use Google\Cloud\Support\V2\SearchCaseClassificationsResponse;
use Google\Cloud\Support\V2\SearchCasesRequest;
use Google\Cloud\Support\V2\SearchCasesResponse;
use Google\Cloud\Support\V2\UpdateCaseRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group support
 *
 * @group gapic
 */
class CaseServiceClientTest extends GeneratedTest
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

    /** @return CaseServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CaseServiceClient($options);
    }

    /** @test */
    public function closeCaseTest()
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
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new CloseCaseRequest())
            ->setName($formattedName);
        $response = $gapicClient->closeCase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/CloseCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function closeCaseExceptionTest()
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
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new CloseCaseRequest())
            ->setName($formattedName);
        try {
            $gapicClient->closeCase($request);
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
    public function createCaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $case = new PBCase();
        $request = (new CreateCaseRequest())
            ->setParent($formattedParent)
            ->setCase($case);
        $response = $gapicClient->createCase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/CreateCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCase();
        $this->assertProtobufEquals($case, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCaseExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $case = new PBCase();
        $request = (new CreateCaseRequest())
            ->setParent($formattedParent)
            ->setCase($case);
        try {
            $gapicClient->createCase($request);
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
    public function escalateCaseTest()
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
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new EscalateCaseRequest())
            ->setName($formattedName);
        $response = $gapicClient->escalateCase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/EscalateCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function escalateCaseExceptionTest()
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
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new EscalateCaseRequest())
            ->setName($formattedName);
        try {
            $gapicClient->escalateCase($request);
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
    public function getCaseTest()
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
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new GetCaseRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/GetCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCaseExceptionTest()
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
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new GetCaseRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCase($request);
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
    public function listCasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $casesElement = new PBCase();
        $cases = [
            $casesElement,
        ];
        $expectedResponse = new ListCasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCases($cases);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListCasesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/ListCases', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCasesExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListCasesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCases($request);
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
    public function searchCaseClassificationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $caseClassificationsElement = new CaseClassification();
        $caseClassifications = [
            $caseClassificationsElement,
        ];
        $expectedResponse = new SearchCaseClassificationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCaseClassifications($caseClassifications);
        $transport->addResponse($expectedResponse);
        $request = new SearchCaseClassificationsRequest();
        $response = $gapicClient->searchCaseClassifications($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCaseClassifications()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/SearchCaseClassifications', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchCaseClassificationsExceptionTest()
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
        $request = new SearchCaseClassificationsRequest();
        try {
            $gapicClient->searchCaseClassifications($request);
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
    public function searchCasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $casesElement = new PBCase();
        $cases = [
            $casesElement,
        ];
        $expectedResponse = new SearchCasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCases($cases);
        $transport->addResponse($expectedResponse);
        $request = new SearchCasesRequest();
        $response = $gapicClient->searchCases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/SearchCases', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchCasesExceptionTest()
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
        $request = new SearchCasesRequest();
        try {
            $gapicClient->searchCases($request);
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
    public function updateCaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $case = new PBCase();
        $request = (new UpdateCaseRequest())
            ->setCase($case);
        $response = $gapicClient->updateCase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/UpdateCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getCase();
        $this->assertProtobufEquals($case, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCaseExceptionTest()
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
        $case = new PBCase();
        $request = (new UpdateCaseRequest())
            ->setCase($case);
        try {
            $gapicClient->updateCase($request);
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
    public function closeCaseAsyncTest()
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
        $timeZone = 'timeZone36848094';
        $contactEmail = 'contactEmail947010237';
        $escalated = true;
        $testCase = false;
        $languageCode = 'languageCode-412800396';
        $expectedResponse = new PBCase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTimeZone($timeZone);
        $expectedResponse->setContactEmail($contactEmail);
        $expectedResponse->setEscalated($escalated);
        $expectedResponse->setTestCase($testCase);
        $expectedResponse->setLanguageCode($languageCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->caseName('[ORGANIZATION]', '[CASE]');
        $request = (new CloseCaseRequest())
            ->setName($formattedName);
        $response = $gapicClient->closeCaseAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.support.v2.CaseService/CloseCase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
