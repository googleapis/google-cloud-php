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
namespace Google\Cloud\ContactCenterInsights\V1;

/**
 * An API that lets users analyze and explore their business conversation data.
 */
class ContactCenterInsightsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a conversation.
     * @param \Google\Cloud\ContactCenterInsights\V1\CreateConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConversation(\Google\Cloud\ContactCenterInsights\V1\CreateConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CreateConversation',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a conversation.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdateConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConversation(\Google\Cloud\ContactCenterInsights\V1\UpdateConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdateConversation',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a conversation.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConversation(\Google\Cloud\ContactCenterInsights\V1\GetConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetConversation',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Conversation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists conversations.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListConversationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConversations(\Google\Cloud\ContactCenterInsights\V1\ListConversationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListConversations',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListConversationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a conversation.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeleteConversationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConversation(\Google\Cloud\ContactCenterInsights\V1\DeleteConversationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeleteConversation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an analysis. The long running operation is done when the analysis
     * has completed.
     * @param \Google\Cloud\ContactCenterInsights\V1\CreateAnalysisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAnalysis(\Google\Cloud\ContactCenterInsights\V1\CreateAnalysisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CreateAnalysis',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an analysis.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetAnalysisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAnalysis(\Google\Cloud\ContactCenterInsights\V1\GetAnalysisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetAnalysis',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Analysis', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists analyses.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListAnalysesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAnalyses(\Google\Cloud\ContactCenterInsights\V1\ListAnalysesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListAnalyses',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListAnalysesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an analysis.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeleteAnalysisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAnalysis(\Google\Cloud\ContactCenterInsights\V1\DeleteAnalysisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeleteAnalysis',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Export insights data to a destination defined in the request body.
     * @param \Google\Cloud\ContactCenterInsights\V1\ExportInsightsDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportInsightsData(\Google\Cloud\ContactCenterInsights\V1\ExportInsightsDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ExportInsightsData',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an issue model.
     * @param \Google\Cloud\ContactCenterInsights\V1\CreateIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateIssueModel(\Google\Cloud\ContactCenterInsights\V1\CreateIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CreateIssueModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an issue model.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdateIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIssueModel(\Google\Cloud\ContactCenterInsights\V1\UpdateIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdateIssueModel',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\IssueModel', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an issue model.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIssueModel(\Google\Cloud\ContactCenterInsights\V1\GetIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetIssueModel',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\IssueModel', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists issue models.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListIssueModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIssueModels(\Google\Cloud\ContactCenterInsights\V1\ListIssueModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListIssueModels',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListIssueModelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an issue model.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeleteIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteIssueModel(\Google\Cloud\ContactCenterInsights\V1\DeleteIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeleteIssueModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deploys an issue model. Returns an error if a model is already deployed.
     * An issue model can only be used in analysis after it has been deployed.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeployIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeployIssueModel(\Google\Cloud\ContactCenterInsights\V1\DeployIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeployIssueModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeploys an issue model.
     * An issue model can not be used in analysis after it has been undeployed.
     * @param \Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeployIssueModel(\Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UndeployIssueModel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an issue.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetIssueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIssue(\Google\Cloud\ContactCenterInsights\V1\GetIssueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetIssue',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Issue', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists issues.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListIssuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListIssues(\Google\Cloud\ContactCenterInsights\V1\ListIssuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListIssues',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListIssuesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an issue.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdateIssueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIssue(\Google\Cloud\ContactCenterInsights\V1\UpdateIssueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdateIssue',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Issue', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an issue model's statistics.
     * @param \Google\Cloud\ContactCenterInsights\V1\CalculateIssueModelStatsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CalculateIssueModelStats(\Google\Cloud\ContactCenterInsights\V1\CalculateIssueModelStatsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CalculateIssueModelStats',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\CalculateIssueModelStatsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a phrase matcher.
     * @param \Google\Cloud\ContactCenterInsights\V1\CreatePhraseMatcherRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePhraseMatcher(\Google\Cloud\ContactCenterInsights\V1\CreatePhraseMatcherRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CreatePhraseMatcher',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\PhraseMatcher', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a phrase matcher.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetPhraseMatcherRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPhraseMatcher(\Google\Cloud\ContactCenterInsights\V1\GetPhraseMatcherRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetPhraseMatcher',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\PhraseMatcher', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists phrase matchers.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListPhraseMatchersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPhraseMatchers(\Google\Cloud\ContactCenterInsights\V1\ListPhraseMatchersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListPhraseMatchers',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListPhraseMatchersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a phrase matcher.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeletePhraseMatcherRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePhraseMatcher(\Google\Cloud\ContactCenterInsights\V1\DeletePhraseMatcherRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeletePhraseMatcher',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a phrase matcher.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdatePhraseMatcherRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePhraseMatcher(\Google\Cloud\ContactCenterInsights\V1\UpdatePhraseMatcherRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdatePhraseMatcher',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\PhraseMatcher', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets conversation statistics.
     * @param \Google\Cloud\ContactCenterInsights\V1\CalculateStatsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CalculateStats(\Google\Cloud\ContactCenterInsights\V1\CalculateStatsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CalculateStats',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\CalculateStatsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets project-level settings.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSettings(\Google\Cloud\ContactCenterInsights\V1\GetSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetSettings',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Settings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates project-level settings.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdateSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSettings(\Google\Cloud\ContactCenterInsights\V1\UpdateSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdateSettings',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\Settings', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a view.
     * @param \Google\Cloud\ContactCenterInsights\V1\CreateViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateView(\Google\Cloud\ContactCenterInsights\V1\CreateViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/CreateView',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\View', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a view.
     * @param \Google\Cloud\ContactCenterInsights\V1\GetViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetView(\Google\Cloud\ContactCenterInsights\V1\GetViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/GetView',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\View', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists views.
     * @param \Google\Cloud\ContactCenterInsights\V1\ListViewsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListViews(\Google\Cloud\ContactCenterInsights\V1\ListViewsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/ListViews',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\ListViewsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a view.
     * @param \Google\Cloud\ContactCenterInsights\V1\UpdateViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateView(\Google\Cloud\ContactCenterInsights\V1\UpdateViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/UpdateView',
        $argument,
        ['\Google\Cloud\ContactCenterInsights\V1\View', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a view.
     * @param \Google\Cloud\ContactCenterInsights\V1\DeleteViewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteView(\Google\Cloud\ContactCenterInsights\V1\DeleteViewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.contactcenterinsights.v1.ContactCenterInsights/DeleteView',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
