<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
namespace Google\Cloud\DataLabeling\V1beta1;

/**
 * Service for the AI Platform Data Labeling API.
 */
class DataLabelingServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates dataset. If success return a Dataset resource.
     * @param \Google\Cloud\DataLabeling\V1beta1\CreateDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataset(\Google\Cloud\DataLabeling\V1beta1\CreateDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/CreateDataset',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\Dataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets dataset by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataset(\Google\Cloud\DataLabeling\V1beta1\GetDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetDataset',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\Dataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists datasets under a project. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListDatasetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatasets(\Google\Cloud\DataLabeling\V1beta1\ListDatasetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListDatasets',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListDatasetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a dataset by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\DeleteDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataset(\Google\Cloud\DataLabeling\V1beta1\DeleteDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/DeleteDataset',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports data into dataset based on source locations defined in request.
     * It can be called multiple times for the same dataset. Each dataset can
     * only have one long running operation running on it. For example, no
     * labeling task (also long running operation) can be started while
     * importing is still ongoing. Vice versa.
     * @param \Google\Cloud\DataLabeling\V1beta1\ImportDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportData(\Google\Cloud\DataLabeling\V1beta1\ImportDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ImportData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports data and annotations from dataset.
     * @param \Google\Cloud\DataLabeling\V1beta1\ExportDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportData(\Google\Cloud\DataLabeling\V1beta1\ExportDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ExportData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a data item in a dataset by resource name. This API can be
     * called after data are imported into dataset.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetDataItemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataItem(\Google\Cloud\DataLabeling\V1beta1\GetDataItemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetDataItem',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\DataItem', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists data items in a dataset. This API can be called after data
     * are imported into dataset. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListDataItemsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataItems(\Google\Cloud\DataLabeling\V1beta1\ListDataItemsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListDataItems',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListDataItemsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an annotated dataset by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetAnnotatedDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAnnotatedDataset(\Google\Cloud\DataLabeling\V1beta1\GetAnnotatedDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetAnnotatedDataset',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\AnnotatedDataset', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists annotated datasets for a dataset. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListAnnotatedDatasetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAnnotatedDatasets(\Google\Cloud\DataLabeling\V1beta1\ListAnnotatedDatasetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListAnnotatedDatasets',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListAnnotatedDatasetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an annotated dataset by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\DeleteAnnotatedDatasetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAnnotatedDataset(\Google\Cloud\DataLabeling\V1beta1\DeleteAnnotatedDatasetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/DeleteAnnotatedDataset',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a labeling task for image. The type of image labeling task is
     * configured by feature in the request.
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelImageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LabelImage(\Google\Cloud\DataLabeling\V1beta1\LabelImageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/LabelImage',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a labeling task for video. The type of video labeling task is
     * configured by feature in the request.
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelVideoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LabelVideo(\Google\Cloud\DataLabeling\V1beta1\LabelVideoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/LabelVideo',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a labeling task for text. The type of text labeling task is
     * configured by feature in the request.
     * @param \Google\Cloud\DataLabeling\V1beta1\LabelTextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LabelText(\Google\Cloud\DataLabeling\V1beta1\LabelTextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/LabelText',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an example by resource name, including both data and annotation.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetExampleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExample(\Google\Cloud\DataLabeling\V1beta1\GetExampleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetExample',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\Example', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists examples in an annotated dataset. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListExamplesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExamples(\Google\Cloud\DataLabeling\V1beta1\ListExamplesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListExamples',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListExamplesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an annotation spec set by providing a set of labels.
     * @param \Google\Cloud\DataLabeling\V1beta1\CreateAnnotationSpecSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAnnotationSpecSet(\Google\Cloud\DataLabeling\V1beta1\CreateAnnotationSpecSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/CreateAnnotationSpecSet',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\AnnotationSpecSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an annotation spec set by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetAnnotationSpecSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAnnotationSpecSet(\Google\Cloud\DataLabeling\V1beta1\GetAnnotationSpecSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetAnnotationSpecSet',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\AnnotationSpecSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists annotation spec sets for a project. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListAnnotationSpecSetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAnnotationSpecSets(\Google\Cloud\DataLabeling\V1beta1\ListAnnotationSpecSetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListAnnotationSpecSets',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListAnnotationSpecSetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an annotation spec set by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\DeleteAnnotationSpecSetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAnnotationSpecSet(\Google\Cloud\DataLabeling\V1beta1\DeleteAnnotationSpecSetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/DeleteAnnotationSpecSet',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an instruction for how data should be labeled.
     * @param \Google\Cloud\DataLabeling\V1beta1\CreateInstructionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstruction(\Google\Cloud\DataLabeling\V1beta1\CreateInstructionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/CreateInstruction',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an instruction by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetInstructionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstruction(\Google\Cloud\DataLabeling\V1beta1\GetInstructionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetInstruction',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\Instruction', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists instructions for a project. Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListInstructionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstructions(\Google\Cloud\DataLabeling\V1beta1\ListInstructionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListInstructions',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListInstructionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an instruction object by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\DeleteInstructionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstruction(\Google\Cloud\DataLabeling\V1beta1\DeleteInstructionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/DeleteInstruction',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an evaluation by resource name (to search, use
     * [projects.evaluations.search][google.cloud.datalabeling.v1beta1.DataLabelingService.SearchEvaluations]).
     * @param \Google\Cloud\DataLabeling\V1beta1\GetEvaluationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEvaluation(\Google\Cloud\DataLabeling\V1beta1\GetEvaluationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetEvaluation',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\Evaluation', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches [evaluations][google.cloud.datalabeling.v1beta1.Evaluation] within a project.
     * @param \Google\Cloud\DataLabeling\V1beta1\SearchEvaluationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchEvaluations(\Google\Cloud\DataLabeling\V1beta1\SearchEvaluationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/SearchEvaluations',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\SearchEvaluationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches example comparisons from an evaluation. The return format is a
     * list of example comparisons that show ground truth and prediction(s) for
     * a single input. Search by providing an evaluation ID.
     * @param \Google\Cloud\DataLabeling\V1beta1\SearchExampleComparisonsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchExampleComparisons(\Google\Cloud\DataLabeling\V1beta1\SearchExampleComparisonsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/SearchExampleComparisons',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\SearchExampleComparisonsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an evaluation job.
     * @param \Google\Cloud\DataLabeling\V1beta1\CreateEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\CreateEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/CreateEvaluationJob',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\EvaluationJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an evaluation job. You can only update certain fields of the job's
     * [EvaluationJobConfig][google.cloud.datalabeling.v1beta1.EvaluationJobConfig]: `humanAnnotationConfig.instruction`,
     * `exampleCount`, and `exampleSamplePercentage`.
     *
     * If you want to change any other aspect of the evaluation job, you must
     * delete the job and create a new one.
     * @param \Google\Cloud\DataLabeling\V1beta1\UpdateEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\UpdateEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/UpdateEvaluationJob',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\EvaluationJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an evaluation job by resource name.
     * @param \Google\Cloud\DataLabeling\V1beta1\GetEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\GetEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/GetEvaluationJob',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\EvaluationJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses an evaluation job. Pausing an evaluation job that is already in a
     * `PAUSED` state is a no-op.
     * @param \Google\Cloud\DataLabeling\V1beta1\PauseEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\PauseEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/PauseEvaluationJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Resumes a paused evaluation job. A deleted evaluation job can't be resumed.
     * Resuming a running or scheduled evaluation job is a no-op.
     * @param \Google\Cloud\DataLabeling\V1beta1\ResumeEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\ResumeEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ResumeEvaluationJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops and deletes an evaluation job.
     * @param \Google\Cloud\DataLabeling\V1beta1\DeleteEvaluationJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEvaluationJob(\Google\Cloud\DataLabeling\V1beta1\DeleteEvaluationJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/DeleteEvaluationJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all evaluation jobs within a project with possible filters.
     * Pagination is supported.
     * @param \Google\Cloud\DataLabeling\V1beta1\ListEvaluationJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEvaluationJobs(\Google\Cloud\DataLabeling\V1beta1\ListEvaluationJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datalabeling.v1beta1.DataLabelingService/ListEvaluationJobs',
        $argument,
        ['\Google\Cloud\DataLabeling\V1beta1\ListEvaluationJobsResponse', 'decode'],
        $metadata, $options);
    }

}
