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

namespace Google\Cloud\Channel\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Channel\V1\ActivateEntitlementRequest;
use Google\Cloud\Channel\V1\BillableSku;
use Google\Cloud\Channel\V1\CancelEntitlementRequest;
use Google\Cloud\Channel\V1\ChangeOfferRequest;
use Google\Cloud\Channel\V1\ChangeParametersRequest;
use Google\Cloud\Channel\V1\ChangeRenewalSettingsRequest;
use Google\Cloud\Channel\V1\ChannelPartnerLink;
use Google\Cloud\Channel\V1\ChannelPartnerLinkState;
use Google\Cloud\Channel\V1\ChannelPartnerRepricingConfig;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistRequest;
use Google\Cloud\Channel\V1\CheckCloudIdentityAccountsExistResponse;
use Google\Cloud\Channel\V1\Client\CloudChannelServiceClient;
use Google\Cloud\Channel\V1\CreateChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\CreateChannelPartnerRepricingConfigRequest;
use Google\Cloud\Channel\V1\CreateCustomerRepricingConfigRequest;
use Google\Cloud\Channel\V1\CreateCustomerRequest;
use Google\Cloud\Channel\V1\CreateEntitlementRequest;
use Google\Cloud\Channel\V1\Customer;
use Google\Cloud\Channel\V1\CustomerRepricingConfig;
use Google\Cloud\Channel\V1\DeleteChannelPartnerRepricingConfigRequest;
use Google\Cloud\Channel\V1\DeleteCustomerRepricingConfigRequest;
use Google\Cloud\Channel\V1\DeleteCustomerRequest;
use Google\Cloud\Channel\V1\Entitlement;
use Google\Cloud\Channel\V1\EntitlementChange;
use Google\Cloud\Channel\V1\GetChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\GetChannelPartnerRepricingConfigRequest;
use Google\Cloud\Channel\V1\GetCustomerRepricingConfigRequest;
use Google\Cloud\Channel\V1\GetCustomerRequest;
use Google\Cloud\Channel\V1\GetEntitlementRequest;
use Google\Cloud\Channel\V1\ImportCustomerRequest;
use Google\Cloud\Channel\V1\ListChannelPartnerLinksRequest;
use Google\Cloud\Channel\V1\ListChannelPartnerLinksResponse;
use Google\Cloud\Channel\V1\ListChannelPartnerRepricingConfigsRequest;
use Google\Cloud\Channel\V1\ListChannelPartnerRepricingConfigsResponse;
use Google\Cloud\Channel\V1\ListCustomerRepricingConfigsRequest;
use Google\Cloud\Channel\V1\ListCustomerRepricingConfigsResponse;
use Google\Cloud\Channel\V1\ListCustomersRequest;
use Google\Cloud\Channel\V1\ListCustomersResponse;
use Google\Cloud\Channel\V1\ListEntitlementChangesRequest;
use Google\Cloud\Channel\V1\ListEntitlementChangesResponse;
use Google\Cloud\Channel\V1\ListEntitlementsRequest;
use Google\Cloud\Channel\V1\ListEntitlementsResponse;
use Google\Cloud\Channel\V1\ListOffersRequest;
use Google\Cloud\Channel\V1\ListOffersResponse;
use Google\Cloud\Channel\V1\ListProductsRequest;
use Google\Cloud\Channel\V1\ListProductsResponse;
use Google\Cloud\Channel\V1\ListPurchasableOffersRequest;
use Google\Cloud\Channel\V1\ListPurchasableOffersResponse;
use Google\Cloud\Channel\V1\ListPurchasableSkusRequest;
use Google\Cloud\Channel\V1\ListPurchasableSkusResponse;
use Google\Cloud\Channel\V1\ListSkuGroupBillableSkusRequest;
use Google\Cloud\Channel\V1\ListSkuGroupBillableSkusResponse;
use Google\Cloud\Channel\V1\ListSkuGroupsRequest;
use Google\Cloud\Channel\V1\ListSkuGroupsResponse;
use Google\Cloud\Channel\V1\ListSkusRequest;
use Google\Cloud\Channel\V1\ListSkusResponse;
use Google\Cloud\Channel\V1\ListSubscribersRequest;
use Google\Cloud\Channel\V1\ListSubscribersResponse;
use Google\Cloud\Channel\V1\ListTransferableOffersRequest;
use Google\Cloud\Channel\V1\ListTransferableOffersResponse;
use Google\Cloud\Channel\V1\ListTransferableSkusRequest;
use Google\Cloud\Channel\V1\ListTransferableSkusResponse;
use Google\Cloud\Channel\V1\LookupOfferRequest;
use Google\Cloud\Channel\V1\Offer;
use Google\Cloud\Channel\V1\Product;
use Google\Cloud\Channel\V1\ProvisionCloudIdentityRequest;
use Google\Cloud\Channel\V1\PurchasableOffer;
use Google\Cloud\Channel\V1\PurchasableSku;
use Google\Cloud\Channel\V1\QueryEligibleBillingAccountsRequest;
use Google\Cloud\Channel\V1\QueryEligibleBillingAccountsResponse;
use Google\Cloud\Channel\V1\RebillingBasis;
use Google\Cloud\Channel\V1\RegisterSubscriberRequest;
use Google\Cloud\Channel\V1\RegisterSubscriberResponse;
use Google\Cloud\Channel\V1\RenewalSettings;
use Google\Cloud\Channel\V1\RepricingAdjustment;
use Google\Cloud\Channel\V1\RepricingConfig;
use Google\Cloud\Channel\V1\Sku;
use Google\Cloud\Channel\V1\SkuGroup;
use Google\Cloud\Channel\V1\StartPaidServiceRequest;
use Google\Cloud\Channel\V1\SuspendEntitlementRequest;
use Google\Cloud\Channel\V1\TransferEntitlementsRequest;
use Google\Cloud\Channel\V1\TransferEntitlementsResponse;
use Google\Cloud\Channel\V1\TransferEntitlementsToGoogleRequest;
use Google\Cloud\Channel\V1\TransferableOffer;
use Google\Cloud\Channel\V1\TransferableSku;
use Google\Cloud\Channel\V1\UnregisterSubscriberRequest;
use Google\Cloud\Channel\V1\UnregisterSubscriberResponse;
use Google\Cloud\Channel\V1\UpdateChannelPartnerLinkRequest;
use Google\Cloud\Channel\V1\UpdateChannelPartnerRepricingConfigRequest;
use Google\Cloud\Channel\V1\UpdateCustomerRepricingConfigRequest;
use Google\Cloud\Channel\V1\UpdateCustomerRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Type\Date;
use Google\Type\PostalAddress;
use stdClass;

/**
 * @group channel
 *
 * @group gapic
 */
class CloudChannelServiceClientTest extends GeneratedTest
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

    /** @return CloudChannelServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudChannelServiceClient($options);
    }

    /** @test */
    public function activateEntitlementTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/activateEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/activateEntitlementTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $request = (new ActivateEntitlementRequest())->setName($name);
        $response = $gapicClient->activateEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ActivateEntitlement', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/activateEntitlementTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function activateEntitlementExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/activateEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $request = (new ActivateEntitlementRequest())->setName($name);
        $response = $gapicClient->activateEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/activateEntitlementTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function cancelEntitlementTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/cancelEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/cancelEntitlementTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $request = (new CancelEntitlementRequest())->setName($name);
        $response = $gapicClient->cancelEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/CancelEntitlement', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/cancelEntitlementTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function cancelEntitlementExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/cancelEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $request = (new CancelEntitlementRequest())->setName($name);
        $response = $gapicClient->cancelEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/cancelEntitlementTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeOfferTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeOfferTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer2 = 'offer2-1548812529';
        $purchaseOrderId2 = 'purchaseOrderId2-1437424035';
        $billingAccount2 = 'billingAccount2-596754980';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer2);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId2);
        $expectedResponse->setBillingAccount($billingAccount2);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/changeOfferTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $formattedOffer = $gapicClient->offerName('[ACCOUNT]', '[OFFER]');
        $request = (new ChangeOfferRequest())->setName($name)->setOffer($formattedOffer);
        $response = $gapicClient->changeOffer($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ChangeOffer', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualApiRequestObject->getOffer();
        $this->assertProtobufEquals($formattedOffer, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeOfferTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeOfferExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeOfferTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $formattedOffer = $gapicClient->offerName('[ACCOUNT]', '[OFFER]');
        $request = (new ChangeOfferRequest())->setName($name)->setOffer($formattedOffer);
        $response = $gapicClient->changeOffer($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeOfferTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeParametersTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeParametersTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId2 = 'purchaseOrderId2-1437424035';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId2);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/changeParametersTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $parameters = [];
        $request = (new ChangeParametersRequest())->setName($name)->setParameters($parameters);
        $response = $gapicClient->changeParameters($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ChangeParameters', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualApiRequestObject->getParameters();
        $this->assertProtobufEquals($parameters, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeParametersTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeParametersExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeParametersTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $parameters = [];
        $request = (new ChangeParametersRequest())->setName($name)->setParameters($parameters);
        $response = $gapicClient->changeParameters($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeParametersTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeRenewalSettingsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeRenewalSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/changeRenewalSettingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $renewalSettings = new RenewalSettings();
        $request = (new ChangeRenewalSettingsRequest())->setName($name)->setRenewalSettings($renewalSettings);
        $response = $gapicClient->changeRenewalSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ChangeRenewalSettings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualApiRequestObject->getRenewalSettings();
        $this->assertProtobufEquals($renewalSettings, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeRenewalSettingsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function changeRenewalSettingsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/changeRenewalSettingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $renewalSettings = new RenewalSettings();
        $request = (new ChangeRenewalSettingsRequest())->setName($name)->setRenewalSettings($renewalSettings);
        $response = $gapicClient->changeRenewalSettings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/changeRenewalSettingsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function checkCloudIdentityAccountsExistTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new CheckCloudIdentityAccountsExistResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $domain = 'domain-1326197564';
        $request = (new CheckCloudIdentityAccountsExistRequest())->setParent($parent)->setDomain($domain);
        $response = $gapicClient->checkCloudIdentityAccountsExist($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/CheckCloudIdentityAccountsExist',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getDomain();
        $this->assertProtobufEquals($domain, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function checkCloudIdentityAccountsExistExceptionTest()
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
        $parent = 'parent-995424086';
        $domain = 'domain-1326197564';
        $request = (new CheckCloudIdentityAccountsExistRequest())->setParent($parent)->setDomain($domain);
        try {
            $gapicClient->checkCloudIdentityAccountsExist($request);
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
    public function createChannelPartnerLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $resellerCloudIdentityId = 'resellerCloudIdentityId1410814373';
        $inviteLinkUri = 'inviteLinkUri633336861';
        $publicId = 'publicId1446918833';
        $expectedResponse = new ChannelPartnerLink();
        $expectedResponse->setName($name);
        $expectedResponse->setResellerCloudIdentityId($resellerCloudIdentityId);
        $expectedResponse->setInviteLinkUri($inviteLinkUri);
        $expectedResponse->setPublicId($publicId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $channelPartnerLink = new ChannelPartnerLink();
        $channelPartnerLinkResellerCloudIdentityId = 'channelPartnerLinkResellerCloudIdentityId-321778211';
        $channelPartnerLink->setResellerCloudIdentityId($channelPartnerLinkResellerCloudIdentityId);
        $channelPartnerLinkLinkState = ChannelPartnerLinkState::CHANNEL_PARTNER_LINK_STATE_UNSPECIFIED;
        $channelPartnerLink->setLinkState($channelPartnerLinkLinkState);
        $request = (new CreateChannelPartnerLinkRequest())
            ->setParent($parent)
            ->setChannelPartnerLink($channelPartnerLink);
        $response = $gapicClient->createChannelPartnerLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/CreateChannelPartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getChannelPartnerLink();
        $this->assertProtobufEquals($channelPartnerLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createChannelPartnerLinkExceptionTest()
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
        $parent = 'parent-995424086';
        $channelPartnerLink = new ChannelPartnerLink();
        $channelPartnerLinkResellerCloudIdentityId = 'channelPartnerLinkResellerCloudIdentityId-321778211';
        $channelPartnerLink->setResellerCloudIdentityId($channelPartnerLinkResellerCloudIdentityId);
        $channelPartnerLinkLinkState = ChannelPartnerLinkState::CHANNEL_PARTNER_LINK_STATE_UNSPECIFIED;
        $channelPartnerLink->setLinkState($channelPartnerLinkLinkState);
        $request = (new CreateChannelPartnerLinkRequest())
            ->setParent($parent)
            ->setChannelPartnerLink($channelPartnerLink);
        try {
            $gapicClient->createChannelPartnerLink($request);
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
    public function createChannelPartnerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new ChannelPartnerRepricingConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->channelPartnerLinkName('[ACCOUNT]', '[CHANNEL_PARTNER_LINK]');
        $channelPartnerRepricingConfig = new ChannelPartnerRepricingConfig();
        $channelPartnerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $channelPartnerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $channelPartnerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $channelPartnerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $channelPartnerRepricingConfig->setRepricingConfig($channelPartnerRepricingConfigRepricingConfig);
        $request = (new CreateChannelPartnerRepricingConfigRequest())
            ->setParent($formattedParent)
            ->setChannelPartnerRepricingConfig($channelPartnerRepricingConfig);
        $response = $gapicClient->createChannelPartnerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/CreateChannelPartnerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getChannelPartnerRepricingConfig();
        $this->assertProtobufEquals($channelPartnerRepricingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createChannelPartnerRepricingConfigExceptionTest()
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
        $formattedParent = $gapicClient->channelPartnerLinkName('[ACCOUNT]', '[CHANNEL_PARTNER_LINK]');
        $channelPartnerRepricingConfig = new ChannelPartnerRepricingConfig();
        $channelPartnerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $channelPartnerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $channelPartnerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $channelPartnerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $channelPartnerRepricingConfig->setRepricingConfig($channelPartnerRepricingConfigRepricingConfig);
        $request = (new CreateChannelPartnerRepricingConfigRequest())
            ->setParent($formattedParent)
            ->setChannelPartnerRepricingConfig($channelPartnerRepricingConfig);
        try {
            $gapicClient->createChannelPartnerRepricingConfig($request);
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
    public function createCustomerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $orgDisplayName = 'orgDisplayName-1793830557';
        $alternateEmail = 'alternateEmail2117741463';
        $domain = 'domain-1326197564';
        $cloudIdentityId = 'cloudIdentityId-466684622';
        $languageCode = 'languageCode-412800396';
        $channelPartnerId = 'channelPartnerId-1897289554';
        $correlationId = 'correlationId2055329016';
        $expectedResponse = new Customer();
        $expectedResponse->setName($name);
        $expectedResponse->setOrgDisplayName($orgDisplayName);
        $expectedResponse->setAlternateEmail($alternateEmail);
        $expectedResponse->setDomain($domain);
        $expectedResponse->setCloudIdentityId($cloudIdentityId);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setChannelPartnerId($channelPartnerId);
        $expectedResponse->setCorrelationId($correlationId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $customer = new Customer();
        $customerOrgDisplayName = 'customerOrgDisplayName1748404327';
        $customer->setOrgDisplayName($customerOrgDisplayName);
        $customerOrgPostalAddress = new PostalAddress();
        $customer->setOrgPostalAddress($customerOrgPostalAddress);
        $customerDomain = 'customerDomain1489396290';
        $customer->setDomain($customerDomain);
        $request = (new CreateCustomerRequest())->setParent($parent)->setCustomer($customer);
        $response = $gapicClient->createCustomer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/CreateCustomer', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getCustomer();
        $this->assertProtobufEquals($customer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomerExceptionTest()
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
        $parent = 'parent-995424086';
        $customer = new Customer();
        $customerOrgDisplayName = 'customerOrgDisplayName1748404327';
        $customer->setOrgDisplayName($customerOrgDisplayName);
        $customerOrgPostalAddress = new PostalAddress();
        $customer->setOrgPostalAddress($customerOrgPostalAddress);
        $customerDomain = 'customerDomain1489396290';
        $customer->setDomain($customerDomain);
        $request = (new CreateCustomerRequest())->setParent($parent)->setCustomer($customer);
        try {
            $gapicClient->createCustomer($request);
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
    public function createCustomerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new CustomerRepricingConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $customerRepricingConfig = new CustomerRepricingConfig();
        $customerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $customerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $customerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $customerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $customerRepricingConfig->setRepricingConfig($customerRepricingConfigRepricingConfig);
        $request = (new CreateCustomerRepricingConfigRequest())
            ->setParent($formattedParent)
            ->setCustomerRepricingConfig($customerRepricingConfig);
        $response = $gapicClient->createCustomerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/CreateCustomerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomerRepricingConfig();
        $this->assertProtobufEquals($customerRepricingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomerRepricingConfigExceptionTest()
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
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $customerRepricingConfig = new CustomerRepricingConfig();
        $customerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $customerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $customerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $customerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $customerRepricingConfig->setRepricingConfig($customerRepricingConfigRepricingConfig);
        $request = (new CreateCustomerRepricingConfigRequest())
            ->setParent($formattedParent)
            ->setCustomerRepricingConfig($customerRepricingConfig);
        try {
            $gapicClient->createCustomerRepricingConfig($request);
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
    public function createEntitlementTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createEntitlementTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $entitlement = new Entitlement();
        $entitlementOffer = $gapicClient->offerName('[ACCOUNT]', '[OFFER]');
        $entitlement->setOffer($entitlementOffer);
        $request = (new CreateEntitlementRequest())->setParent($formattedParent)->setEntitlement($entitlement);
        $response = $gapicClient->createEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/CreateEntitlement', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getEntitlement();
        $this->assertProtobufEquals($entitlement, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEntitlementTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function createEntitlementExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $entitlement = new Entitlement();
        $entitlementOffer = $gapicClient->offerName('[ACCOUNT]', '[OFFER]');
        $entitlement->setOffer($entitlementOffer);
        $request = (new CreateEntitlementRequest())->setParent($formattedParent)->setEntitlement($entitlement);
        $response = $gapicClient->createEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createEntitlementTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function deleteChannelPartnerRepricingConfigTest()
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
        $formattedName = $gapicClient->channelPartnerRepricingConfigName(
            '[ACCOUNT]',
            '[CHANNEL_PARTNER]',
            '[CHANNEL_PARTNER_REPRICING_CONFIG]'
        );
        $request = (new DeleteChannelPartnerRepricingConfigRequest())->setName($formattedName);
        $gapicClient->deleteChannelPartnerRepricingConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/DeleteChannelPartnerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteChannelPartnerRepricingConfigExceptionTest()
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
        $formattedName = $gapicClient->channelPartnerRepricingConfigName(
            '[ACCOUNT]',
            '[CHANNEL_PARTNER]',
            '[CHANNEL_PARTNER_REPRICING_CONFIG]'
        );
        $request = (new DeleteChannelPartnerRepricingConfigRequest())->setName($formattedName);
        try {
            $gapicClient->deleteChannelPartnerRepricingConfig($request);
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
    public function deleteCustomerTest()
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
        $formattedName = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new DeleteCustomerRequest())->setName($formattedName);
        $gapicClient->deleteCustomer($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/DeleteCustomer', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCustomerExceptionTest()
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
        $formattedName = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new DeleteCustomerRequest())->setName($formattedName);
        try {
            $gapicClient->deleteCustomer($request);
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
    public function deleteCustomerRepricingConfigTest()
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
        $formattedName = $gapicClient->customerRepricingConfigName(
            '[ACCOUNT]',
            '[CUSTOMER]',
            '[CUSTOMER_REPRICING_CONFIG]'
        );
        $request = (new DeleteCustomerRepricingConfigRequest())->setName($formattedName);
        $gapicClient->deleteCustomerRepricingConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/DeleteCustomerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCustomerRepricingConfigExceptionTest()
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
        $formattedName = $gapicClient->customerRepricingConfigName(
            '[ACCOUNT]',
            '[CUSTOMER]',
            '[CUSTOMER_REPRICING_CONFIG]'
        );
        $request = (new DeleteCustomerRepricingConfigRequest())->setName($formattedName);
        try {
            $gapicClient->deleteCustomerRepricingConfig($request);
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
    public function getChannelPartnerLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $resellerCloudIdentityId = 'resellerCloudIdentityId1410814373';
        $inviteLinkUri = 'inviteLinkUri633336861';
        $publicId = 'publicId1446918833';
        $expectedResponse = new ChannelPartnerLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setResellerCloudIdentityId($resellerCloudIdentityId);
        $expectedResponse->setInviteLinkUri($inviteLinkUri);
        $expectedResponse->setPublicId($publicId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new GetChannelPartnerLinkRequest())->setName($name);
        $response = $gapicClient->getChannelPartnerLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/GetChannelPartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getChannelPartnerLinkExceptionTest()
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
        $request = (new GetChannelPartnerLinkRequest())->setName($name);
        try {
            $gapicClient->getChannelPartnerLink($request);
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
    public function getChannelPartnerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new ChannelPartnerRepricingConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->channelPartnerRepricingConfigName(
            '[ACCOUNT]',
            '[CHANNEL_PARTNER]',
            '[CHANNEL_PARTNER_REPRICING_CONFIG]'
        );
        $request = (new GetChannelPartnerRepricingConfigRequest())->setName($formattedName);
        $response = $gapicClient->getChannelPartnerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/GetChannelPartnerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getChannelPartnerRepricingConfigExceptionTest()
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
        $formattedName = $gapicClient->channelPartnerRepricingConfigName(
            '[ACCOUNT]',
            '[CHANNEL_PARTNER]',
            '[CHANNEL_PARTNER_REPRICING_CONFIG]'
        );
        $request = (new GetChannelPartnerRepricingConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getChannelPartnerRepricingConfig($request);
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
    public function getCustomerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $orgDisplayName = 'orgDisplayName-1793830557';
        $alternateEmail = 'alternateEmail2117741463';
        $domain = 'domain-1326197564';
        $cloudIdentityId = 'cloudIdentityId-466684622';
        $languageCode = 'languageCode-412800396';
        $channelPartnerId = 'channelPartnerId-1897289554';
        $correlationId = 'correlationId2055329016';
        $expectedResponse = new Customer();
        $expectedResponse->setName($name2);
        $expectedResponse->setOrgDisplayName($orgDisplayName);
        $expectedResponse->setAlternateEmail($alternateEmail);
        $expectedResponse->setDomain($domain);
        $expectedResponse->setCloudIdentityId($cloudIdentityId);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setChannelPartnerId($channelPartnerId);
        $expectedResponse->setCorrelationId($correlationId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new GetCustomerRequest())->setName($formattedName);
        $response = $gapicClient->getCustomer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/GetCustomer', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomerExceptionTest()
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
        $formattedName = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new GetCustomerRequest())->setName($formattedName);
        try {
            $gapicClient->getCustomer($request);
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
    public function getCustomerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new CustomerRepricingConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customerRepricingConfigName(
            '[ACCOUNT]',
            '[CUSTOMER]',
            '[CUSTOMER_REPRICING_CONFIG]'
        );
        $request = (new GetCustomerRepricingConfigRequest())->setName($formattedName);
        $response = $gapicClient->getCustomerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/GetCustomerRepricingConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomerRepricingConfigExceptionTest()
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
        $formattedName = $gapicClient->customerRepricingConfigName(
            '[ACCOUNT]',
            '[CUSTOMER]',
            '[CUSTOMER_REPRICING_CONFIG]'
        );
        $request = (new GetCustomerRepricingConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getCustomerRepricingConfig($request);
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
    public function getEntitlementTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new GetEntitlementRequest())->setName($formattedName);
        $response = $gapicClient->getEntitlement($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/GetEntitlement', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEntitlementExceptionTest()
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
        $formattedName = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new GetEntitlementRequest())->setName($formattedName);
        try {
            $gapicClient->getEntitlement($request);
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
    public function importCustomerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $orgDisplayName = 'orgDisplayName-1793830557';
        $alternateEmail = 'alternateEmail2117741463';
        $domain2 = 'domain21129430903';
        $cloudIdentityId = 'cloudIdentityId-466684622';
        $languageCode = 'languageCode-412800396';
        $channelPartnerId2 = 'channelPartnerId22065842401';
        $correlationId = 'correlationId2055329016';
        $expectedResponse = new Customer();
        $expectedResponse->setName($name);
        $expectedResponse->setOrgDisplayName($orgDisplayName);
        $expectedResponse->setAlternateEmail($alternateEmail);
        $expectedResponse->setDomain($domain2);
        $expectedResponse->setCloudIdentityId($cloudIdentityId);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setChannelPartnerId($channelPartnerId2);
        $expectedResponse->setCorrelationId($correlationId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $domain = 'domain-1326197564';
        $parent = 'parent-995424086';
        $overwriteIfExists = true;
        $request = (new ImportCustomerRequest())
            ->setDomain($domain)
            ->setParent($parent)
            ->setOverwriteIfExists($overwriteIfExists);
        $response = $gapicClient->importCustomer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ImportCustomer', $actualFuncCall);
        $actualValue = $actualRequestObject->getDomain();
        $this->assertProtobufEquals($domain, $actualValue);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getOverwriteIfExists();
        $this->assertProtobufEquals($overwriteIfExists, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importCustomerExceptionTest()
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
        $domain = 'domain-1326197564';
        $parent = 'parent-995424086';
        $overwriteIfExists = true;
        $request = (new ImportCustomerRequest())
            ->setDomain($domain)
            ->setParent($parent)
            ->setOverwriteIfExists($overwriteIfExists);
        try {
            $gapicClient->importCustomer($request);
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
    public function listChannelPartnerLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $channelPartnerLinksElement = new ChannelPartnerLink();
        $channelPartnerLinks = [$channelPartnerLinksElement];
        $expectedResponse = new ListChannelPartnerLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setChannelPartnerLinks($channelPartnerLinks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListChannelPartnerLinksRequest())->setParent($parent);
        $response = $gapicClient->listChannelPartnerLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getChannelPartnerLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListChannelPartnerLinks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listChannelPartnerLinksExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new ListChannelPartnerLinksRequest())->setParent($parent);
        try {
            $gapicClient->listChannelPartnerLinks($request);
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
    public function listChannelPartnerRepricingConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $channelPartnerRepricingConfigsElement = new ChannelPartnerRepricingConfig();
        $channelPartnerRepricingConfigs = [$channelPartnerRepricingConfigsElement];
        $expectedResponse = new ListChannelPartnerRepricingConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setChannelPartnerRepricingConfigs($channelPartnerRepricingConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->channelPartnerLinkName('[ACCOUNT]', '[CHANNEL_PARTNER_LINK]');
        $request = (new ListChannelPartnerRepricingConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listChannelPartnerRepricingConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getChannelPartnerRepricingConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/ListChannelPartnerRepricingConfigs',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listChannelPartnerRepricingConfigsExceptionTest()
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
        $formattedParent = $gapicClient->channelPartnerLinkName('[ACCOUNT]', '[CHANNEL_PARTNER_LINK]');
        $request = (new ListChannelPartnerRepricingConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listChannelPartnerRepricingConfigs($request);
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
    public function listCustomerRepricingConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customerRepricingConfigsElement = new CustomerRepricingConfig();
        $customerRepricingConfigs = [$customerRepricingConfigsElement];
        $expectedResponse = new ListCustomerRepricingConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomerRepricingConfigs($customerRepricingConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListCustomerRepricingConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCustomerRepricingConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomerRepricingConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListCustomerRepricingConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomerRepricingConfigsExceptionTest()
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
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListCustomerRepricingConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCustomerRepricingConfigs($request);
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
    public function listCustomersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customersElement = new Customer();
        $customers = [$customersElement];
        $expectedResponse = new ListCustomersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomers($customers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListCustomersRequest())->setParent($parent);
        $response = $gapicClient->listCustomers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListCustomers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomersExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new ListCustomersRequest())->setParent($parent);
        try {
            $gapicClient->listCustomers($request);
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
    public function listEntitlementChangesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $entitlementChangesElement = new EntitlementChange();
        $entitlementChanges = [$entitlementChangesElement];
        $expectedResponse = new ListEntitlementChangesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEntitlementChanges($entitlementChanges);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new ListEntitlementChangesRequest())->setParent($formattedParent);
        $response = $gapicClient->listEntitlementChanges($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEntitlementChanges()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListEntitlementChanges', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEntitlementChangesExceptionTest()
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
        $formattedParent = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new ListEntitlementChangesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listEntitlementChanges($request);
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
    public function listEntitlementsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $entitlementsElement = new Entitlement();
        $entitlements = [$entitlementsElement];
        $expectedResponse = new ListEntitlementsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEntitlements($entitlements);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListEntitlementsRequest())->setParent($formattedParent);
        $response = $gapicClient->listEntitlements($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEntitlements()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListEntitlements', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEntitlementsExceptionTest()
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
        $formattedParent = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListEntitlementsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listEntitlements($request);
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
    public function listOffersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $offersElement = new Offer();
        $offers = [$offersElement];
        $expectedResponse = new ListOffersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOffers($offers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListOffersRequest())->setParent($parent);
        $response = $gapicClient->listOffers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOffers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListOffers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOffersExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new ListOffersRequest())->setParent($parent);
        try {
            $gapicClient->listOffers($request);
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
    public function listProductsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $productsElement = new Product();
        $products = [$productsElement];
        $expectedResponse = new ListProductsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setProducts($products);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = 'account-1177318867';
        $request = (new ListProductsRequest())->setAccount($account);
        $response = $gapicClient->listProducts($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getProducts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListProducts', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listProductsExceptionTest()
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
        $account = 'account-1177318867';
        $request = (new ListProductsRequest())->setAccount($account);
        try {
            $gapicClient->listProducts($request);
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
    public function listPurchasableOffersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $purchasableOffersElement = new PurchasableOffer();
        $purchasableOffers = [$purchasableOffersElement];
        $expectedResponse = new ListPurchasableOffersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPurchasableOffers($purchasableOffers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListPurchasableOffersRequest())->setCustomer($formattedCustomer);
        $response = $gapicClient->listPurchasableOffers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPurchasableOffers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListPurchasableOffers', $actualFuncCall);
        $actualValue = $actualRequestObject->getCustomer();
        $this->assertProtobufEquals($formattedCustomer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPurchasableOffersExceptionTest()
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
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListPurchasableOffersRequest())->setCustomer($formattedCustomer);
        try {
            $gapicClient->listPurchasableOffers($request);
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
    public function listPurchasableSkusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $purchasableSkusElement = new PurchasableSku();
        $purchasableSkus = [$purchasableSkusElement];
        $expectedResponse = new ListPurchasableSkusResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPurchasableSkus($purchasableSkus);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListPurchasableSkusRequest())->setCustomer($formattedCustomer);
        $response = $gapicClient->listPurchasableSkus($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPurchasableSkus()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListPurchasableSkus', $actualFuncCall);
        $actualValue = $actualRequestObject->getCustomer();
        $this->assertProtobufEquals($formattedCustomer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPurchasableSkusExceptionTest()
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
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ListPurchasableSkusRequest())->setCustomer($formattedCustomer);
        try {
            $gapicClient->listPurchasableSkus($request);
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
    public function listSkuGroupBillableSkusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $billableSkusElement = new BillableSku();
        $billableSkus = [$billableSkusElement];
        $expectedResponse = new ListSkuGroupBillableSkusResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBillableSkus($billableSkus);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->skuGroupName('[ACCOUNT]', '[SKU_GROUP]');
        $request = (new ListSkuGroupBillableSkusRequest())->setParent($formattedParent);
        $response = $gapicClient->listSkuGroupBillableSkus($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBillableSkus()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListSkuGroupBillableSkus', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSkuGroupBillableSkusExceptionTest()
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
        $formattedParent = $gapicClient->skuGroupName('[ACCOUNT]', '[SKU_GROUP]');
        $request = (new ListSkuGroupBillableSkusRequest())->setParent($formattedParent);
        try {
            $gapicClient->listSkuGroupBillableSkus($request);
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
    public function listSkuGroupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $skuGroupsElement = new SkuGroup();
        $skuGroups = [$skuGroupsElement];
        $expectedResponse = new ListSkuGroupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSkuGroups($skuGroups);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListSkuGroupsRequest())->setParent($parent);
        $response = $gapicClient->listSkuGroups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSkuGroups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListSkuGroups', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSkuGroupsExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new ListSkuGroupsRequest())->setParent($parent);
        try {
            $gapicClient->listSkuGroups($request);
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
    public function listSkusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $skusElement = new Sku();
        $skus = [$skusElement];
        $expectedResponse = new ListSkusResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSkus($skus);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->productName('[PRODUCT]');
        $account = 'account-1177318867';
        $request = (new ListSkusRequest())->setParent($formattedParent)->setAccount($account);
        $response = $gapicClient->listSkus($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSkus()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListSkus', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSkusExceptionTest()
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
        $formattedParent = $gapicClient->productName('[PRODUCT]');
        $account = 'account-1177318867';
        $request = (new ListSkusRequest())->setParent($formattedParent)->setAccount($account);
        try {
            $gapicClient->listSkus($request);
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
    public function listSubscribersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $topic = 'topic110546223';
        $nextPageToken = '';
        $serviceAccountsElement = 'serviceAccountsElement651196397';
        $serviceAccounts = [$serviceAccountsElement];
        $expectedResponse = new ListSubscribersResponse();
        $expectedResponse->setTopic($topic);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setServiceAccounts($serviceAccounts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = 'account-1177318867';
        $request = (new ListSubscribersRequest())->setAccount($account);
        $response = $gapicClient->listSubscribers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getServiceAccounts()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListSubscribers', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSubscribersExceptionTest()
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
        $account = 'account-1177318867';
        $request = (new ListSubscribersRequest())->setAccount($account);
        try {
            $gapicClient->listSubscribers($request);
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
    public function listTransferableOffersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $transferableOffersElement = new TransferableOffer();
        $transferableOffers = [$transferableOffersElement];
        $expectedResponse = new ListTransferableOffersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTransferableOffers($transferableOffers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $sku = 'sku113949';
        $request = (new ListTransferableOffersRequest())->setParent($parent)->setSku($sku);
        $response = $gapicClient->listTransferableOffers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTransferableOffers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListTransferableOffers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getSku();
        $this->assertProtobufEquals($sku, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTransferableOffersExceptionTest()
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
        $parent = 'parent-995424086';
        $sku = 'sku113949';
        $request = (new ListTransferableOffersRequest())->setParent($parent)->setSku($sku);
        try {
            $gapicClient->listTransferableOffers($request);
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
    public function listTransferableSkusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $transferableSkusElement = new TransferableSku();
        $transferableSkus = [$transferableSkusElement];
        $expectedResponse = new ListTransferableSkusResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTransferableSkus($transferableSkus);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new ListTransferableSkusRequest())->setParent($parent);
        $response = $gapicClient->listTransferableSkus($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTransferableSkus()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ListTransferableSkus', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTransferableSkusExceptionTest()
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
        $parent = 'parent-995424086';
        $request = (new ListTransferableSkusRequest())->setParent($parent);
        try {
            $gapicClient->listTransferableSkus($request);
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
    public function lookupOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $dealCode = 'dealCode-1350349344';
        $expectedResponse = new Offer();
        $expectedResponse->setName($name);
        $expectedResponse->setDealCode($dealCode);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedEntitlement = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new LookupOfferRequest())->setEntitlement($formattedEntitlement);
        $response = $gapicClient->lookupOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/LookupOffer', $actualFuncCall);
        $actualValue = $actualRequestObject->getEntitlement();
        $this->assertProtobufEquals($formattedEntitlement, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function lookupOfferExceptionTest()
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
        $formattedEntitlement = $gapicClient->entitlementName('[ACCOUNT]', '[CUSTOMER]', '[ENTITLEMENT]');
        $request = (new LookupOfferRequest())->setEntitlement($formattedEntitlement);
        try {
            $gapicClient->lookupOffer($request);
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
    public function provisionCloudIdentityTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/provisionCloudIdentityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $orgDisplayName = 'orgDisplayName-1793830557';
        $alternateEmail = 'alternateEmail2117741463';
        $domain = 'domain-1326197564';
        $cloudIdentityId = 'cloudIdentityId-466684622';
        $languageCode = 'languageCode-412800396';
        $channelPartnerId = 'channelPartnerId-1897289554';
        $correlationId = 'correlationId2055329016';
        $expectedResponse = new Customer();
        $expectedResponse->setName($name);
        $expectedResponse->setOrgDisplayName($orgDisplayName);
        $expectedResponse->setAlternateEmail($alternateEmail);
        $expectedResponse->setDomain($domain);
        $expectedResponse->setCloudIdentityId($cloudIdentityId);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setChannelPartnerId($channelPartnerId);
        $expectedResponse->setCorrelationId($correlationId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/provisionCloudIdentityTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ProvisionCloudIdentityRequest())->setCustomer($formattedCustomer);
        $response = $gapicClient->provisionCloudIdentity($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ProvisionCloudIdentity', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getCustomer();
        $this->assertProtobufEquals($formattedCustomer, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/provisionCloudIdentityTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function provisionCloudIdentityExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/provisionCloudIdentityTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $request = (new ProvisionCloudIdentityRequest())->setCustomer($formattedCustomer);
        $response = $gapicClient->provisionCloudIdentity($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/provisionCloudIdentityTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function queryEligibleBillingAccountsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new QueryEligibleBillingAccountsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $skus = [];
        $request = (new QueryEligibleBillingAccountsRequest())->setCustomer($formattedCustomer)->setSkus($skus);
        $response = $gapicClient->queryEligibleBillingAccounts($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/QueryEligibleBillingAccounts', $actualFuncCall);
        $actualValue = $actualRequestObject->getCustomer();
        $this->assertProtobufEquals($formattedCustomer, $actualValue);
        $actualValue = $actualRequestObject->getSkus();
        $this->assertProtobufEquals($skus, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryEligibleBillingAccountsExceptionTest()
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
        $formattedCustomer = $gapicClient->customerName('[ACCOUNT]', '[CUSTOMER]');
        $skus = [];
        $request = (new QueryEligibleBillingAccountsRequest())->setCustomer($formattedCustomer)->setSkus($skus);
        try {
            $gapicClient->queryEligibleBillingAccounts($request);
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
    public function registerSubscriberTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $topic = 'topic110546223';
        $expectedResponse = new RegisterSubscriberResponse();
        $expectedResponse->setTopic($topic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = 'account-1177318867';
        $serviceAccount = 'serviceAccount-1948028253';
        $request = (new RegisterSubscriberRequest())->setAccount($account)->setServiceAccount($serviceAccount);
        $response = $gapicClient->registerSubscriber($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/RegisterSubscriber', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getServiceAccount();
        $this->assertProtobufEquals($serviceAccount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function registerSubscriberExceptionTest()
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
        $account = 'account-1177318867';
        $serviceAccount = 'serviceAccount-1948028253';
        $request = (new RegisterSubscriberRequest())->setAccount($account)->setServiceAccount($serviceAccount);
        try {
            $gapicClient->registerSubscriber($request);
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
    public function startPaidServiceTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/startPaidServiceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/startPaidServiceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $request = (new StartPaidServiceRequest())->setName($name);
        $response = $gapicClient->startPaidService($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/StartPaidService', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/startPaidServiceTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function startPaidServiceExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/startPaidServiceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $request = (new StartPaidServiceRequest())->setName($name);
        $response = $gapicClient->startPaidService($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/startPaidServiceTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function suspendEntitlementTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/suspendEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/suspendEntitlementTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $request = (new SuspendEntitlementRequest())->setName($name);
        $response = $gapicClient->suspendEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/SuspendEntitlement', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/suspendEntitlementTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function suspendEntitlementExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/suspendEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $name = 'name3373707';
        $request = (new SuspendEntitlementRequest())->setName($name);
        $response = $gapicClient->suspendEntitlement($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/suspendEntitlementTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function transferEntitlementsTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferEntitlementsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new TransferEntitlementsResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/transferEntitlementsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $parent = 'parent-995424086';
        $entitlements = [];
        $request = (new TransferEntitlementsRequest())->setParent($parent)->setEntitlements($entitlements);
        $response = $gapicClient->transferEntitlements($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/TransferEntitlements', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualApiRequestObject->getEntitlements();
        $this->assertProtobufEquals($entitlements, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferEntitlementsTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function transferEntitlementsExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferEntitlementsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $parent = 'parent-995424086';
        $entitlements = [];
        $request = (new TransferEntitlementsRequest())->setParent($parent)->setEntitlements($entitlements);
        $response = $gapicClient->transferEntitlements($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferEntitlementsTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function transferEntitlementsToGoogleTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferEntitlementsToGoogleTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/transferEntitlementsToGoogleTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $parent = 'parent-995424086';
        $entitlements = [];
        $request = (new TransferEntitlementsToGoogleRequest())->setParent($parent)->setEntitlements($entitlements);
        $response = $gapicClient->transferEntitlementsToGoogle($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/TransferEntitlementsToGoogle',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualApiRequestObject->getEntitlements();
        $this->assertProtobufEquals($entitlements, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferEntitlementsToGoogleTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function transferEntitlementsToGoogleExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/transferEntitlementsToGoogleTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $parent = 'parent-995424086';
        $entitlements = [];
        $request = (new TransferEntitlementsToGoogleRequest())->setParent($parent)->setEntitlements($entitlements);
        $response = $gapicClient->transferEntitlementsToGoogle($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/transferEntitlementsToGoogleTest');
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function unregisterSubscriberTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $topic = 'topic110546223';
        $expectedResponse = new UnregisterSubscriberResponse();
        $expectedResponse->setTopic($topic);
        $transport->addResponse($expectedResponse);
        // Mock request
        $account = 'account-1177318867';
        $serviceAccount = 'serviceAccount-1948028253';
        $request = (new UnregisterSubscriberRequest())->setAccount($account)->setServiceAccount($serviceAccount);
        $response = $gapicClient->unregisterSubscriber($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/UnregisterSubscriber', $actualFuncCall);
        $actualValue = $actualRequestObject->getAccount();
        $this->assertProtobufEquals($account, $actualValue);
        $actualValue = $actualRequestObject->getServiceAccount();
        $this->assertProtobufEquals($serviceAccount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function unregisterSubscriberExceptionTest()
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
        $account = 'account-1177318867';
        $serviceAccount = 'serviceAccount-1948028253';
        $request = (new UnregisterSubscriberRequest())->setAccount($account)->setServiceAccount($serviceAccount);
        try {
            $gapicClient->unregisterSubscriber($request);
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
    public function updateChannelPartnerLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $resellerCloudIdentityId = 'resellerCloudIdentityId1410814373';
        $inviteLinkUri = 'inviteLinkUri633336861';
        $publicId = 'publicId1446918833';
        $expectedResponse = new ChannelPartnerLink();
        $expectedResponse->setName($name2);
        $expectedResponse->setResellerCloudIdentityId($resellerCloudIdentityId);
        $expectedResponse->setInviteLinkUri($inviteLinkUri);
        $expectedResponse->setPublicId($publicId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $channelPartnerLink = new ChannelPartnerLink();
        $channelPartnerLinkResellerCloudIdentityId = 'channelPartnerLinkResellerCloudIdentityId-321778211';
        $channelPartnerLink->setResellerCloudIdentityId($channelPartnerLinkResellerCloudIdentityId);
        $channelPartnerLinkLinkState = ChannelPartnerLinkState::CHANNEL_PARTNER_LINK_STATE_UNSPECIFIED;
        $channelPartnerLink->setLinkState($channelPartnerLinkLinkState);
        $updateMask = new FieldMask();
        $request = (new UpdateChannelPartnerLinkRequest())
            ->setName($name)
            ->setChannelPartnerLink($channelPartnerLink)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateChannelPartnerLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/UpdateChannelPartnerLink', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getChannelPartnerLink();
        $this->assertProtobufEquals($channelPartnerLink, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateChannelPartnerLinkExceptionTest()
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
        $channelPartnerLink = new ChannelPartnerLink();
        $channelPartnerLinkResellerCloudIdentityId = 'channelPartnerLinkResellerCloudIdentityId-321778211';
        $channelPartnerLink->setResellerCloudIdentityId($channelPartnerLinkResellerCloudIdentityId);
        $channelPartnerLinkLinkState = ChannelPartnerLinkState::CHANNEL_PARTNER_LINK_STATE_UNSPECIFIED;
        $channelPartnerLink->setLinkState($channelPartnerLinkLinkState);
        $updateMask = new FieldMask();
        $request = (new UpdateChannelPartnerLinkRequest())
            ->setName($name)
            ->setChannelPartnerLink($channelPartnerLink)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateChannelPartnerLink($request);
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
    public function updateChannelPartnerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new ChannelPartnerRepricingConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $channelPartnerRepricingConfig = new ChannelPartnerRepricingConfig();
        $channelPartnerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $channelPartnerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $channelPartnerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $channelPartnerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $channelPartnerRepricingConfig->setRepricingConfig($channelPartnerRepricingConfigRepricingConfig);
        $request = (new UpdateChannelPartnerRepricingConfigRequest())->setChannelPartnerRepricingConfig(
            $channelPartnerRepricingConfig
        );
        $response = $gapicClient->updateChannelPartnerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/UpdateChannelPartnerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getChannelPartnerRepricingConfig();
        $this->assertProtobufEquals($channelPartnerRepricingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateChannelPartnerRepricingConfigExceptionTest()
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
        $channelPartnerRepricingConfig = new ChannelPartnerRepricingConfig();
        $channelPartnerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $channelPartnerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $channelPartnerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $channelPartnerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $channelPartnerRepricingConfig->setRepricingConfig($channelPartnerRepricingConfigRepricingConfig);
        $request = (new UpdateChannelPartnerRepricingConfigRequest())->setChannelPartnerRepricingConfig(
            $channelPartnerRepricingConfig
        );
        try {
            $gapicClient->updateChannelPartnerRepricingConfig($request);
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
    public function updateCustomerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $orgDisplayName = 'orgDisplayName-1793830557';
        $alternateEmail = 'alternateEmail2117741463';
        $domain = 'domain-1326197564';
        $cloudIdentityId = 'cloudIdentityId-466684622';
        $languageCode = 'languageCode-412800396';
        $channelPartnerId = 'channelPartnerId-1897289554';
        $correlationId = 'correlationId2055329016';
        $expectedResponse = new Customer();
        $expectedResponse->setName($name);
        $expectedResponse->setOrgDisplayName($orgDisplayName);
        $expectedResponse->setAlternateEmail($alternateEmail);
        $expectedResponse->setDomain($domain);
        $expectedResponse->setCloudIdentityId($cloudIdentityId);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setChannelPartnerId($channelPartnerId);
        $expectedResponse->setCorrelationId($correlationId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $customer = new Customer();
        $customerOrgDisplayName = 'customerOrgDisplayName1748404327';
        $customer->setOrgDisplayName($customerOrgDisplayName);
        $customerOrgPostalAddress = new PostalAddress();
        $customer->setOrgPostalAddress($customerOrgPostalAddress);
        $customerDomain = 'customerDomain1489396290';
        $customer->setDomain($customerDomain);
        $request = (new UpdateCustomerRequest())->setCustomer($customer);
        $response = $gapicClient->updateCustomer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/UpdateCustomer', $actualFuncCall);
        $actualValue = $actualRequestObject->getCustomer();
        $this->assertProtobufEquals($customer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomerExceptionTest()
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
        $customer = new Customer();
        $customerOrgDisplayName = 'customerOrgDisplayName1748404327';
        $customer->setOrgDisplayName($customerOrgDisplayName);
        $customerOrgPostalAddress = new PostalAddress();
        $customer->setOrgPostalAddress($customerOrgPostalAddress);
        $customerDomain = 'customerDomain1489396290';
        $customer->setDomain($customerDomain);
        $request = (new UpdateCustomerRequest())->setCustomer($customer);
        try {
            $gapicClient->updateCustomer($request);
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
    public function updateCustomerRepricingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new CustomerRepricingConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $customerRepricingConfig = new CustomerRepricingConfig();
        $customerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $customerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $customerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $customerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $customerRepricingConfig->setRepricingConfig($customerRepricingConfigRepricingConfig);
        $request = (new UpdateCustomerRepricingConfigRequest())->setCustomerRepricingConfig($customerRepricingConfig);
        $response = $gapicClient->updateCustomerRepricingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.channel.v1.CloudChannelService/UpdateCustomerRepricingConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getCustomerRepricingConfig();
        $this->assertProtobufEquals($customerRepricingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomerRepricingConfigExceptionTest()
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
        $customerRepricingConfig = new CustomerRepricingConfig();
        $customerRepricingConfigRepricingConfig = new RepricingConfig();
        $repricingConfigEffectiveInvoiceMonth = new Date();
        $customerRepricingConfigRepricingConfig->setEffectiveInvoiceMonth($repricingConfigEffectiveInvoiceMonth);
        $repricingConfigAdjustment = new RepricingAdjustment();
        $customerRepricingConfigRepricingConfig->setAdjustment($repricingConfigAdjustment);
        $repricingConfigRebillingBasis = RebillingBasis::REBILLING_BASIS_UNSPECIFIED;
        $customerRepricingConfigRepricingConfig->setRebillingBasis($repricingConfigRebillingBasis);
        $customerRepricingConfig->setRepricingConfig($customerRepricingConfigRepricingConfig);
        $request = (new UpdateCustomerRepricingConfigRequest())->setCustomerRepricingConfig($customerRepricingConfig);
        try {
            $gapicClient->updateCustomerRepricingConfig($request);
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
    public function activateEntitlementAsyncTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/activateEntitlementTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $offer = 'offer105650780';
        $purchaseOrderId = 'purchaseOrderId548224298';
        $billingAccount = 'billingAccount-545871767';
        $expectedResponse = new Entitlement();
        $expectedResponse->setName($name2);
        $expectedResponse->setOffer($offer);
        $expectedResponse->setPurchaseOrderId($purchaseOrderId);
        $expectedResponse->setBillingAccount($billingAccount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/activateEntitlementTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $request = (new ActivateEntitlementRequest())->setName($name);
        $response = $gapicClient->activateEntitlementAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.channel.v1.CloudChannelService/ActivateEntitlement', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/activateEntitlementTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
