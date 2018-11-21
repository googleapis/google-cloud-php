<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC.
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
//
namespace Google\Cloud\Vision\V1;

/**
 * Manages Products and ProductSets of reference images for use in product
 * search. It uses the following resource model:
 *
 * - The API has a collection of [ProductSet][google.cloud.vision.v1.ProductSet] resources, named
 * `projects/&#42;/locations/&#42;/productSets/*`, which acts as a way to put different
 * products into groups to limit identification.
 *
 * In parallel,
 *
 * - The API has a collection of [Product][google.cloud.vision.v1.Product] resources, named
 *   `projects/&#42;/locations/&#42;/products/*`
 *
 * - Each [Product][google.cloud.vision.v1.Product] has a collection of [ReferenceImage][google.cloud.vision.v1.ReferenceImage] resources, named
 *   `projects/&#42;/locations/&#42;/products/&#42;/referenceImages/*`
 */
class ProductSearchGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates and returns a new ProductSet resource.
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if display_name is missing, or is longer than
     *   4096 characters.
     * @param \Google\Cloud\Vision\V1\CreateProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateProductSet(\Google\Cloud\Vision\V1\CreateProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/CreateProductSet',
        $argument,
        ['\Google\Cloud\Vision\V1\ProductSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ProductSets in an unspecified order.
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if page_size is greater than 100, or less
     *   than 1.
     * @param \Google\Cloud\Vision\V1\ListProductSetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListProductSets(\Google\Cloud\Vision\V1\ListProductSetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/ListProductSets',
        $argument,
        ['\Google\Cloud\Vision\V1\ListProductSetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information associated with a ProductSet.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the ProductSet does not exist.
     * @param \Google\Cloud\Vision\V1\GetProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetProductSet(\Google\Cloud\Vision\V1\GetProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/GetProductSet',
        $argument,
        ['\Google\Cloud\Vision\V1\ProductSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Makes changes to a ProductSet resource.
     * Only display_name can be updated currently.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the ProductSet does not exist.
     * * Returns INVALID_ARGUMENT if display_name is present in update_mask but
     *   missing from the request or longer than 4096 characters.
     * @param \Google\Cloud\Vision\V1\UpdateProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateProductSet(\Google\Cloud\Vision\V1\UpdateProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/UpdateProductSet',
        $argument,
        ['\Google\Cloud\Vision\V1\ProductSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently deletes a ProductSet. Products and ReferenceImages in the
     * ProductSet are not deleted.
     *
     * The actual image files are not deleted from Google Cloud Storage.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the ProductSet does not exist.
     * @param \Google\Cloud\Vision\V1\DeleteProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteProductSet(\Google\Cloud\Vision\V1\DeleteProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/DeleteProductSet',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates and returns a new product resource.
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if display_name is missing or longer than 4096
     *   characters.
     * * Returns INVALID_ARGUMENT if description is longer than 4096 characters.
     * * Returns INVALID_ARGUMENT if product_category is missing or invalid.
     * @param \Google\Cloud\Vision\V1\CreateProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateProduct(\Google\Cloud\Vision\V1\CreateProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/CreateProduct',
        $argument,
        ['\Google\Cloud\Vision\V1\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists products in an unspecified order.
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if page_size is greater than 100 or less than 1.
     * @param \Google\Cloud\Vision\V1\ListProductsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListProducts(\Google\Cloud\Vision\V1\ListProductsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/ListProducts',
        $argument,
        ['\Google\Cloud\Vision\V1\ListProductsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information associated with a Product.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the Product does not exist.
     * @param \Google\Cloud\Vision\V1\GetProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetProduct(\Google\Cloud\Vision\V1\GetProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/GetProduct',
        $argument,
        ['\Google\Cloud\Vision\V1\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Makes changes to a Product resource.
     * Only the `display_name`, `description`, and `labels` fields can be updated
     * right now.
     *
     * If labels are updated, the change will not be reflected in queries until
     * the next index time.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the Product does not exist.
     * * Returns INVALID_ARGUMENT if display_name is present in update_mask but is
     *   missing from the request or longer than 4096 characters.
     * * Returns INVALID_ARGUMENT if description is present in update_mask but is
     *   longer than 4096 characters.
     * * Returns INVALID_ARGUMENT if product_category is present in update_mask.
     * @param \Google\Cloud\Vision\V1\UpdateProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateProduct(\Google\Cloud\Vision\V1\UpdateProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/UpdateProduct',
        $argument,
        ['\Google\Cloud\Vision\V1\Product', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently deletes a product and its reference images.
     *
     * Metadata of the product and all its images will be deleted right away, but
     * search queries against ProductSets containing the product may still work
     * until all related caches are refreshed.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the product does not exist.
     * @param \Google\Cloud\Vision\V1\DeleteProductRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteProduct(\Google\Cloud\Vision\V1\DeleteProductRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/DeleteProduct',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates and returns a new ReferenceImage resource.
     *
     * The `bounding_poly` field is optional. If `bounding_poly` is not specified,
     * the system will try to detect regions of interest in the image that are
     * compatible with the product_category on the parent product. If it is
     * specified, detection is ALWAYS skipped. The system converts polygons into
     * non-rotated rectangles.
     *
     * Note that the pipeline will resize the image if the image resolution is too
     * large to process (above 50MP).
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if the image_uri is missing or longer than 4096
     *   characters.
     * * Returns INVALID_ARGUMENT if the product does not exist.
     * * Returns INVALID_ARGUMENT if bounding_poly is not provided, and nothing
     *   compatible with the parent product's product_category is detected.
     * * Returns INVALID_ARGUMENT if bounding_poly contains more than 10 polygons.
     * @param \Google\Cloud\Vision\V1\CreateReferenceImageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateReferenceImage(\Google\Cloud\Vision\V1\CreateReferenceImageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/CreateReferenceImage',
        $argument,
        ['\Google\Cloud\Vision\V1\ReferenceImage', 'decode'],
        $metadata, $options);
    }

    /**
     * Permanently deletes a reference image.
     *
     * The image metadata will be deleted right away, but search queries
     * against ProductSets containing the image may still work until all related
     * caches are refreshed.
     *
     * The actual image files are not deleted from Google Cloud Storage.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the reference image does not exist.
     * @param \Google\Cloud\Vision\V1\DeleteReferenceImageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteReferenceImage(\Google\Cloud\Vision\V1\DeleteReferenceImageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/DeleteReferenceImage',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists reference images.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the parent product does not exist.
     * * Returns INVALID_ARGUMENT if the page_size is greater than 100, or less
     *   than 1.
     * @param \Google\Cloud\Vision\V1\ListReferenceImagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListReferenceImages(\Google\Cloud\Vision\V1\ListReferenceImagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/ListReferenceImages',
        $argument,
        ['\Google\Cloud\Vision\V1\ListReferenceImagesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information associated with a ReferenceImage.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the specified image does not exist.
     * @param \Google\Cloud\Vision\V1\GetReferenceImageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetReferenceImage(\Google\Cloud\Vision\V1\GetReferenceImageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/GetReferenceImage',
        $argument,
        ['\Google\Cloud\Vision\V1\ReferenceImage', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a Product to the specified ProductSet. If the Product is already
     * present, no change is made.
     *
     * One Product can be added to at most 100 ProductSets.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND if the Product or the ProductSet doesn't exist.
     * @param \Google\Cloud\Vision\V1\AddProductToProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AddProductToProductSet(\Google\Cloud\Vision\V1\AddProductToProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/AddProductToProductSet',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a Product from the specified ProductSet.
     *
     * Possible errors:
     *
     * * Returns NOT_FOUND If the Product is not found under the ProductSet.
     * @param \Google\Cloud\Vision\V1\RemoveProductFromProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RemoveProductFromProductSet(\Google\Cloud\Vision\V1\RemoveProductFromProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/RemoveProductFromProductSet',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the Products in a ProductSet, in an unspecified order. If the
     * ProductSet does not exist, the products field of the response will be
     * empty.
     *
     * Possible errors:
     *
     * * Returns INVALID_ARGUMENT if page_size is greater than 100 or less than 1.
     * @param \Google\Cloud\Vision\V1\ListProductsInProductSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListProductsInProductSet(\Google\Cloud\Vision\V1\ListProductsInProductSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/ListProductsInProductSet',
        $argument,
        ['\Google\Cloud\Vision\V1\ListProductsInProductSetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Asynchronous API that imports a list of reference images to specified
     * product sets based on a list of image information.
     *
     * The [google.longrunning.Operation][google.longrunning.Operation] API can be used to keep track of the
     * progress and results of the request.
     * `Operation.metadata` contains `BatchOperationMetadata`. (progress)
     * `Operation.response` contains `ImportProductSetsResponse`. (results)
     *
     * The input source of this method is a csv file on Google Cloud Storage.
     * For the format of the csv file please see
     * [ImportProductSetsGcsSource.csv_file_uri][google.cloud.vision.v1.ImportProductSetsGcsSource.csv_file_uri].
     * @param \Google\Cloud\Vision\V1\ImportProductSetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ImportProductSets(\Google\Cloud\Vision\V1\ImportProductSetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vision.v1.ProductSearch/ImportProductSets',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
