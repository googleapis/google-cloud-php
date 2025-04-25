<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Shopping\Merchant\Productstudio\Tests\Unit\V1alpha\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Productstudio\V1alpha\Client\TextSuggestionsServiceClient;
use Google\Shopping\Merchant\Productstudio\V1alpha\GenerateProductTextSuggestionsRequest;
use Google\Shopping\Merchant\Productstudio\V1alpha\GenerateProductTextSuggestionsResponse;
use Google\Shopping\Merchant\Productstudio\V1alpha\ProductInfo;
use stdClass;

/**
 * @group productstudio
 *
 * @group gapic
 */
class TextSuggestionsServiceClientTest extends GeneratedTest
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

    /** @return TextSuggestionsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TextSuggestionsServiceClient($options);
    }

    /** @test */
    public function generateProductTextSuggestionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GenerateProductTextSuggestionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $productInfo = new ProductInfo();
        $productAttributesValue = 'productAttributesValue934593899';
        $productInfoProductAttributes = [
            'productAttributesKey' => $productAttributesValue,
        ];
        $productInfo->setProductAttributes($productInfoProductAttributes);
        $request = (new GenerateProductTextSuggestionsRequest())->setName($name)->setProductInfo($productInfo);
        $response = $gapicClient->generateProductTextSuggestions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.productstudio.v1alpha.TextSuggestionsService/GenerateProductTextSuggestions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getProductInfo();
        $this->assertProtobufEquals($productInfo, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateProductTextSuggestionsExceptionTest()
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
        $name = 'name3373707';
        $productInfo = new ProductInfo();
        $productAttributesValue = 'productAttributesValue934593899';
        $productInfoProductAttributes = [
            'productAttributesKey' => $productAttributesValue,
        ];
        $productInfo->setProductAttributes($productInfoProductAttributes);
        $request = (new GenerateProductTextSuggestionsRequest())->setName($name)->setProductInfo($productInfo);
        try {
            $gapicClient->generateProductTextSuggestions($request);
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
    public function generateProductTextSuggestionsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GenerateProductTextSuggestionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $productInfo = new ProductInfo();
        $productAttributesValue = 'productAttributesValue934593899';
        $productInfoProductAttributes = [
            'productAttributesKey' => $productAttributesValue,
        ];
        $productInfo->setProductAttributes($productInfoProductAttributes);
        $request = (new GenerateProductTextSuggestionsRequest())->setName($name)->setProductInfo($productInfo);
        $response = $gapicClient->generateProductTextSuggestionsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.productstudio.v1alpha.TextSuggestionsService/GenerateProductTextSuggestions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getProductInfo();
        $this->assertProtobufEquals($productInfo, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
