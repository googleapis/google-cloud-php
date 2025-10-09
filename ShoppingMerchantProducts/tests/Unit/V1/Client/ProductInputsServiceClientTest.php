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

namespace Google\Shopping\Merchant\Products\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Products\V1\Client\ProductInputsServiceClient;
use Google\Shopping\Merchant\Products\V1\DeleteProductInputRequest;
use Google\Shopping\Merchant\Products\V1\InsertProductInputRequest;
use Google\Shopping\Merchant\Products\V1\ProductInput;
use Google\Shopping\Merchant\Products\V1\UpdateProductInputRequest;
use stdClass;

/**
 * @group products
 *
 * @group gapic
 */
class ProductInputsServiceClientTest extends GeneratedTest
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

    /** @return ProductInputsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ProductInputsServiceClient($options);
    }

    /** @test */
    public function deleteProductInputTest()
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
        $formattedName = $gapicClient->productInputName('[ACCOUNT]', '[PRODUCTINPUT]');
        $dataSource = 'dataSource-1333894576';
        $request = (new DeleteProductInputRequest())->setName($formattedName)->setDataSource($dataSource);
        $gapicClient->deleteProductInput($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.products.v1.ProductInputsService/DeleteProductInput',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteProductInputExceptionTest()
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
        $formattedName = $gapicClient->productInputName('[ACCOUNT]', '[PRODUCTINPUT]');
        $dataSource = 'dataSource-1333894576';
        $request = (new DeleteProductInputRequest())->setName($formattedName)->setDataSource($dataSource);
        try {
            $gapicClient->deleteProductInput($request);
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
    public function insertProductInputTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $product = 'product-309474065';
        $legacyLocal = false;
        $offerId = 'offerId-768546338';
        $contentLanguage = 'contentLanguage-1408137122';
        $feedLabel = 'feedLabel574920979';
        $versionNumber = 135927952;
        $expectedResponse = new ProductInput();
        $expectedResponse->setName($name);
        $expectedResponse->setProduct($product);
        $expectedResponse->setLegacyLocal($legacyLocal);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setFeedLabel($feedLabel);
        $expectedResponse->setVersionNumber($versionNumber);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $productInput = new ProductInput();
        $productInputOfferId = 'productInputOfferId-2885636';
        $productInput->setOfferId($productInputOfferId);
        $productInputContentLanguage = 'productInputContentLanguage-1069389482';
        $productInput->setContentLanguage($productInputContentLanguage);
        $productInputFeedLabel = 'productInputFeedLabel-2084228581';
        $productInput->setFeedLabel($productInputFeedLabel);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertProductInputRequest())
            ->setParent($formattedParent)
            ->setProductInput($productInput)
            ->setDataSource($dataSource);
        $response = $gapicClient->insertProductInput($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.products.v1.ProductInputsService/InsertProductInput',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getProductInput();
        $this->assertProtobufEquals($productInput, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertProductInputExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $productInput = new ProductInput();
        $productInputOfferId = 'productInputOfferId-2885636';
        $productInput->setOfferId($productInputOfferId);
        $productInputContentLanguage = 'productInputContentLanguage-1069389482';
        $productInput->setContentLanguage($productInputContentLanguage);
        $productInputFeedLabel = 'productInputFeedLabel-2084228581';
        $productInput->setFeedLabel($productInputFeedLabel);
        $dataSource = 'dataSource-1333894576';
        $request = (new InsertProductInputRequest())
            ->setParent($formattedParent)
            ->setProductInput($productInput)
            ->setDataSource($dataSource);
        try {
            $gapicClient->insertProductInput($request);
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
    public function updateProductInputTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $product = 'product-309474065';
        $legacyLocal = false;
        $offerId = 'offerId-768546338';
        $contentLanguage = 'contentLanguage-1408137122';
        $feedLabel = 'feedLabel574920979';
        $versionNumber = 135927952;
        $expectedResponse = new ProductInput();
        $expectedResponse->setName($name);
        $expectedResponse->setProduct($product);
        $expectedResponse->setLegacyLocal($legacyLocal);
        $expectedResponse->setOfferId($offerId);
        $expectedResponse->setContentLanguage($contentLanguage);
        $expectedResponse->setFeedLabel($feedLabel);
        $expectedResponse->setVersionNumber($versionNumber);
        $transport->addResponse($expectedResponse);
        // Mock request
        $productInput = new ProductInput();
        $productInputOfferId = 'productInputOfferId-2885636';
        $productInput->setOfferId($productInputOfferId);
        $productInputContentLanguage = 'productInputContentLanguage-1069389482';
        $productInput->setContentLanguage($productInputContentLanguage);
        $productInputFeedLabel = 'productInputFeedLabel-2084228581';
        $productInput->setFeedLabel($productInputFeedLabel);
        $dataSource = 'dataSource-1333894576';
        $request = (new UpdateProductInputRequest())->setProductInput($productInput)->setDataSource($dataSource);
        $response = $gapicClient->updateProductInput($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.products.v1.ProductInputsService/UpdateProductInput',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getProductInput();
        $this->assertProtobufEquals($productInput, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateProductInputExceptionTest()
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
        $productInput = new ProductInput();
        $productInputOfferId = 'productInputOfferId-2885636';
        $productInput->setOfferId($productInputOfferId);
        $productInputContentLanguage = 'productInputContentLanguage-1069389482';
        $productInput->setContentLanguage($productInputContentLanguage);
        $productInputFeedLabel = 'productInputFeedLabel-2084228581';
        $productInput->setFeedLabel($productInputFeedLabel);
        $dataSource = 'dataSource-1333894576';
        $request = (new UpdateProductInputRequest())->setProductInput($productInput)->setDataSource($dataSource);
        try {
            $gapicClient->updateProductInput($request);
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
    public function deleteProductInputAsyncTest()
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
        $formattedName = $gapicClient->productInputName('[ACCOUNT]', '[PRODUCTINPUT]');
        $dataSource = 'dataSource-1333894576';
        $request = (new DeleteProductInputRequest())->setName($formattedName)->setDataSource($dataSource);
        $gapicClient->deleteProductInputAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.products.v1.ProductInputsService/DeleteProductInput',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
