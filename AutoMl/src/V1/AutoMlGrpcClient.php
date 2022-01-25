<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC
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
namespace Google\Cloud\AutoMl\V1;

/**
 * AutoML Server API.
 *
 * The resource names are assigned by the server.
 * The server never reuses names that it has created after the resources with
 * those names are deleted.
 *
 * An ID of a resource is the last element of the item's resource name. For
 * `projects/{project_id}/locations/{location_id}/datasets/{dataset_id}`, then
 * the id for the item is `{dataset_id}`.
 *
 * Currently the only supported `location_id` is "us-central1".
 *
 * On any input that is documented to expect a string parameter in
 * snake_case or dash-case, either of those cases is accepted.
 */
class AutoMlGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a dataset.
     * @param \Google\Cloud\AutoMl\V1\CreateDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataset(\Google\Cloud\AutoMl\V1\CreateDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/CreateDataset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a dataset.
     * @param \Google\Cloud\AutoMl\V1\GetDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataset(\Google\Cloud\AutoMl\V1\GetDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/GetDataset',
        $argument,
        ['\Google\Cloud\AutoMl\V1\Dataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists datasets in a project.
     * @param \Google\Cloud\AutoMl\V1\ListDatasetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatasets(\Google\Cloud\AutoMl\V1\ListDatasetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ListDatasets',
        $argument,
        ['\Google\Cloud\AutoMl\V1\ListDatasetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a dataset.
     * @param \Google\Cloud\AutoMl\V1\UpdateDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataset(\Google\Cloud\AutoMl\V1\UpdateDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/UpdateDataset',
        $argument,
        ['\Google\Cloud\AutoMl\V1\Dataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a dataset and all of its contents.
     * Returns empty response in the
     * [response][google.longrunning.Operation.response] field when it completes,
     * and `delete_details` in the
     * [metadata][google.longrunning.Operation.metadata] field.
     * @param \Google\Cloud\AutoMl\V1\DeleteDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataset(\Google\Cloud\AutoMl\V1\DeleteDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/DeleteDataset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports data into a dataset.
     * For Tables this method can only be called on an empty Dataset.
     *
     * For Tables:
     * *   A
     * [schema_inference_version][google.cloud.automl.v1.InputConfig.params]
     *     parameter must be explicitly set.
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     * @param \Google\Cloud\AutoMl\V1\ImportDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportData(\Google\Cloud\AutoMl\V1\ImportDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ImportData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports dataset's data to the provided output location.
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     * @param \Google\Cloud\AutoMl\V1\ExportDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportData(\Google\Cloud\AutoMl\V1\ExportDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ExportData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an annotation spec.
     * @param \Google\Cloud\AutoMl\V1\GetAnnotationSpecRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAnnotationSpec(\Google\Cloud\AutoMl\V1\GetAnnotationSpecRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/GetAnnotationSpec',
        $argument,
        ['\Google\Cloud\AutoMl\V1\AnnotationSpec', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a model.
     * Returns a Model in the [response][google.longrunning.Operation.response]
     * field when it completes.
     * When you create a model, several model evaluations are created for it:
     * a global evaluation, and one evaluation for each annotation spec.
     * @param \Google\Cloud\AutoMl\V1\CreateModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateModel(\Google\Cloud\AutoMl\V1\CreateModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/CreateModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a model.
     * @param \Google\Cloud\AutoMl\V1\GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModel(\Google\Cloud\AutoMl\V1\GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/GetModel',
        $argument,
        ['\Google\Cloud\AutoMl\V1\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists models.
     * @param \Google\Cloud\AutoMl\V1\ListModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModels(\Google\Cloud\AutoMl\V1\ListModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ListModels',
        $argument,
        ['\Google\Cloud\AutoMl\V1\ListModelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a model.
     * Returns `google.protobuf.Empty` in the
     * [response][google.longrunning.Operation.response] field when it completes,
     * and `delete_details` in the
     * [metadata][google.longrunning.Operation.metadata] field.
     * @param \Google\Cloud\AutoMl\V1\DeleteModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteModel(\Google\Cloud\AutoMl\V1\DeleteModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/DeleteModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a model.
     * @param \Google\Cloud\AutoMl\V1\UpdateModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateModel(\Google\Cloud\AutoMl\V1\UpdateModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/UpdateModel',
        $argument,
        ['\Google\Cloud\AutoMl\V1\Model', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys a model. If a model is already deployed, deploying it with the
     * same parameters has no effect. Deploying with different parametrs
     * (as e.g. changing
     * [node_number][google.cloud.automl.v1p1beta.ImageObjectDetectionModelDeploymentMetadata.node_number])
     *  will reset the deployment state without pausing the model's availability.
     *
     * Only applicable for Text Classification, Image Object Detection , Tables, and Image Segmentation; all other domains manage
     * deployment automatically.
     *
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     * @param \Google\Cloud\AutoMl\V1\DeployModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployModel(\Google\Cloud\AutoMl\V1\DeployModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/DeployModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys a model. If the model is not deployed this method has no effect.
     *
     * Only applicable for Text Classification, Image Object Detection and Tables;
     * all other domains manage deployment automatically.
     *
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     * @param \Google\Cloud\AutoMl\V1\UndeployModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployModel(\Google\Cloud\AutoMl\V1\UndeployModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/UndeployModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a trained, "export-able", model to a user specified Google Cloud
     * Storage location. A model is considered export-able if and only if it has
     * an export format defined for it in
     * [ModelExportOutputConfig][google.cloud.automl.v1.ModelExportOutputConfig].
     *
     * Returns an empty response in the
     * [response][google.longrunning.Operation.response] field when it completes.
     * @param \Google\Cloud\AutoMl\V1\ExportModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportModel(\Google\Cloud\AutoMl\V1\ExportModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ExportModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a model evaluation.
     * @param \Google\Cloud\AutoMl\V1\GetModelEvaluationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModelEvaluation(\Google\Cloud\AutoMl\V1\GetModelEvaluationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/GetModelEvaluation',
        $argument,
        ['\Google\Cloud\AutoMl\V1\ModelEvaluation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists model evaluations.
     * @param \Google\Cloud\AutoMl\V1\ListModelEvaluationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModelEvaluations(\Google\Cloud\AutoMl\V1\ListModelEvaluationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.automl.v1.AutoMl/ListModelEvaluations',
        $argument,
        ['\Google\Cloud\AutoMl\V1\ListModelEvaluationsResponse', 'decode'],
        $metadata, $options);
    }

}
