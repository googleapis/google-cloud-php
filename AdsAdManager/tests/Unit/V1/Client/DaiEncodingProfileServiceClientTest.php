<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\BatchActivateDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchActivateDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\BatchArchiveDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchArchiveDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\BatchCreateDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchCreateDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\BatchUpdateDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\BatchUpdateDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\Client\DaiEncodingProfileServiceClient;
use Google\Ads\AdManager\V1\ContainerTypeEnum\ContainerType;
use Google\Ads\AdManager\V1\CreateDaiEncodingProfileRequest;
use Google\Ads\AdManager\V1\DaiEncodingProfile;
use Google\Ads\AdManager\V1\DaiEncodingProfileVariantTypeEnum\DaiEncodingProfileVariantType;
use Google\Ads\AdManager\V1\GetDaiEncodingProfileRequest;
use Google\Ads\AdManager\V1\ListDaiEncodingProfilesRequest;
use Google\Ads\AdManager\V1\ListDaiEncodingProfilesResponse;
use Google\Ads\AdManager\V1\UpdateDaiEncodingProfileRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class DaiEncodingProfileServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return DaiEncodingProfileServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DaiEncodingProfileServiceClient($options);
    }

    /** @test */
    public function batchActivateDaiEncodingProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateDaiEncodingProfilesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchActivateDaiEncodingProfiles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/BatchActivateDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateDaiEncodingProfilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchActivateDaiEncodingProfiles($request);
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
    public function batchArchiveDaiEncodingProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchArchiveDaiEncodingProfilesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchArchiveDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchArchiveDaiEncodingProfiles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/BatchArchiveDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchArchiveDaiEncodingProfilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchArchiveDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchArchiveDaiEncodingProfiles($request);
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
    public function batchCreateDaiEncodingProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateDaiEncodingProfilesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateDaiEncodingProfiles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/BatchCreateDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateDaiEncodingProfilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateDaiEncodingProfiles($request);
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
    public function batchUpdateDaiEncodingProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateDaiEncodingProfilesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateDaiEncodingProfiles($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/BatchUpdateDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateDaiEncodingProfilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateDaiEncodingProfiles($request);
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
    public function createDaiEncodingProfileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DaiEncodingProfile();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $daiEncodingProfile = new DaiEncodingProfile();
        $daiEncodingProfileDisplayName = 'daiEncodingProfileDisplayName-637836189';
        $daiEncodingProfile->setDisplayName($daiEncodingProfileDisplayName);
        $daiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setVariantType($daiEncodingProfileVariantType);
        $daiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setContainerType($daiEncodingProfileContainerType);
        $request = (new CreateDaiEncodingProfileRequest())
            ->setParent($formattedParent)
            ->setDaiEncodingProfile($daiEncodingProfile);
        $response = $gapicClient->createDaiEncodingProfile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/CreateDaiEncodingProfile',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDaiEncodingProfile();
        $this->assertProtobufEquals($daiEncodingProfile, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDaiEncodingProfileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $daiEncodingProfile = new DaiEncodingProfile();
        $daiEncodingProfileDisplayName = 'daiEncodingProfileDisplayName-637836189';
        $daiEncodingProfile->setDisplayName($daiEncodingProfileDisplayName);
        $daiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setVariantType($daiEncodingProfileVariantType);
        $daiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setContainerType($daiEncodingProfileContainerType);
        $request = (new CreateDaiEncodingProfileRequest())
            ->setParent($formattedParent)
            ->setDaiEncodingProfile($daiEncodingProfile);
        try {
            $gapicClient->createDaiEncodingProfile($request);
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
    public function getDaiEncodingProfileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DaiEncodingProfile();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->daiEncodingProfileName('[NETWORK_CODE]', '[DAI_ENCODING_PROFILE]');
        $request = (new GetDaiEncodingProfileRequest())->setName($formattedName);
        $response = $gapicClient->getDaiEncodingProfile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.DaiEncodingProfileService/GetDaiEncodingProfile', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDaiEncodingProfileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->daiEncodingProfileName('[NETWORK_CODE]', '[DAI_ENCODING_PROFILE]');
        $request = (new GetDaiEncodingProfileRequest())->setName($formattedName);
        try {
            $gapicClient->getDaiEncodingProfile($request);
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
    public function listDaiEncodingProfilesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $daiEncodingProfilesElement = new DaiEncodingProfile();
        $daiEncodingProfiles = [$daiEncodingProfilesElement];
        $expectedResponse = new ListDaiEncodingProfilesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setDaiEncodingProfiles($daiEncodingProfiles);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListDaiEncodingProfilesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDaiEncodingProfiles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDaiEncodingProfiles()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/ListDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDaiEncodingProfilesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListDaiEncodingProfilesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDaiEncodingProfiles($request);
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
    public function updateDaiEncodingProfileTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new DaiEncodingProfile();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $daiEncodingProfile = new DaiEncodingProfile();
        $daiEncodingProfileDisplayName = 'daiEncodingProfileDisplayName-637836189';
        $daiEncodingProfile->setDisplayName($daiEncodingProfileDisplayName);
        $daiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setVariantType($daiEncodingProfileVariantType);
        $daiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setContainerType($daiEncodingProfileContainerType);
        $request = (new UpdateDaiEncodingProfileRequest())->setDaiEncodingProfile($daiEncodingProfile);
        $response = $gapicClient->updateDaiEncodingProfile($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/UpdateDaiEncodingProfile',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getDaiEncodingProfile();
        $this->assertProtobufEquals($daiEncodingProfile, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDaiEncodingProfileExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $daiEncodingProfile = new DaiEncodingProfile();
        $daiEncodingProfileDisplayName = 'daiEncodingProfileDisplayName-637836189';
        $daiEncodingProfile->setDisplayName($daiEncodingProfileDisplayName);
        $daiEncodingProfileVariantType = DaiEncodingProfileVariantType::DAI_ENCODING_PROFILE_VARIANT_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setVariantType($daiEncodingProfileVariantType);
        $daiEncodingProfileContainerType = ContainerType::CONTAINER_TYPE_UNSPECIFIED;
        $daiEncodingProfile->setContainerType($daiEncodingProfileContainerType);
        $request = (new UpdateDaiEncodingProfileRequest())->setDaiEncodingProfile($daiEncodingProfile);
        try {
            $gapicClient->updateDaiEncodingProfile($request);
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
    public function batchActivateDaiEncodingProfilesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateDaiEncodingProfilesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateDaiEncodingProfilesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchActivateDaiEncodingProfilesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.DaiEncodingProfileService/BatchActivateDaiEncodingProfiles',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
