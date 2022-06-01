<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Retail\V2;

/**
 * Service for ingesting [Product][google.cloud.retail.v2.Product] information
 * of the customer's website.
 */
class ProductServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a [Product][google.cloud.retail.v2.Product].
     * @param \Google\Cloud\Retail\V2\CreateProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateProduct(\Google\Cloud\Retail\V2\CreateProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/CreateProduct',
        $argument,
        ['\Google\Cloud\Retail\V2\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a [Product][google.cloud.retail.v2.Product].
     * @param \Google\Cloud\Retail\V2\GetProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProduct(\Google\Cloud\Retail\V2\GetProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/GetProduct',
        $argument,
        ['\Google\Cloud\Retail\V2\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a list of [Product][google.cloud.retail.v2.Product]s.
     * @param \Google\Cloud\Retail\V2\ListProductsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListProducts(\Google\Cloud\Retail\V2\ListProductsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/ListProducts',
        $argument,
        ['\Google\Cloud\Retail\V2\ListProductsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a [Product][google.cloud.retail.v2.Product].
     * @param \Google\Cloud\Retail\V2\UpdateProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateProduct(\Google\Cloud\Retail\V2\UpdateProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/UpdateProduct',
        $argument,
        ['\Google\Cloud\Retail\V2\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a [Product][google.cloud.retail.v2.Product].
     * @param \Google\Cloud\Retail\V2\DeleteProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteProduct(\Google\Cloud\Retail\V2\DeleteProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/DeleteProduct',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Bulk import of multiple [Product][google.cloud.retail.v2.Product]s.
     *
     * Request processing may be synchronous.
     * Non-existing items are created.
     *
     * Note that it is possible for a subset of the
     * [Product][google.cloud.retail.v2.Product]s to be successfully updated.
     * @param \Google\Cloud\Retail\V2\ImportProductsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportProducts(\Google\Cloud\Retail\V2\ImportProductsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/ImportProducts',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates inventory information for a
     * [Product][google.cloud.retail.v2.Product] while respecting the last update
     * timestamps of each inventory field.
     *
     * This process is asynchronous and does not require the
     * [Product][google.cloud.retail.v2.Product] to exist before updating
     * fulfillment information. If the request is valid, the update will be
     * enqueued and processed downstream. As a consequence, when a response is
     * returned, updates are not immediately manifested in the
     * [Product][google.cloud.retail.v2.Product] queried by
     * [GetProduct][google.cloud.retail.v2.ProductService.GetProduct] or
     * [ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
     *
     * When inventory is updated with
     * [CreateProduct][google.cloud.retail.v2.ProductService.CreateProduct] and
     * [UpdateProduct][google.cloud.retail.v2.ProductService.UpdateProduct], the
     * specified inventory field value(s) will overwrite any existing value(s)
     * while ignoring the last update time for this field. Furthermore, the last
     * update time for the specified inventory fields will be overwritten to the
     * time of the
     * [CreateProduct][google.cloud.retail.v2.ProductService.CreateProduct] or
     * [UpdateProduct][google.cloud.retail.v2.ProductService.UpdateProduct]
     * request.
     *
     * If no inventory fields are set in
     * [CreateProductRequest.product][google.cloud.retail.v2.CreateProductRequest.product],
     * then any pre-existing inventory information for this product will be used.
     *
     * If no inventory fields are set in
     * [SetInventoryRequest.set_mask][google.cloud.retail.v2.SetInventoryRequest.set_mask],
     * then any existing inventory information will be preserved.
     *
     * Pre-existing inventory information can only be updated with
     * [SetInventory][google.cloud.retail.v2.ProductService.SetInventory],
     * [ProductService.AddFulfillmentPlaces][google.cloud.retail.v2.ProductService.AddFulfillmentPlaces],
     * and
     * [RemoveFulfillmentPlaces][google.cloud.retail.v2.ProductService.RemoveFulfillmentPlaces].
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\SetInventoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetInventory(\Google\Cloud\Retail\V2\SetInventoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/SetInventory',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Incrementally adds place IDs to
     * [Product.fulfillment_info.place_ids][google.cloud.retail.v2.FulfillmentInfo.place_ids].
     *
     * This process is asynchronous and does not require the
     * [Product][google.cloud.retail.v2.Product] to exist before updating
     * fulfillment information. If the request is valid, the update will be
     * enqueued and processed downstream. As a consequence, when a response is
     * returned, the added place IDs are not immediately manifested in the
     * [Product][google.cloud.retail.v2.Product] queried by
     * [GetProduct][google.cloud.retail.v2.ProductService.GetProduct] or
     * [ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\AddFulfillmentPlacesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddFulfillmentPlaces(\Google\Cloud\Retail\V2\AddFulfillmentPlacesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/AddFulfillmentPlaces',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Incrementally removes place IDs from a
     * [Product.fulfillment_info.place_ids][google.cloud.retail.v2.FulfillmentInfo.place_ids].
     *
     * This process is asynchronous and does not require the
     * [Product][google.cloud.retail.v2.Product] to exist before updating
     * fulfillment information. If the request is valid, the update will be
     * enqueued and processed downstream. As a consequence, when a response is
     * returned, the removed place IDs are not immediately manifested in the
     * [Product][google.cloud.retail.v2.Product] queried by
     * [GetProduct][google.cloud.retail.v2.ProductService.GetProduct] or
     * [ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\RemoveFulfillmentPlacesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveFulfillmentPlaces(\Google\Cloud\Retail\V2\RemoveFulfillmentPlacesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/RemoveFulfillmentPlaces',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates local inventory information for a
     * [Product][google.cloud.retail.v2.Product] at a list of places, while
     * respecting the last update timestamps of each inventory field.
     *
     * This process is asynchronous and does not require the
     * [Product][google.cloud.retail.v2.Product] to exist before updating
     * inventory information. If the request is valid, the update will be enqueued
     * and processed downstream. As a consequence, when a response is returned,
     * updates are not immediately manifested in the
     * [Product][google.cloud.retail.v2.Product] queried by
     * [GetProduct][google.cloud.retail.v2.ProductService.GetProduct] or
     * [ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
     *
     * Local inventory information can only be modified using this method.
     * [CreateProduct][google.cloud.retail.v2.ProductService.CreateProduct] and
     * [UpdateProduct][google.cloud.retail.v2.ProductService.UpdateProduct] has no
     * effect on local inventories.
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\AddLocalInventoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddLocalInventories(\Google\Cloud\Retail\V2\AddLocalInventoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/AddLocalInventories',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Remove local inventory information for a
     * [Product][google.cloud.retail.v2.Product] at a list of places at a removal
     * timestamp.
     *
     * This process is asynchronous. If the request is valid, the removal will be
     * enqueued and processed downstream. As a consequence, when a response is
     * returned, removals are not immediately manifested in the
     * [Product][google.cloud.retail.v2.Product] queried by
     * [GetProduct][google.cloud.retail.v2.ProductService.GetProduct] or
     * [ListProducts][google.cloud.retail.v2.ProductService.ListProducts].
     *
     * Local inventory information can only be removed using this method.
     * [CreateProduct][google.cloud.retail.v2.ProductService.CreateProduct] and
     * [UpdateProduct][google.cloud.retail.v2.ProductService.UpdateProduct] has no
     * effect on local inventories.
     *
     * This feature is only available for users who have Retail Search enabled.
     * Please enable Retail Search on Cloud Console before using this feature.
     * @param \Google\Cloud\Retail\V2\RemoveLocalInventoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveLocalInventories(\Google\Cloud\Retail\V2\RemoveLocalInventoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ProductService/RemoveLocalInventories',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
