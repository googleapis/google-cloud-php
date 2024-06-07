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

namespace Google\Shopping\Merchant\Accounts\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Accounts\V1beta\ClaimHomepageRequest;
use Google\Shopping\Merchant\Accounts\V1beta\Client\HomepageServiceClient;
use Google\Shopping\Merchant\Accounts\V1beta\GetHomepageRequest;
use Google\Shopping\Merchant\Accounts\V1beta\Homepage;
use Google\Shopping\Merchant\Accounts\V1beta\UnclaimHomepageRequest;
use Google\Shopping\Merchant\Accounts\V1beta\UpdateHomepageRequest;
use stdClass;

/**
 * @group accounts
 *
 * @group gapic
 */
class HomepageServiceClientTest extends GeneratedTest
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

    /** @return HomepageServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new HomepageServiceClient($options);
    }

    /** @test */
    public function claimHomepageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uri = 'uri116076';
        $claimed = false;
        $expectedResponse = new Homepage();
        $expectedResponse->setName($name2);
        $expectedResponse->setUri($uri);
        $expectedResponse->setClaimed($claimed);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new ClaimHomepageRequest())->setName($formattedName);
        $response = $gapicClient->claimHomepage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.HomepageService/ClaimHomepage', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function claimHomepageExceptionTest()
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
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new ClaimHomepageRequest())->setName($formattedName);
        try {
            $gapicClient->claimHomepage($request);
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
    public function getHomepageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uri = 'uri116076';
        $claimed = false;
        $expectedResponse = new Homepage();
        $expectedResponse->setName($name2);
        $expectedResponse->setUri($uri);
        $expectedResponse->setClaimed($claimed);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new GetHomepageRequest())->setName($formattedName);
        $response = $gapicClient->getHomepage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.HomepageService/GetHomepage', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getHomepageExceptionTest()
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
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new GetHomepageRequest())->setName($formattedName);
        try {
            $gapicClient->getHomepage($request);
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
    public function unclaimHomepageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uri = 'uri116076';
        $claimed = false;
        $expectedResponse = new Homepage();
        $expectedResponse->setName($name2);
        $expectedResponse->setUri($uri);
        $expectedResponse->setClaimed($claimed);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new UnclaimHomepageRequest())->setName($formattedName);
        $response = $gapicClient->unclaimHomepage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.HomepageService/UnclaimHomepage', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function unclaimHomepageExceptionTest()
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
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new UnclaimHomepageRequest())->setName($formattedName);
        try {
            $gapicClient->unclaimHomepage($request);
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
    public function updateHomepageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $uri = 'uri116076';
        $claimed = false;
        $expectedResponse = new Homepage();
        $expectedResponse->setName($name);
        $expectedResponse->setUri($uri);
        $expectedResponse->setClaimed($claimed);
        $transport->addResponse($expectedResponse);
        // Mock request
        $homepage = new Homepage();
        $homepageUri = 'homepageUri1440042654';
        $homepage->setUri($homepageUri);
        $updateMask = new FieldMask();
        $request = (new UpdateHomepageRequest())->setHomepage($homepage)->setUpdateMask($updateMask);
        $response = $gapicClient->updateHomepage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.HomepageService/UpdateHomepage', $actualFuncCall);
        $actualValue = $actualRequestObject->getHomepage();
        $this->assertProtobufEquals($homepage, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateHomepageExceptionTest()
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
        $homepage = new Homepage();
        $homepageUri = 'homepageUri1440042654';
        $homepage->setUri($homepageUri);
        $updateMask = new FieldMask();
        $request = (new UpdateHomepageRequest())->setHomepage($homepage)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateHomepage($request);
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
    public function claimHomepageAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $uri = 'uri116076';
        $claimed = false;
        $expectedResponse = new Homepage();
        $expectedResponse->setName($name2);
        $expectedResponse->setUri($uri);
        $expectedResponse->setClaimed($claimed);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->homepageName('[ACCOUNT]');
        $request = (new ClaimHomepageRequest())->setName($formattedName);
        $response = $gapicClient->claimHomepageAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.merchant.accounts.v1beta.HomepageService/ClaimHomepage', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
