<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\ApigeeRegistry\V1;

/**
 * The Registry service allows teams to manage descriptions of APIs.
 */
class RegistryGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns matching APIs.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApis(\Google\Cloud\ApigeeRegistry\V1\ListApisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApis',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApisResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a specified API.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApi(\Google\Cloud\ApigeeRegistry\V1\GetApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetApi',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Api', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a specified API.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApi(\Google\Cloud\ApigeeRegistry\V1\CreateApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/CreateApi',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Api', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to modify a specified API.
     * @param \Google\Cloud\ApigeeRegistry\V1\UpdateApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApi(\Google\Cloud\ApigeeRegistry\V1\UpdateApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/UpdateApi',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Api', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a specified API and all of the resources that it
     * owns.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApi(\Google\Cloud\ApigeeRegistry\V1\DeleteApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApi',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns matching versions.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApiVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiVersions(\Google\Cloud\ApigeeRegistry\V1\ListApiVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApiVersions',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApiVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a specified version.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetApiVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApiVersion(\Google\Cloud\ApigeeRegistry\V1\GetApiVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetApiVersion',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a specified version.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateApiVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApiVersion(\Google\Cloud\ApigeeRegistry\V1\CreateApiVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/CreateApiVersion',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to modify a specified version.
     * @param \Google\Cloud\ApigeeRegistry\V1\UpdateApiVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApiVersion(\Google\Cloud\ApigeeRegistry\V1\UpdateApiVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/UpdateApiVersion',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a specified version and all of the resources that
     * it owns.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiVersion(\Google\Cloud\ApigeeRegistry\V1\DeleteApiVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApiVersion',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns matching specs.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApiSpecsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiSpecs(\Google\Cloud\ApigeeRegistry\V1\ListApiSpecsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApiSpecs',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApiSpecsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a specified spec.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetApiSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApiSpec(\Google\Cloud\ApigeeRegistry\V1\GetApiSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetApiSpec',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the contents of a specified spec.
     * If specs are stored with GZip compression, the default behavior
     * is to return the spec uncompressed (the mime_type response field
     * indicates the exact format returned).
     * @param \Google\Cloud\ApigeeRegistry\V1\GetApiSpecContentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApiSpecContents(\Google\Cloud\ApigeeRegistry\V1\GetApiSpecContentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetApiSpecContents',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a specified spec.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateApiSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApiSpec(\Google\Cloud\ApigeeRegistry\V1\CreateApiSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/CreateApiSpec',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to modify a specified spec.
     * @param \Google\Cloud\ApigeeRegistry\V1\UpdateApiSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApiSpec(\Google\Cloud\ApigeeRegistry\V1\UpdateApiSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/UpdateApiSpec',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a specified spec, all revisions, and all child
     * resources (e.g., artifacts).
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiSpec(\Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApiSpec',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a tag to a specified revision of a spec.
     * @param \Google\Cloud\ApigeeRegistry\V1\TagApiSpecRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TagApiSpecRevision(\Google\Cloud\ApigeeRegistry\V1\TagApiSpecRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/TagApiSpecRevision',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all revisions of a spec.
     * Revisions are returned in descending order of revision creation time.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApiSpecRevisionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiSpecRevisions(\Google\Cloud\ApigeeRegistry\V1\ListApiSpecRevisionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApiSpecRevisions',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApiSpecRevisionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the current revision to a specified prior revision.
     * Note that this creates a new revision with a new revision ID.
     * @param \Google\Cloud\ApigeeRegistry\V1\RollbackApiSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RollbackApiSpec(\Google\Cloud\ApigeeRegistry\V1\RollbackApiSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/RollbackApiSpec',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a revision of a spec.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiSpecRevision(\Google\Cloud\ApigeeRegistry\V1\DeleteApiSpecRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApiSpecRevision',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns matching deployments.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiDeployments(\Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApiDeployments',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a specified deployment.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetApiDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApiDeployment(\Google\Cloud\ApigeeRegistry\V1\GetApiDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetApiDeployment',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a specified deployment.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateApiDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApiDeployment(\Google\Cloud\ApigeeRegistry\V1\CreateApiDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/CreateApiDeployment',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to modify a specified deployment.
     * @param \Google\Cloud\ApigeeRegistry\V1\UpdateApiDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApiDeployment(\Google\Cloud\ApigeeRegistry\V1\UpdateApiDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/UpdateApiDeployment',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a specified deployment, all revisions, and all
     * child resources (e.g., artifacts).
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiDeployment(\Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApiDeployment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a tag to a specified revision of a
     * deployment.
     * @param \Google\Cloud\ApigeeRegistry\V1\TagApiDeploymentRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TagApiDeploymentRevision(\Google\Cloud\ApigeeRegistry\V1\TagApiDeploymentRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/TagApiDeploymentRevision',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all revisions of a deployment.
     * Revisions are returned in descending order of revision creation time.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiDeploymentRevisions(\Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListApiDeploymentRevisions',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListApiDeploymentRevisionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the current revision to a specified prior
     * revision. Note that this creates a new revision with a new revision ID.
     * @param \Google\Cloud\ApigeeRegistry\V1\RollbackApiDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RollbackApiDeployment(\Google\Cloud\ApigeeRegistry\V1\RollbackApiDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/RollbackApiDeployment',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a revision of a deployment.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRevisionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiDeploymentRevision(\Google\Cloud\ApigeeRegistry\V1\DeleteApiDeploymentRevisionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteApiDeploymentRevision',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ApiDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns matching artifacts.
     * @param \Google\Cloud\ApigeeRegistry\V1\ListArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListArtifacts(\Google\Cloud\ApigeeRegistry\V1\ListArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ListArtifacts',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\ListArtifactsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a specified artifact.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetArtifact(\Google\Cloud\ApigeeRegistry\V1\GetArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetArtifact',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the contents of a specified artifact.
     * If artifacts are stored with GZip compression, the default behavior
     * is to return the artifact uncompressed (the mime_type response field
     * indicates the exact format returned).
     * @param \Google\Cloud\ApigeeRegistry\V1\GetArtifactContentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetArtifactContents(\Google\Cloud\ApigeeRegistry\V1\GetArtifactContentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/GetArtifactContents',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a specified artifact.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateArtifact(\Google\Cloud\ApigeeRegistry\V1\CreateArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/CreateArtifact',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Used to replace a specified artifact.
     * @param \Google\Cloud\ApigeeRegistry\V1\ReplaceArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceArtifact(\Google\Cloud\ApigeeRegistry\V1\ReplaceArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/ReplaceArtifact',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a specified artifact.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteArtifact(\Google\Cloud\ApigeeRegistry\V1\DeleteArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Registry/DeleteArtifact',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
