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

namespace Google\Shopping\Css\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Css\V1\Client\CssProductInputsServiceClient;
use Google\Shopping\Css\V1\CssProductInput;
use Google\Shopping\Css\V1\DeleteCssProductInputRequest;
use Google\Shopping\Css\V1\InsertCssProductInputRequest;
use stdClass;

/**
 * @group css
 *
 * @group gapic
 */
class CssProductInputsServiceClientTest extends GeneratedTest
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

    /** @return CssProductInputsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CssProductInputsServiceClient($options);
    }

    /** @test */
    public function deleteCssProductInputTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cssProductInputName('[ACCOUNT]', '[CSS_PRODUCT_INPUT]');
        $request = (new DeleteCssProductInputRequest())
            ->setName($formattedName);
        $gapicClient->deleteCssProductInput($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.CssProductInputsService/DeleteCssProductInput', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCssProductInputExceptionTest()
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
        $formattedName = $gapicClient->cssProductInputName('[ACCOUNT]', '[CSS_PRODUCT_INPUT]');
        $request = (new DeleteCssProductInputRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteCssProductInput($request);
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
    public function insertCssProductInputTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $finalName = 'finalName-1861489740';
        $rawProvidedId = 'rawProvidedId-845310112';
        $contentLanguage = 'contentLanguage-1408137122';
        $feedLabel = 'feedLabel574920979';
        $expectedResponse = new CssProductInput();
        $expectedResponse->setName($name);
        $expectedResponse->setFinalName($finalName);
        $expectedResponse->setRawProvidedId($rawProvidedId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setFeedLabel($feedLabel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $cssProductInput = new CssProductInput();
        $cssProductInputRawProvidedId = 'cssProductInputRawProvidedId1424807816';
        $cssProductInput->setRawProvidedId($cssProductInputRawProvidedId);
        $cssProductInputContentLanguage = 'cssProductInputContentLanguage-1783585453';
        $cssProductInput->setContentLanguage($cssProductInputContentLanguage);
        $cssProductInputFeedLabel = 'cssProductInputFeedLabel664498136';
        $cssProductInput->setFeedLabel($cssProductInputFeedLabel);
        $feedId = 976011428;
        $request = (new InsertCssProductInputRequest())
            ->setParent($formattedParent)
            ->setCssProductInput($cssProductInput)
            ->setFeedId($feedId);
        $response = $gapicClient->insertCssProductInput($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.CssProductInputsService/InsertCssProductInput', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCssProductInput();
        $this->assertProtobufEquals($cssProductInput, $actualValue);
        $actualValue = $actualRequestObject->getFeedId();
        $this->assertProtobufEquals($feedId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertCssProductInputExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $cssProductInput = new CssProductInput();
        $cssProductInputRawProvidedId = 'cssProductInputRawProvidedId1424807816';
        $cssProductInput->setRawProvidedId($cssProductInputRawProvidedId);
        $cssProductInputContentLanguage = 'cssProductInputContentLanguage-1783585453';
        $cssProductInput->setContentLanguage($cssProductInputContentLanguage);
        $cssProductInputFeedLabel = 'cssProductInputFeedLabel664498136';
        $cssProductInput->setFeedLabel($cssProductInputFeedLabel);
        $feedId = 976011428;
        $request = (new InsertCssProductInputRequest())
            ->setParent($formattedParent)
            ->setCssProductInput($cssProductInput)
            ->setFeedId($feedId);
        try {
            $gapicClient->insertCssProductInput($request);
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
    public function deleteCssProductInputAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cssProductInputName('[ACCOUNT]', '[CSS_PRODUCT_INPUT]');
        $request = (new DeleteCssProductInputRequest())
            ->setName($formattedName);
        $gapicClient->deleteCssProductInputAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.shopping.css.v1.CssProductInputsService/DeleteCssProductInput', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
